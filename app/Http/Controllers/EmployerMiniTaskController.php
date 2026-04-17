<?php

namespace App\Http\Controllers;

use App\Models\MiniTask;
use App\Models\MiniTaskApplication;
use App\Services\GeminiService;
use Illuminate\Http\Request;

class EmployerMiniTaskController extends Controller
{
    public function index()
    {
        $tasks = MiniTask::where('employer_id', auth()->id())
            ->withCount([
                'applications',
                'applications as accepted_applications_count' => function ($q) {
                    $q->where('status', 'accepted');
                },
            ])
            ->latest()
            ->paginate(15);

        return view('employer.mini-tasks.index', compact('tasks'));
    }

    public function create()
    {
        return view('employer.mini-tasks.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'        => 'required|string|max:255',
            'description'  => 'required|string',
            'requirements' => 'nullable|string',
            'type'         => 'required|in:freelance,internship',
            'budget_min'   => 'required|integer|min:0',
            'budget_max'   => 'required|integer|min:0',
            'location'     => 'required|string|max:100',
            'work_type'    => 'required|in:online,offline,hybrid',
            'payment_type' => 'required|in:per_project,per_hour,per_month',
            'max_workers'  => 'required|integer|min:1|max:100',
            'deadline'     => 'required|date|after:today',
        ], [
            'deadline.after' => 'Hạn nộp phải sau ngày hôm nay.',
            'budget_max.min' => 'Ngân sách tối đa phải >= 0.',
        ]);

        $data['employer_id'] = auth()->id();
        $data['slug']        = MiniTask::generateUniqueSlug($data['title']);
        $data['status']      = 'open';

        // Kiểm duyệt nội dung bằng Gemini AI trước khi đăng
        try {
            $gemini = new GeminiService();
            $check  = $gemini->moderateMiniTask($data['title'], $data['description']);
            if (isset($check['passed']) && $check['passed'] === false) {
                $reason = $check['reason'] ?? 'Nội dung không phù hợp với quy tắc cộng đồng.';
                return back()
                    ->withInput()
                    ->withErrors(['description' => '🤖 AI phát hiện vi phạm: ' . $reason]);
            }
        } catch (\Throwable $e) {
            \Log::warning('[AI Moderation] ' . $e->getMessage());
            // Fail open: vẫn cho đăng nếu AI lỗi
        }

        MiniTask::create($data);

        return redirect()->route('employer.mini-tasks.index')
                         ->with('success', 'Đăng dự án thành công!');
    }

    public function edit($id)
    {
        $task = MiniTask::where('id', $id)->where('employer_id', auth()->id())->firstOrFail();
        return view('employer.mini-tasks.edit', compact('task'));
    }

    public function update(Request $request, $id)
    {
        $task = MiniTask::where('id', $id)->where('employer_id', auth()->id())->firstOrFail();

        $data = $request->validate([
            'title'        => 'required|string|max:255',
            'description'  => 'required|string',
            'requirements' => 'nullable|string',
            'type'         => 'required|in:freelance,internship',
            'budget_min'   => 'required|integer|min:0',
            'budget_max'   => 'required|integer|min:0',
            'location'     => 'required|string|max:100',
            'work_type'    => 'required|in:online,offline,hybrid',
            'payment_type' => 'required|in:per_project,per_hour,per_month',
            'max_workers'  => 'required|integer|min:1|max:100',
            'deadline'     => 'required|date',
            'is_active'    => 'nullable|boolean',
        ]);

        $data['is_active'] = $request->boolean('is_active');

        // Kiểm duyệt nội dung khi cập nhật
        try {
            $gemini = new GeminiService();
            $check  = $gemini->moderateMiniTask($data['title'], $data['description']);
            if (isset($check['passed']) && $check['passed'] === false) {
                $reason = $check['reason'] ?? 'Nội dung không phù hợp.';
                return back()
                    ->withInput()
                    ->withErrors(['description' => '🤖 AI phát hiện vi phạm: ' . $reason]);
            }
        } catch (\Throwable $e) {
            \Log::warning('[AI Moderation Update] ' . $e->getMessage());
        }

        $task->update($data);

        return redirect()->route('employer.mini-tasks.index')
                         ->with('success', 'Cập nhật dự án thành công!');
    }

    public function destroy($id)
    {
        $task = MiniTask::where('id', $id)->where('employer_id', auth()->id())->firstOrFail();
        $task->delete();
        return back()->with('success', 'Đã xóa dự án.');
    }

    // Danh sách ứng viên
    public function applications($id)
    {
        $task = MiniTask::with([
                'applications.user',
                'applications' => fn($q) => $q->orderByRaw("FIELD(status,'accepted','pending','completed','rejected')")
            ])
            ->where('id', $id)
            ->where('employer_id', auth()->id())
            ->firstOrFail();

        return view('employer.mini-tasks.applications', compact('task'));
    }

    // Chấp nhận ứng viên
    public function acceptApplication(Request $request, $applicationId)
    {
        $app  = MiniTaskApplication::findOrFail($applicationId);
        $task = MiniTask::where('id', $app->mini_task_id)
                        ->where('employer_id', auth()->id())
                        ->firstOrFail();

        if ($task->isFull()) {
            return back()->with('error', 'Dự án đã đủ số người thực hiện.');
        }

        $app->update(['status' => 'accepted']);

        // Nếu đủ người → chuyển task sang in_progress
        if ($task->acceptedApplications()->count() >= $task->max_workers) {
            $task->update(['status' => 'in_progress']);
            // Từ chối các pending còn lại nếu đã đủ người
            // (Không tự động reject để employer có thể giữ backup)
        }

        return back()->with('success', 'Đã nhận ứng viên!');
    }

    // Từ chối ứng viên
    public function rejectApplication($applicationId)
    {
        $app  = MiniTaskApplication::findOrFail($applicationId);
        MiniTask::where('id', $app->mini_task_id)->where('employer_id', auth()->id())->firstOrFail();
        $app->update(['status' => 'rejected']);
        return back()->with('success', 'Đã từ chối ứng viên.');
    }

    // Xác nhận hoàn thành và upload ảnh bill
    public function confirmPayment(Request $request, $applicationId)
    {
        $app  = MiniTaskApplication::where('id', $applicationId)->where('status', 'accepted')->firstOrFail();
        $task = MiniTask::where('id', $app->mini_task_id)->where('employer_id', auth()->id())->firstOrFail();

        $request->validate([
            'payment_amount' => 'required|integer|min:0',
            'payment_proof'  => 'required|image|mimes:jpg,jpeg,png|max:5120',
            'payment_note'   => 'nullable|string|max:500',
        ], [
            'payment_proof.required' => 'Vui lòng upload ảnh bill thanh toán.',
            'payment_proof.max'      => 'Ảnh tối đa 5MB.',
        ]);

        $proofPath = $request->file('payment_proof')->store('payment-proofs', 'public');

        $app->update([
            'status'         => 'completed',
            'payment_amount' => $request->payment_amount,
            'payment_proof'  => $proofPath,
            'payment_note'   => $request->payment_note,
            'paid_at'        => now(),
            'completed_at'   => now(),
            'progress_percentage' => 100,
        ]);

        // Nếu tất cả accepted apps đều completed → task completed
        $pendingAccepted = MiniTaskApplication::where('mini_task_id', $task->id)
            ->where('status', 'accepted')->count();
        if ($pendingAccepted === 0) {
            $task->update(['status' => 'completed']);
        }

        return back()->with('success', 'Đã xác nhận thanh toán và đánh dấu hoàn thành!');
    }
}
