<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\GeminiService;

class AccountController extends Controller
{
    // Hàm hiển thị trang account
    public function index()
    {
        return view('account');
    }

    // Hàm xử lý cập nhật thông tin
    public function updateProfile(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'phone' => 'nullable|string|max:20',
                'bank_account' => 'nullable|string|max:100',
                'bank_account_name' => 'nullable|string|max:255',
                'bank_name' => 'nullable|string|max:255',
                'bank_qr_image' => 'nullable|image|mimes:jpeg,png,jpg|max:4096',
                'avatar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            ]);

            $user = Auth::user();

            $data = [
                'name' => $request->name,
                'title' => $request->title,
                'phone' => $request->phone,
                'gender' => $request->gender,
                'dob' => $request->dob,
                'address' => $request->address,
                'bio' => $request->bio,
                'bank_account' => $request->bank_account,
                'bank_account_name' => $request->bank_account_name ? mb_strtoupper($request->bank_account_name) : null,
                'bank_name' => $request->bank_name,
            ];

            if ($request->hasFile('bank_qr_image')) {
                $data['bank_qr_image'] = $request->file('bank_qr_image')->store('bank-qr', 'public');
            }

            if ($request->hasFile('avatar')) {
                $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
            }

            $user->update($data);

            return back()->with('success', 'Cập nhật thông tin thành công!');
        } catch (\Throwable $e) {
            \Log::emergency('DEBUG ERROR: ' . $e->getMessage() . ' at ' . $e->getFile() . ':' . $e->getLine());
            throw $e;
        }
    }

    // Lấy danh sách Việc làm yêu thích từ Session
    public function savedJobs()
    {
        // Lấy mảng ID các công việc đã lưu trong session (nếu chưa có thì mặc định là mảng rỗng)
        $savedJobIds = session()->get('saved_jobs', []);

        // Truy vấn lấy ra chi tiết các công việc đó từ Database
        $jobs = \App\Models\Job::with('company')->whereIn('id', $savedJobIds)->get();

        return view('account-saved-jobs', compact('jobs'));
    }

    // Xử lý Thêm / Xóa công việc khỏi Session
    public function toggleSaveJob($id)
    {
        $savedJobs = session()->get('saved_jobs', []);

        if (in_array($id, $savedJobs)) {
            $savedJobs = array_diff($savedJobs, [$id]);
            $message = 'Đã hủy ứng tuyển công việc!'; // Đổi text ở đây
        } else {
            $savedJobs[] = $id;
            $message = 'Đã ứng tuyển công việc thành công!'; // Đổi text ở đây
        }

        session()->put('saved_jobs', $savedJobs);

        return back()->with('success', $message);
    }

    // Xử lý nộp đơn ứng tuyển
    public function applyForJob(Request $request, $id)
    {
        try {
            $request->validate([
                'cv_file' => 'required|file|mimes:pdf,doc,docx|max:5120',
                'cover_letter' => 'nullable|string|max:1000',
            ]);

            $job = \App\Models\Job::findOrFail($id);
            $user = Auth::user();

            // Kiểm tra xem đã nộp chưa
            $existingApply = \App\Models\Application::where('user_id', $user->id)
                                                    ->where('job_id', $job->id)
                                                    ->first();
            if ($existingApply) {
                return back()->with('error', 'Bạn đã ứng tuyển công việc này rồi!');
            }

            // Lưu file CV
            if ($request->hasFile('cv_file')) {
                $path = $request->file('cv_file')->store('cvs', 'public');
            } else {
                return back()->with('error', 'Vui lòng tải lên CV của bạn!');
            }

            // Tạo ứng tuyển
            $application = \App\Models\Application::create([
                'user_id'      => $user->id,
                'job_id'       => $job->id,
                'cv_path'      => $path,
                'cover_letter' => $request->cover_letter,
                'status'       => 'pending',
            ]);

            // Phân tích CV bằng Gemini AI (chỉ PDF)
            try {
                $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
                if ($ext === 'pdf') {
                    $gemini   = new GeminiService();
                    $fullPath = \Storage::disk('public')->path($path);
                    $aiResult = $gemini->analyzeCV(
                        $fullPath,
                        $request->cover_letter,
                        $job->title
                    );

                    if ($aiResult) {
                        // Nếu AI phát hiện CV giả mạo
                        if (isset($aiResult['is_fake']) && $aiResult['is_fake'] === true) {
                            $application->delete();
                            \Storage::disk('public')->delete($path);
                            
                            $reason = $aiResult['reason'] ?? 'Hồ sơ không có thông tin hợp lệ.';
                            return back()->with('error', '🤖 AI TỪ CHỐI CV: ' . $reason);
                        }

                        // Nếu CV thật, lưu tóm tắt
                        if (!empty($aiResult['summary'])) {
                            $application->update(['ai_summary' => $aiResult['summary']]);
                        }
                    }
                }
            } catch (\Throwable $e) {
                \Log::warning('[AI CV Analysis] ' . $e->getMessage());
            }

            return back()->with('success', 'Nộp đơn ứng tuyển thành công! Nhà tuyển dụng sẽ sớm liên hệ với bạn.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Re-throw ValidationException to allow normal redirect
            throw $e;
        } catch (\Exception $e) {
            \Log::error('Lỗi nộp đơn: ' . $e->getMessage());
            return back()->with('error', 'Đã xảy ra lỗi trong quá trình nộp đơn. Xin vui lòng thử lại.');
        }
    }

    // Xem danh sách việc đã ứng tuyển
    public function appliedJobs()
    {
        $user = Auth::user();
        $applications = \App\Models\Application::with('job.company')
                                ->where('user_id', $user->id)
                                ->latest()
                                ->get();

        return view('account-applied-jobs', compact('applications'));
    }
}