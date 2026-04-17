<?php

namespace App\Http\Controllers;

use App\Models\MiniTask;
use App\Models\MiniTaskApplication;
use App\Models\UserVerification;
use App\Services\GeminiService;
use Illuminate\Http\Request;

class AccountFreelanceController extends Controller
{
    // Danh sách task của user (đang apply, đang thực hiện, hoàn thành)
    public function myTasks()
    {
        $applications = MiniTaskApplication::with('miniTask.employer.company')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        $verification = UserVerification::where('user_id', auth()->id())->first();

        return view('account.freelance', compact('applications', 'verification'));
    }

    // Apply vào mini task
    public function apply(Request $request, $id)
    {
        $task = MiniTask::findOrFail($id);
        $user = auth()->user();

        // Kiểm tra task còn mở
        if ($task->status !== 'open' || !$task->is_active || $task->deadline < now()) {
            return back()->with('error', 'Dự án này không còn nhận ứng tuyển.');
        }

        // Kiểm tra thực tập cần xác thực SV
        if ($task->requiresStudentVerification() && !$user->is_student_verified) {
            return back()->with('error', 'Vị trí thực tập yêu cầu xác thực sinh viên. Vui lòng xác thực tài khoản trước.');
        }

        // Kiểm tra đã apply chưa
        if (MiniTaskApplication::where('mini_task_id', $id)->where('user_id', $user->id)->exists()) {
            return back()->with('error', 'Bạn đã ứng tuyển dự án này rồi.');
        }

        $request->validate([
            'cover_letter'    => 'nullable|string|max:2000',
            'proposed_budget' => 'nullable|integer|min:0',
            'cv_file'         => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
        ], [
            'cv_file.mimes' => 'CV chỉ chấp nhận PDF, Word hoặc ảnh (JPG, PNG).',
            'cv_file.max'   => 'File CV tối đa 5MB.',
        ]);

        $cvPath = null;
        if ($request->hasFile('cv_file')) {
            $cvPath = $request->file('cv_file')->store('mini-task-cvs', 'public');
        }

        $application = MiniTaskApplication::create([
            'mini_task_id'    => $task->id,
            'user_id'         => $user->id,
            'cover_letter'    => $request->cover_letter,
            'proposed_budget' => $request->proposed_budget,
            'cv_file'         => $cvPath,
            'status'          => 'pending',
        ]);

        // Phân tích CV bằng Gemini AI (đọc PDF)
        if ($cvPath) {
            try {
                $ext = strtolower(pathinfo($cvPath, PATHINFO_EXTENSION));
                if ($ext === 'pdf') {
                    $gemini   = new GeminiService();
                    $fullPath = \Storage::disk('public')->path($cvPath);
                    $aiResult = $gemini->analyzeCV(
                        $fullPath,
                        $request->cover_letter,
                        $task->title
                    );

                    if ($aiResult) {
                        // Nếu AI phát hiện CV giả mạo
                        if (isset($aiResult['is_fake']) && $aiResult['is_fake'] === true) {
                            $application->delete();
                            \Storage::disk('public')->delete($cvPath);
                            
                            $reason = $aiResult['reason'] ?? 'Hồ sơ không có thông tin hợp lệ.';
                            return back()->with('error', '🤖 AI TỪ CHỐI CV: ' . $reason);
                        }

                        // Nếu thật, lưu tóm tắt
                        if (!empty($aiResult['summary'])) {
                            $application->update(['ai_summary' => $aiResult['summary']]);
                        }
                    }
                }
            } catch (\Throwable $e) {
                \Log::warning('[AI Mini-Task CV Analysis] ' . $e->getMessage());
            }
        }

        return back()->with('success', 'Ứng tuyển thành công! Nhà tuyển dụng sẽ liên hệ với bạn.');
    }

    // Cập nhật tiến độ
    public function updateProgress(Request $request, $applicationId)
    {
        $application = MiniTaskApplication::where('id', $applicationId)
            ->where('user_id', auth()->id())
            ->where('status', 'accepted')
            ->firstOrFail();

        $request->validate([
            'progress_percentage' => 'required|integer|min:0|max:100',
            'progress_notes'      => 'nullable|string|max:1000',
        ]);

        $application->update([
            'progress_percentage' => $request->progress_percentage,
            'progress_notes'      => $request->progress_notes,
        ]);

        return back()->with('success', 'Đã cập nhật tiến độ thành công.');
    }

    // Form xác thực sinh viên
    public function verifyStudentForm()
    {
        $verification = UserVerification::where('user_id', auth()->id())->first();
        $user = auth()->user();
        return view('account.verify-student', compact('verification', 'user'));
    }

    // Submit xác thực
    public function verifyStudentSubmit(Request $request)
    {
        $user = auth()->user();

        if ($user->is_student_verified) {
            return back()->with('error', 'Tài khoản của bạn đã được xác thực.');
        }

        $existing = UserVerification::where('user_id', $user->id)->where('status', 'pending')->first();
        if ($existing) {
            return back()->with('error', 'Yêu cầu xác thực của bạn đang chờ admin duyệt.');
        }

        $request->validate([
            'student_id'  => 'required|string|max:50',
            'school_name' => 'required|string|max:255',
            'card_image'  => 'required|image|mimes:jpg,jpeg,png|max:4096',
        ], [
            'student_id.required'  => 'Vui lòng nhập mã sinh viên.',
            'school_name.required' => 'Vui lòng nhập tên trường.',
            'card_image.required'  => 'Vui lòng upload ảnh thẻ sinh viên.',
            'card_image.max'       => 'Ảnh tối đa 4MB.',
        ]);

        $imagePath = $request->file('card_image')->store('verifications', 'public');

        // Xóa request cũ nếu bị reject
        UserVerification::where('user_id', $user->id)->delete();

        UserVerification::create([
            'user_id'    => $user->id,
            'student_id' => $request->student_id,
            'school_name'=> $request->school_name,
            'card_image' => $imagePath,
            'status'     => 'pending',
        ]);

        // Cập nhật user bank info nếu có
        $bankData = [];
        if ($request->filled('bank_account')) $bankData['bank_account'] = $request->bank_account;
        if ($request->filled('bank_account_name')) $bankData['bank_account_name'] = mb_strtoupper($request->bank_account_name);
        if ($request->filled('bank_name'))    $bankData['bank_name']    = $request->bank_name;
        if ($request->hasFile('bank_qr_image')) {
            $bankData['bank_qr_image'] = $request->file('bank_qr_image')->store('bank-qr', 'public');
        }
        if (!empty($bankData)) $user->update($bankData);

        return back()->with('success', 'Gửi yêu cầu xác thực thành công! Admin sẽ duyệt trong 24 giờ.');
    }
}
