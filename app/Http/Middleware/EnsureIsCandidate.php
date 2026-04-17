<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureIsCandidate
{
    /**
     * Chỉ cho ứng viên (role = 0) truy cập các trang tài khoản cá nhân.
     * Nhà tuyển dụng & admin không được vào khu vực này.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để tiếp tục.');
        }

        $role = auth()->user()->role;

        if ($role == 1) {
            // Admin → về trang admin
            return redirect()->route('admin.dashboard');
        }

        if ($role == 2) {
            // Nhà tuyển dụng → về dashboard employer
            return redirect()->route('employer.dashboard');
        }

        return $next($request);
    }
}
