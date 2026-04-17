@extends('layouts.master')

@section('title', 'Cài đặt tài khoản | MyJobCV')

@section('content')
    <div class="container account-grid">

        @include('partials.account-sidebar', ['active' => 'profile'])

        <main class="account-content">
            <h1 class="account-content-title">Cài đặt thông tin cá nhân</h1>
            <p class="account-content-subtitle">Quản lý thông tin hồ sơ để nhà tuyển dụng có thể hiểu rõ hơn về bạn</p>

            @if(session('success'))
                <div style="color: #155724; background-color: #d4edda; padding: 12px; border-radius: 5px; margin-bottom: 20px; font-weight: 500;">
                    ✅ {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('account.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div style="margin-bottom: 24px; display: flex; align-items: center; gap: 20px;">
                    <div style="width: 80px; height: 80px; border-radius: 50%; background: #e2e8f0; overflow: hidden; display: flex; align-items: center; justify-content: center;">
                        @if(Auth::user()->avatar)
                            <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Avatar" style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                            <span style="font-size: 28px; color: #94a3b8; font-weight: 800;">{{ mb_substr(Auth::user()->name, 0, 1) }}</span>
                        @endif
                    </div>
                    <div>
                        <label class="form-label">Ảnh đại diện (Avatar)</label>
                        <input type="file" name="avatar" class="form-control" accept="image/*" style="padding: 6px;">
                        <small style="color: var(--text-muted); font-size: 12px;">Định dạng: JPG, PNG. Tối đa 2MB.</small>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Họ và tên <span style="color: red;">*</span></label>
                        <input type="text" name="name" class="form-control" value="{{ Auth::user()->name }}" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Chức danh</label>
                        <input type="text" name="title" class="form-control" value="{{ Auth::user()->title ?? '' }}" placeholder="Vị trí bạn đang làm">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Email <span style="color: red;">*</span></label>
                        <input type="email" class="form-control" value="{{ Auth::user()->email }}" readonly style="background-color: #f8f9fa; cursor: not-allowed;">
                        <small style="color: var(--text-muted); font-size: 12px;">Email không thể thay đổi</small>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Số điện thoại</label>
                        <input type="text" name="phone" class="form-control" value="{{ Auth::user()->phone ?? '' }}" placeholder="Số điện thoại liên hệ">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Giới tính</label>
                        <select name="gender" @readonly(true) class="form-control">
                            <option value="nam" {{ (Auth::user()->gender ?? '') == 'nam' ? 'selected' : '' }}>Nam</option>
                            <option value="nu" {{ (Auth::user()->gender ?? '') == 'nu' ? 'selected' : '' }}>Nữ</option>
                            <option value="khac" {{ (Auth::user()->gender ?? '') == 'khac' ? 'selected' : '' }}>Khác</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Địa chỉ hiện tại</label>
                    <input type="text" name="address" class="form-control" value="{{ Auth::user()->address ?? '' }}" placeholder="Nhập địa chỉ của bạn">
                </div>

                <div class="form-group">
                    <label class="form-label">Giới thiệu bản thân</label>
                    <textarea name="bio" class="form-control" rows="4" placeholder="Viết một đoạn ngắn giới thiệu về kỹ năng và định hướng của bạn...">{{ Auth::user()->bio ?? '' }}</textarea>
                </div>

                <hr style="margin: 30px 0; border: none; border-top: 1px solid #e2e8f0;">
                <h3 style="font-size: 18px; font-weight: 700; margin-bottom: 20px; color: #1e293b;">Thông tin thanh toán (Tùy chọn)</h3>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Tên ngân hàng</label>
                        <input type="text" name="bank_name" class="form-control" value="{{ Auth::user()->bank_name ?? '' }}" placeholder="Ví dụ: Vietcombank, MB Bank...">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Tên chủ tài khoản</label>
                        <input type="text" name="bank_account_name" class="form-control" value="{{ Auth::user()->bank_account_name ?? '' }}" placeholder="VI DU TEN BAN">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Số tài khoản</label>
                        <input type="text" name="bank_account" class="form-control" value="{{ Auth::user()->bank_account ?? '' }}" placeholder="Số tài khoản ngân hàng">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Ảnh QR Code nhận tiền</label>
                    @if(Auth::user()->bank_qr_image)
                        <div style="margin-bottom: 10px;">
                            <img src="{{ asset('storage/' . Auth::user()->bank_qr_image) }}" alt="QR Code" style="height: 120px; border-radius: 8px; border: 1px solid #e2e8f0;">
                        </div>
                    @endif
                    <input type="file" name="bank_qr_image" class="form-control" accept="image/*">
                    <small style="color: var(--text-muted); font-size: 12px;">Định dạng: JPG, PNG. Tối đa 4MB.</small>
                </div>

                <div style="margin-top: 30px; text-align: right;">
                    <button type="submit" class="btn btn-primary" style="padding: 12px 35px; font-size: 16px;">Lưu thay đổi</button>
                </div>
            </form>
        </main>

    </div>
@endsection