@extends('layouts.master')

@section('title', 'Đăng ký dành cho doanh nghiệp | MyJobCV')

@section('content')
<div class="auth-wrapper">
    <div class="auth-container employer-register-container">

        {{-- BANNER BÊN TRÁI --}}
        <div class="auth-banner employer-banner">
            <div class="employer-banner-icon">🏢</div>
            <h2>Tuyển dụng thông minh<br>cùng <span style="color:#ffd166;">MyJobCV!</span></h2>
            <p>Kết nối với hàng nghìn ứng viên tiềm năng, đăng tin tuyển dụng miễn phí và nhận CV ngay lập tức.</p>

            <ul class="auth-banner-features">
                <li>📋 Đăng tin tuyển dụng không giới hạn</li>
                <li>📥 Nhận CV ứng tuyển trực tiếp</li>
                <li>✅ Duyệt hồ sơ nhanh chóng, tiện lợi</li>
                <li>📊 Thống kê hiệu quả tuyển dụng</li>
            </ul>

            <div style="margin-top: 30px; padding: 15px; background: rgba(255,255,255,0.15); border-radius: 10px; font-size: 13px; color: rgba(255,255,255,0.9);">
                💡 Đã có tài khoản? <a href="{{ url('/login') }}" style="color: #ffd166; font-weight: 700;">Đăng nhập ngay</a>
            </div>
        </div>

        {{-- FORM BÊN PHẢI --}}
        <div class="auth-form-box">
            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 8px;">
                <span style="font-size: 28px;">🏢</span>
                <h1 class="auth-title" style="margin: 0;">Đăng ký Doanh nghiệp</h1>
            </div>
            <p class="auth-subtitle">Tạo tài khoản để bắt đầu tuyển dụng ngay hôm nay</p>

            {{-- Thông báo lỗi --}}
            @if($errors->any())
                <div style="color: #842029; background-color: #f8d7da; border: 1px solid #f5c2c7; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; font-size: 14px;">
                    <strong>⚠ Vui lòng kiểm tra lại:</strong>
                    <ul style="margin: 6px 0 0 0; padding-left: 18px;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('register.employer.post') }}" method="POST" id="employer-register-form">
                @csrf

                {{-- THÔNG TIN CÔNG TY --}}
                <div style="background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 10px; padding: 16px; margin-bottom: 20px;">
                    <div style="font-size: 13px; font-weight: 700; color: #166534; margin-bottom: 12px; text-transform: uppercase; letter-spacing: 0.5px;">
                        📋 Thông tin công ty
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="company_name">
                            Tên công ty <span style="color: #dc3545;">*</span>
                        </label>
                        <input
                            type="text"
                            id="company_name"
                            name="company_name"
                            class="form-control"
                            placeholder="Ví dụ: Công ty TNHH ABC Technology"
                            value="{{ old('company_name') }}"
                            required
                        >
                    </div>

                    <div class="form-group" style="margin-bottom: 0;">
                        <label class="form-label" for="tax_code">
                            Mã số thuế <span style="color: #dc3545;">*</span>
                        </label>
                        <input
                            type="text"
                            id="tax_code"
                            name="tax_code"
                            class="form-control"
                            placeholder="Ví dụ: 0123456789"
                            value="{{ old('tax_code') }}"
                            required
                        >
                        <small style="color: #6c757d; font-size: 12px;">Mã số thuế doanh nghiệp 10 chữ số do cơ quan thuế cấp.</small>
                    </div>
                </div>

                {{-- THÔNG TIN TÀI KHOẢN --}}
                <div style="background: #f8f9ff; border: 1px solid #c7d2fe; border-radius: 10px; padding: 16px; margin-bottom: 20px;">
                    <div style="font-size: 13px; font-weight: 700; color: #3730a3; margin-bottom: 12px; text-transform: uppercase; letter-spacing: 0.5px;">
                        🔐 Thông tin tài khoản
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="email">
                            Email công ty <span style="color: #dc3545;">*</span>
                        </label>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            class="form-control"
                            placeholder="Ví dụ: hr@company.com"
                            value="{{ old('email') }}"
                            required
                        >
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 0;">
                        <div class="form-group" style="margin-bottom: 0;">
                            <label class="form-label" for="password">
                                Mật khẩu <span style="color: #dc3545;">*</span>
                            </label>
                            <input
                                type="password"
                                id="password"
                                name="password"
                                class="form-control"
                                placeholder="Tối thiểu 6 ký tự"
                                required
                            >
                        </div>

                        <div class="form-group" style="margin-bottom: 0;">
                            <label class="form-label" for="password_confirmation">
                                Xác nhận mật khẩu <span style="color: #dc3545;">*</span>
                            </label>
                            <input
                                type="password"
                                id="password_confirmation"
                                name="password_confirmation"
                                class="form-control"
                                placeholder="Nhập lại mật khẩu"
                                required
                            >
                        </div>
                    </div>
                </div>

                {{-- ĐIỀU KHOẢN --}}
                <div class="auth-options" style="margin-bottom: 20px;">
                    <label style="display: flex; align-items: flex-start; gap: 8px;">
                        <input type="checkbox" required style="margin-top: 3px; accent-color: var(--primary);">
                        <span style="font-size: 13px; line-height: 1.5; color: var(--text-muted);">
                            Tôi xác nhận thông tin trên là chính xác và đồng ý với
                            <a href="#" style="color: var(--primary); font-weight: 600;">Điều khoản dịch vụ</a>
                            và <a href="#" style="color: var(--primary); font-weight: 600;">Chính sách bảo mật</a>.
                        </span>
                    </label>
                </div>

                <button type="submit" class="btn btn-primary btn-auth-submit" id="employer-register-btn">
                    🚀 Đăng ký doanh nghiệp
                </button>

                <div class="auth-switch" style="text-align: center; margin-top: 20px;">
                    Bạn là ứng viên?
                    <a href="{{ route('register') }}" style="color: var(--primary); font-weight: 600;">Đăng ký tài khoản ứng viên</a>
                </div>

                <div class="auth-switch" style="text-align: center; margin-top: 8px;">
                    Đã có tài khoản?
                    <a href="{{ url('/login') }}" style="color: var(--primary); font-weight: 600;">Đăng nhập ngay</a>
                </div>
            </form>
        </div>

    </div>
</div>

<style>
.employer-register-container {
    max-width: 1000px;
}

.employer-banner {
    background: linear-gradient(135deg, #00b14f 0%, #007a36 50%, #005a28 100%) !important;
}

.employer-banner-icon {
    font-size: 56px;
    margin-bottom: 20px;
    filter: drop-shadow(0 4px 12px rgba(0,0,0,0.2));
}

.employer-banner h2 {
    font-size: 26px;
    font-weight: 800;
    color: #fff;
    line-height: 1.3;
    margin-bottom: 14px;
}

.employer-banner p {
    color: rgba(255,255,255,0.88);
    line-height: 1.7;
    font-size: 14px;
    margin-bottom: 24px;
}

.employer-banner .auth-banner-features li {
    color: rgba(255,255,255,0.93);
    padding: 7px 0;
    font-size: 14px;
}

#employer-register-btn {
    width: 100%;
    padding: 14px;
    font-size: 16px;
    font-weight: 700;
    border-radius: 10px;
    background: linear-gradient(135deg, #00b14f, #00913f);
    border: none;
    box-shadow: 0 4px 15px rgba(0, 177, 79, 0.35);
    transition: all 0.3s ease;
}

#employer-register-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0, 177, 79, 0.45);
}
</style>
@endsection
