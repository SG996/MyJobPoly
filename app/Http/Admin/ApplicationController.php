<?php

namespace App\Http\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Application;

class ApplicationController extends Controller
{
    public function index()
    {
        $applications = Application::with(['user', 'job.company'])->latest()->paginate(15);
        return view('admin.applications.index', compact('applications'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,reviewed,accepted,rejected',
        ]);

        $application = Application::findOrFail($id);
        $application->update(['status' => $request->status]);

        return back()->with('success', 'Đã cập nhật trạng thái hồ sơ!');
    }
}
