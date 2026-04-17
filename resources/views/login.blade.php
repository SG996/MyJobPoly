@extends('layouts.master')

@section('title', 'Đăng nhập | MyJobCV')

@section('content')
    <div class="auth-wrapper">
        <div class="auth-container">

            <div class="auth-banner">
                <h2>Tìm công việc mơ ước<br>phù hợp với bạn!</h2>
                <p>Khám phá hàng ngàn cơ hội việc làm từ các công ty hàng đầu, tạo CV chuyên nghiệp và tiếp cận các nhà tuyển dụng uy tín nhất.</p>

                <ul class="auth-banner-features">
                    <li>✨ Tiếp cận 30,000+ nhà tuyển dụng</li>
                    <li>🚀 Tạo CV chuẩn ATS nhanh chóng</li>
                    <li>🔒 Bảo mật thông tin tuyệt đối</li>
                </ul>
            </div>

            <div class="auth-form-box">
                <h1 class="auth-title">Chào mừng trở lại!</h1>
                <p class="auth-subtitle">Cùng xây dựng lộ trình sự nghiệp của bạn</p>

                @if($errors->any())
                    <div style="color: #dc3545; background-color: #f8d7da; padding: 10px; border-radius: 5px; margin-bottom: 15px; font-size: 14px;">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form action="{{ route('login.post') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label class="form-label" for="email">Email của bạn</label>
                        <input type="email" id="email" name="email" class="form-control" placeholder="Ví dụ: nguyenvanan@gmail.com" value="{{ old('email') }}" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="password">Mật khẩu</label>
                        <input type="password" id="password" name="password" class="form-control" placeholder="Nhập mật khẩu (từ 6-20 ký tự)" required>
                    </div>

                    <div class="auth-options">
                        <label>
                            <input type="checkbox" name="remember"> Nhớ mật khẩu
                        </label>
                        <a href="#">Quên mật khẩu?</a>
                    </div>

                    <button type="submit" class="btn btn-primary btn-auth-submit">Đăng nhập ngay</button>

                    <div class="auth-divider">Hoặc đăng nhập bằng</div>

                    <div class="social-login">
                        <a href="#" class="btn btn-social">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/5/53/Google_%22G%22_Logo.svg" alt="Google" width="20"> Google
                        </a>
                        <a href="#" class="btn btn-social">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/b/b8/2021_Facebook_icon.svg" alt="Facebook" width="20"> Facebook
                        </a>
                    </div>

                    <div class="auth-switch">
                        Chưa có tài khoản? <a href="{{ url('/register') }}">Đăng ký ngay</a>
                    </div>
                </form>
            </div>

        </div>
    </div>
@endsection