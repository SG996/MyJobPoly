<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureIsEmployer
{
    /**
     * Chỉ cho phép nhà tuyển dụng (role = 2) truy cập.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để tiếp tục.');
        }

        if (auth()->user()->role != 2) {
            abort(403, 'Bạn không có quyền truy cập trang nhà tuyển dụng.');
        }

        return $next($request);
    }
}
