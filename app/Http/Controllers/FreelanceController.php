<?php

namespace App\Http\Controllers;

use App\Models\MiniTask;
use Illuminate\Http\Request;

class FreelanceController extends Controller
{
    public function index(Request $request)
    {
        $query = MiniTask::with('employer.company')
            ->where('is_active', true)
            ->where('status', 'open')
            ->where('deadline', '>', now());

        if ($request->filled('keyword')) {
            $query->where('title', 'like', '%' . $request->keyword . '%');
        }
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }
        if ($request->filled('work_type')) {
            $query->where('work_type', $request->work_type);
        }
        if ($request->filled('location')) {
            $query->where('location', 'like', '%' . $request->location . '%');
        }

        $tasks = $query->latest()->paginate(12)->withQueryString();

        return view('freelance.index', compact('tasks'));
    }

    public function show($slug)
    {
        $task = MiniTask::with(['employer.company', 'applications.user'])
            ->where('slug', $slug)
            ->firstOrFail();

        $hasApplied = false;
        $myApplication = null;

        if (auth()->check()) {
            $myApplication = $task->applications()->where('user_id', auth()->id())->first();
            $hasApplied = $myApplication !== null;
        }

        $acceptedCount = $task->applications()->where('status', 'accepted')->count();

        return view('freelance.show', compact('task', 'hasApplied', 'myApplication', 'acceptedCount'));
    }
}
