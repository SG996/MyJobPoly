<?php

namespace App\Http\Admin;

use App\Http\Controllers\Controller;
use App\Models\MiniTask;
use App\Models\MiniTaskApplication;
use App\Models\UserVerification;
use App\Models\User;
use Illuminate\Http\Request;

class MiniTaskAdminController extends Controller
{
    public function index()
    {
        $tasks = MiniTask::with('employer.company')
            ->withCount('applications')
            ->latest()
            ->paginate(20);

        $stats = [
            'total'       => MiniTask::count(),
            'open'        => MiniTask::where('status', 'open')->count(),
            'in_progress' => MiniTask::where('status', 'in_progress')->count(),
            'completed'   => MiniTask::where('status', 'completed')->count(),
        ];

        return view('admin.mini-tasks.index', compact('tasks', 'stats'));
    }

    public function toggleActive($id)
    {
        $task = MiniTask::findOrFail($id);
        $task->update(['is_active' => !$task->is_active]);
        return back()->with('success', $task->is_active ? 'Đã kích hoạt dự án.' : 'Đã ẩn dự án.');
    }

    public function destroy($id)
    {
        MiniTask::findOrFail($id)->delete();
        return back()->with('success', 'Đã xóa dự án.');
    }
}
