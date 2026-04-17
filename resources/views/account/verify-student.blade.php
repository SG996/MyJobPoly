@extends('layouts.master')
@section('title', 'Xác thực sinh viên | MyJobCV')

@section('content')
<div class="container" style="max-width:640px; margin:40px auto 60px;">
    <h1 style="font-size:24px; font-weight:800; color:#1e293b; margin-bottom:6px;">🎓 Xác thực sinh viên</h1>
    <p style="color:#64748b; margin-bottom:28px; font-size:14px;">
        Xác thực giúp bạn ứng tuyển các vị trí thực tập và được ưu tiên với nhà tuyển dụng.
    </p>

    @if(session('success'))
        <div style="background:#f0fdf4; border:1px solid #bbf7d0; border-radius:8px; padding:14px 18px; margin-bottom:18px; color:#166534; font-size:14px; font-weight:600;">✅ {{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div style="background:#fef2f2; border:1px solid #fecaca; border-radius:8px; padding:14px 18px; margin-bottom:18px; color:#991b1b; font-size:14px; font-weight:600;">⚠️ {{ session('error') }}</div>
    @endif

    {{-- Trạng thái hiện tại --}}
    @if($user->is_student_verified)
        <div style="background:#f0fdf4; border:1.5px solid #86efac; border-radius:12px; padding:24px; text-align:center; margin-bottom:24px;">
            <div style="font-size:48px; margin-bottom:10px;">✅</div>
            <h2 style="color:#166534; font-size:18px; font-weight:700;">Tài khoản đã được xác thực</h2>
            <p style="color:#64748b; font-size:14px; margin-top:6px;">Bạn có thể ứng tuyển tất cả vị trí thực tập trên MyJobCV.</p>
        </div>
    @elseif($verification)
        <div style="background:{{ $verification->isPending() ? '#fffbeb' : '#fef2f2' }}; border:1.5px solid {{ $verification->isPending() ? '#fde68a' : '#fecaca' }}; border-radius:12px; padding:20px; margin-bottom:24px;">
            <div style="font-size:15px; font-weight:700; color:{{ $verification->isPending() ? '#92400e' : '#991b1b' }}; margin-bottom:6px;">
                @if($verification->isPending()) ⏳ Đang chờ admin duyệt
                @else ❌ Yêu cầu bị từ chối @endif
            </div>
            @if($verification->admin_note)
                <p style="font-size:13px; color:#64748b; margin-top:6px;">Lý do: {{ $verification->admin_note }}</p>
            @endif
            @if($verification->isRejected())
                <p style="font-size:13px; color:#64748b; margin-top:6px;">Bạn có thể gửi lại yêu cầu với thông tin đầy đủ hơn.</p>
            @endif
        </div>
    @endif

    {{-- Form -- chỉ hiện nếu chưa verified và không pending --}}
    @if(!$user->is_student_verified && (!$verification || $verification->isRejected()))
    <div class="content-block">
        <h2 style="font-size:18px; font-weight:700; color:#1e293b; margin-bottom:20px;">📋 Thông tin xác thực</h2>

        <form action="{{ route('account.verify_student.post') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div style="display:grid; gap:16px;">

                <div>
                    <label style="font-size:13px; font-weight:700; color:#1e293b; display:block; margin-bottom:6px;">Mã sinh viên <span style="color:#ef4444;">*</span></label>
                    <input type="text" name="student_id" required value="{{ old('student_id') }}"
                           placeholder="VD: 2021001234"
                           style="width:100%; padding:12px 14px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:14px;">
                    @error('student_id') <div style="color:#ef4444; font-size:12px; margin-top:4px;">{{ $message }}</div> @enderror
                </div>

                <div>
                    <label style="font-size:13px; font-weight:700; color:#1e293b; display:block; margin-bottom:6px;">Tên trường <span style="color:#ef4444;">*</span></label>
                    <input type="text" name="school_name" required value="{{ old('school_name') }}"
                           placeholder="VD: Đại học Bách Khoa Hà Nội"
                           style="width:100%; padding:12px 14px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:14px;">
                    @error('school_name') <div style="color:#ef4444; font-size:12px; margin-top:4px;">{{ $message }}</div> @enderror
                </div>

                <div>
                    <label style="font-size:13px; font-weight:700; color:#1e293b; display:block; margin-bottom:6px;">
                        Ảnh thẻ sinh viên <span style="color:#ef4444;">*</span>
                        <span style="color:#94a3b8; font-weight:400;">(JPG, PNG, tối đa 4MB)</span>
                    </label>
                    <div id="card-drop-zone" onclick="document.getElementById('card_image').click()"
                         style="border:2px dashed #e2e8f0; border-radius:10px; padding:32px; text-align:center; cursor:pointer; transition:border-color .2s;"
                         onmouseover="this.style.borderColor='#7c3aed'" onmouseout="this.style.borderColor='#e2e8f0'">
                        <div style="font-size:36px; margin-bottom:8px;">🪪</div>
                        <div style="font-size:14px; color:#64748b;">Click để chọn ảnh thẻ sinh viên</div>
                        <div id="card-filename" style="font-size:12px; color:#7c3aed; margin-top:6px; font-weight:600;"></div>
                    </div>
                    <input type="file" id="card_image" name="card_image" accept="image/*" required style="display:none;"
                           onchange="document.getElementById('card-filename').textContent='✓ ' + this.files[0].name;">
                    @error('card_image') <div style="color:#ef4444; font-size:12px; margin-top:4px;">{{ $message }}</div> @enderror
                </div>

                <hr style="border:none; border-top:1px solid #e2e8f0;">
                <h3 style="font-size:15px; font-weight:700; color:#1e293b; margin-bottom:0;">🏦 Thông tin ngân hàng (Tùy chọn)</h3>
                <p style="font-size:13px; color:#64748b; margin-top:0;">Thêm thông tin thanh toán để nhà tuyển dụng chuyển tiền dễ dàng hơn.</p>

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
                    <div>
                        <label style="font-size:13px; font-weight:600; color:#1e293b; display:block; margin-bottom:6px;">Tên ngân hàng</label>
                        <input type="text" name="bank_name" value="{{ old('bank_name', $user->bank_name) }}"
                               placeholder="VD: Vietcombank"
                               style="width:100%; padding:12px 14px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:14px;">
                    </div>
                    <div>
                        <label style="font-size:13px; font-weight:600; color:#1e293b; display:block; margin-bottom:6px;">Tên chủ tài khoản</label>
                        <input type="text" name="bank_account_name" value="{{ old('bank_account_name', $user->bank_account_name) }}"
                               placeholder="VD: NGUYEN VAN A"
                               style="width:100%; padding:12px 14px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:14px;">
                    </div>
                    <div style="grid-column: span 2;">
                        <label style="font-size:13px; font-weight:600; color:#1e293b; display:block; margin-bottom:6px;">Số tài khoản</label>
                        <input type="text" name="bank_account" value="{{ old('bank_account', $user->bank_account) }}"
                               placeholder="VD: 9876543210"
                               style="width:100%; padding:12px 14px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:14px;">
                    </div>
                </div>

                <div>
                    <label style="font-size:13px; font-weight:600; color:#1e293b; display:block; margin-bottom:6px;">
                        QR Code tài khoản <span style="color:#94a3b8; font-weight:400;">(Tùy chọn)</span>
                    </label>
                    <input type="file" name="bank_qr_image" accept="image/*"
                           style="width:100%; padding:10px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:13px;">
                </div>

                <button type="submit"
                        style="background:linear-gradient(135deg,#7c3aed,#4f46e5); color:#fff; border:none; padding:14px 24px;
                               border-radius:8px; font-weight:700; font-size:15px; cursor:pointer;">
                    📤 Gửi yêu cầu xác thực
                </button>
            </div>
        </form>
    </div>
    @endif
</div>
@endsection
