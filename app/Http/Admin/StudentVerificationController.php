<?php

namespace App\Http\Admin;

use App\Http\Controllers\Controller;
use App\Models\UserVerification;
use Illuminate\Http\Request;

class StudentVerificationController extends Controller
{
    public function index(Request $request)
    {
        $query = UserVerification::with('user')->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $verifications = $query->paginate(20);

        $stats = [
            'pending'  => UserVerification::where('status', 'pending')->count(),
            'approved' => UserVerification::where('status', 'approved')->count(),
            'rejected' => UserVerification::where('status', 'rejected')->count(),
        ];

        return view('admin.student-verifications.index', compact('verifications', 'stats'));
    }

    public function approve($id)
    {
        $v = UserVerification::findOrFail($id);
        $v->update([
            'status'      => 'approved',
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
            'admin_note'  => null,
        ]);
        $v->user->update(['is_student_verified' => true]);

        return back()->with('success', 'Đã duyệt xác thực sinh viên cho ' . $v->user->name);
    }

    public function reject(Request $request, $id)
    {
        $request->validate([
            'admin_note' => 'required|string|max:500',
        ], ['admin_note.required' => 'Vui lòng nhập lý do từ chối.']);

        $v = UserVerification::findOrFail($id);
        $v->update([
            'status'      => 'rejected',
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
            'admin_note'  => $request->admin_note,
        ]);
        $v->user->update(['is_student_verified' => false]);

        return back()->with('success', 'Đã từ chối yêu cầu xác thực.');
    }
}
