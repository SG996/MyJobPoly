<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Company;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    // ===========================================
    // ĐĂNG KÝ ỨNG VIÊN (thông thường)
    // ===========================================
    public function registerPost(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'email.unique'        => 'Email này đã được sử dụng.',
            'password.confirmed'  => 'Xác nhận mật khẩu không khớp.',
            'password.min'        => 'Mật khẩu phải từ 6 ký tự.',
        ]);

        $user = User::create([
            'name'        => $request->name,
            'email'       => $request->email,
            'password'    => Hash::make($request->password),
            'role'        => 0, // ứng viên
            'is_approved' => true, // Luôn duyệt sẵn cho ứng viên
        ]);

        Auth::login($user);
        return redirect('/')->with('success', 'Đăng ký thành công!');
    }

    // ===========================================
    // ĐĂNG KÝ NHÀ TUYỂN DỤNG (doanh nghiệp)
    // ===========================================

    /** Hiển thị form đăng ký nhà tuyển dụng */
    public function registerEmployer()
    {
        return view('register-employer');
    }

    /** Xử lý đăng ký nhà tuyển dụng */
    public function registerEmployerPost(Request $request)
    {
        $request->validate([
            'email'        => 'required|email|max:255|unique:users,email',
            'password'     => 'required|string|min:6|confirmed',
            'company_name' => 'required|string|max:255',
            'tax_code'     => 'required|string|max:50|unique:companies,tax_code',
        ], [
            'email.unique'      => 'Email này đã được sử dụng.',
            'email.required'    => 'Vui lòng nhập email công ty.',
            'password.min'      => 'Mật khẩu phải có ít nhất 6 ký tự.',
            'password.confirmed'=> 'Xác nhận mật khẩu không khớp.',
            'company_name.required' => 'Vui lòng nhập tên công ty.',
            'tax_code.required' => 'Vui lòng nhập mã số thuế.',
            'tax_code.unique'   => 'Mã số thuế này đã được đăng ký.',
        ]);

        // Dùng transaction để đảm bảo tính toàn vẹn dữ liệu
        DB::transaction(function () use ($request) {
            // 1. Tạo Công ty
            $company = Company::create([
                'name'     => $request->company_name,
                'tax_code' => $request->tax_code,
                'email'    => $request->email,
                'address'  => '',
                'hotline'  => '',
            ]);

            // 2. Tạo User là nhà tuyển dụng (role = 2)
            $user = User::create([
                'name'        => $request->company_name,
                'email'       => $request->email,
                'password'    => Hash::make($request->password),
                'role'        => 2, // nhà tuyển dụng
                'company_id'  => $company->id,
                'is_approved' => false, // Chờ admin duyệt
            ]);
        });

        return redirect()->route('login')
                         ->with('info', 'Đăng ký doanh nghiệp thành công! Vui lòng chờ Admin phê duyệt tài khoản để có thể đăng nhập.');
    }

    // ===========================================
    // ĐĂNG NHẬP
    // ===========================================
    public function loginPost(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->has('remember'))) {
            $user = Auth::user();
            
            // Chặn nếu tải khoản bị khóa hoặc chưa được duyệt
            if (!$user->is_approved) {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Tài khoản của bạn đang chờ phê duyệt hoặc đã bị khóa bởi quản trị viên.',
                ])->onlyInput('email');
            }

            $request->session()->regenerate();

            $role = $user->role;

            if ($role == 1) {
                // Admin
                return redirect()->route('admin.dashboard')->with('success', 'Chào mừng trở lại, Admin!');
            }

            if ($role == 2) {
                // Nhà tuyển dụng
                return redirect()->route('employer.dashboard')->with('success', 'Đăng nhập thành công!');
            }

            // Ứng viên (role = 0)
            return redirect('/')->with('success', 'Đăng nhập thành công!');
        }

        return back()->withErrors([
            'email' => 'Email hoặc mật khẩu không chính xác.',
        ])->onlyInput('email');
    }

    // ===========================================
    // ĐĂNG XUẤT
    // ===========================================
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
