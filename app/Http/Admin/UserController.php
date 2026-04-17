<?php

namespace App\Http\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->query('filter', 'all');

        $query = User::latest();

        if ($filter === 'pending') {
            // Chờ duyệt: Doanh nghiệp chưa được duyệt
            $query->where('role', 2)->where('is_approved', false);
        } elseif ($filter === 'approved') {
            $query->where('is_approved', true);
        } elseif ($filter === 'locked') {
            // Đã khóa: is_approved = false (bất kỳ role nào bị khóa thủ công)
            $query->where('is_approved', false)->where('role', '!=', 2)
                  ->orWhere(function($q) {
                      // Hoặc doanh nghiệp đã từng được duyệt rồi bị khóa lại
                      // Dùng where role=2 and is_approved=0 nhưng đã có in DB trước
                      $q->where('role', 2)->where('is_approved', false);
                  });
        }

        // Đếm số lượng cho badge
        $countAll      = User::count();
        $countPending  = User::where('role', 2)->where('is_approved', false)->count();
        $countApproved = User::where('is_approved', true)->count();
        $countLocked   = User::where('is_approved', false)->count();

        $users = $query->paginate(20)->withQueryString();

        return view('admin.users.index', compact('users', 'filter', 'countAll', 'countPending', 'countApproved', 'countLocked'));
    }

    public function toggleApprove($id)
    {
        $user = User::findOrFail($id);

        // Không cho khóa tài khoản Admin
        if ($user->role == 1) {
            return back()->with('error', 'Không thể khóa tài khoản Admin!');
        }

        $user->is_approved = !$user->is_approved;
        $user->save();

        $status = $user->is_approved ? 'Đã duyệt' : 'Đã khóa';
        return back()->with('success', "Cập nhật thành công: {$status}!");
    }
}
