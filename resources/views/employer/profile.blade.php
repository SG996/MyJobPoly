@extends('layouts.master')

@section('title', 'Thông tin công ty | MyJobCV')

@section('content')
<div class="container account-grid">

    @include('partials.employer-sidebar', ['active' => 'profile'])

    <main class="account-content">
        <h1 class="account-content-title">🏢 Thông tin công ty</h1>
        <p class="account-content-subtitle">Cập nhật hồ sơ doanh nghiệp để ứng viên hiểu rõ hơn về công ty bạn</p>

        @if(session('success'))
            <div style="background:#d1fae5; border:1px solid #6ee7b7; color:#065f46; padding:12px 16px; border-radius:8px; margin-bottom:20px; font-weight:500;">
                ✅ {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div style="background:#fef2f2; border:1px solid #fca5a5; color:#991b1b; padding:14px 16px; border-radius:8px; margin-bottom:20px;">
                <ul style="margin:0; padding-left:18px;">
                    @foreach($errors->all() as $err)
                        <li style="font-size:14px;">{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('employer.profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- LOGO / AVATAR CÔNG TY --}}
            <div style="background:#fff; border:1px solid #e2e8f0; border-radius:12px; padding:24px; margin-bottom:20px;">
                <div style="font-size:13px; font-weight:800; color:#1e293b; text-transform:uppercase; letter-spacing:.5px; padding-bottom:14px; margin-bottom:18px; border-bottom:2px solid #f1f5f9;">
                    🖼️ Logo công ty
                </div>

                <div class="avatar-upload-wrapper">
                    {{-- Ô preview --}}
                    <div class="avatar-preview-box" id="avatarPreviewBox" onclick="document.getElementById('logoInput').click()">
                        @if($company && $company->logo)
                            <img src="{{ asset('storage/' . $company->logo) }}"
                                 alt="Logo công ty" id="avatarPreviewImg" class="avatar-preview-img">
                            <div class="avatar-overlay"><span>📷 Thay đổi logo</span></div>
                        @else
                            <div class="avatar-placeholder" id="avatarPlaceholder">
                                <div style="font-size:52px; margin-bottom:8px; opacity:.45;">🏢</div>
                                <div style="font-size:13px; font-weight:600; color:#64748b;">Click để tải logo lên</div>
                                <div style="font-size:11px; color:#94a3b8; margin-top:4px;">PNG, JPG, WEBP • Tối đa 2MB</div>
                            </div>
                            <img src="" alt="" id="avatarPreviewImg" class="avatar-preview-img" style="display:none;">
                            <div class="avatar-overlay" style="display:none;"><span>📷 Thay đổi logo</span></div>
                        @endif
                    </div>

                    {{-- Thông tin & nút --}}
                    <div class="avatar-upload-info">
                        <h4 style="margin:0 0 8px; font-size:15px; font-weight:700; color:#1e293b;">Logo / Ảnh đại diện doanh nghiệp</h4>
                        <p style="margin:0 0 14px; font-size:13px; color:#64748b; line-height:1.7;">
                            Logo hiển thị trên bài đăng tuyển dụng và hồ sơ công ty.<br>
                            Khuyến nghị: ảnh vuông, tối thiểu <strong>200×200px</strong>.
                        </p>

                        <input type="file" name="logo" id="logoInput" accept="image/*"
                               style="display:none;" onchange="previewLogo(this)">
                        <input type="hidden" name="remove_logo" id="removeLogo" value="0">

                        <div style="display:flex; gap:10px; flex-wrap:wrap; align-items:center;">
                            <button type="button" onclick="document.getElementById('logoInput').click()"
                                    class="btn-upload-trigger">
                                📁 Chọn ảnh từ máy
                            </button>
                            @if($company && $company->logo)
                                <button type="button" onclick="removeLogo()" class="btn-remove-logo">
                                    🗑️ Xóa logo
                                </button>
                            @endif
                        </div>

                        <div id="selectedFileName"
                             style="display:none; margin-top:12px; font-size:12px; color:#16a34a; font-weight:600;
                                    padding:7px 14px; background:#f0fdf4; border-radius:8px; border:1px solid #bbf7d0;">
                            ✅ <span id="fileNameText"></span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- THÔNG TIN CƠ BẢN --}}
            <div style="background:#fff; border:1px solid #e2e8f0; border-radius:12px; padding:24px; margin-bottom:20px;">
                <div style="font-size:13px; font-weight:800; color:#1e293b; text-transform:uppercase; letter-spacing:.5px; padding-bottom:14px; margin-bottom:18px; border-bottom:2px solid #f1f5f9;">
                    📋 Thông tin cơ bản
                </div>

                <div class="form-group">
                    <label class="form-label">Tên công ty <span style="color:#dc3545;">*</span></label>
                    <input type="text" name="company_name" class="form-control"
                           value="{{ $company->name ?? '' }}" required>
                </div>

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
                    <div class="form-group">
                        <label class="form-label">Mã số thuế</label>
                        <input type="text" class="form-control" value="{{ $company->tax_code ?? '' }}"
                               readonly style="background:#f8f9fa; cursor:not-allowed;">
                        <small style="color:#94a3b8; font-size:12px;">Mã số thuế không thể thay đổi</small>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Email công ty</label>
                        <input type="email" class="form-control" value="{{ $company->email ?? '' }}"
                               readonly style="background:#f8f9fa; cursor:not-allowed;">
                        <small style="color:#94a3b8; font-size:12px;">Email không thể thay đổi</small>
                    </div>
                </div>

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
                    <div class="form-group">
                        <label class="form-label">Địa chỉ</label>
                        <input type="text" name="address" class="form-control"
                               value="{{ $company->address ?? '' }}" placeholder="Địa chỉ trụ sở công ty">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Số điện thoại / Hotline</label>
                        <input type="text" name="hotline" class="form-control"
                               value="{{ $company->hotline ?? '' }}" placeholder="Ví dụ: 024-1234-5678">
                    </div>
                </div>

                <div class="form-group" style="margin-bottom:0;">
                    <label class="form-label">Giới thiệu công ty</label>
                    <textarea name="description" class="form-control" rows="5"
                              placeholder="Giới thiệu về lĩnh vực, sứ mệnh, văn hóa của công ty...">{{ $company->description ?? '' }}</textarea>
                </div>
            </div>

            <div style="text-align:right;">
                <button type="submit" class="btn btn-primary"
                        style="padding:12px 32px; font-size:16px; font-weight:700;">
                    💾 Lưu thay đổi
                </button>
            </div>
        </form>
    </main>
</div>

<style>
.avatar-upload-wrapper {
    display: flex;
    gap: 28px;
    align-items: flex-start;
}

.avatar-preview-box {
    flex-shrink: 0;
    width: 140px;
    height: 140px;
    border-radius: 16px;
    border: 2px dashed #cbd5e1;
    background: #f8fafc;
    cursor: pointer;
    position: relative;
    overflow: hidden;
    transition: border-color .25s, box-shadow .25s;
    display: flex;
    align-items: center;
    justify-content: center;
}

.avatar-preview-box:hover {
    border-color: #00b14f;
    box-shadow: 0 0 0 4px rgba(0,177,79,.12);
}

.avatar-placeholder {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    text-align: center;
    padding: 10px;
    pointer-events: none;
}

.avatar-preview-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 14px;
}

.avatar-overlay {
    position: absolute;
    inset: 0;
    background: rgba(0,0,0,.48);
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 14px;
    opacity: 0;
    transition: opacity .25s;
    color: #fff;
    font-size: 12px;
    font-weight: 700;
    text-align: center;
    pointer-events: none;
}

.avatar-preview-box:hover .avatar-overlay {
    opacity: 1;
}

.avatar-upload-info { flex: 1; padding-top: 4px; }

.btn-upload-trigger {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 9px 18px;
    background: linear-gradient(135deg, #00b14f, #00913f);
    color: #fff;
    border: none;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 700;
    cursor: pointer;
    transition: all .2s;
    box-shadow: 0 2px 8px rgba(0,177,79,.3);
}
.btn-upload-trigger:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 14px rgba(0,177,79,.45);
}

.btn-remove-logo {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 9px 18px;
    background: #fff;
    color: #dc3545;
    border: 1.5px solid #fca5a5;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 700;
    cursor: pointer;
    transition: all .2s;
}
.btn-remove-logo:hover {
    background: #fef2f2;
    border-color: #dc3545;
}

@media (max-width: 600px) {
    .avatar-upload-wrapper { flex-direction: column; align-items: center; }
    .avatar-upload-info    { text-align: center; }
}
</style>

<script>
function previewLogo(input) {
    const file = input.files[0];
    if (!file) return;

    if (file.size > 2 * 1024 * 1024) {
        alert('⚠️ File quá lớn! Vui lòng chọn ảnh nhỏ hơn 2MB.');
        input.value = '';
        return;
    }

    const reader = new FileReader();
    reader.onload = function(e) {
        const img         = document.getElementById('avatarPreviewImg');
        const placeholder = document.getElementById('avatarPlaceholder');
        const overlay     = document.querySelector('.avatar-overlay');

        img.src          = e.target.result;
        img.style.display = 'block';
        if (placeholder) placeholder.style.display = 'none';
        if (overlay)     overlay.style.display     = 'flex';

        document.getElementById('removeLogo').value = '0';

        const box  = document.getElementById('selectedFileName');
        const span = document.getElementById('fileNameText');
        box.style.display  = 'block';
        span.textContent   = file.name + ' (' + (file.size / 1024).toFixed(0) + ' KB)';
    };
    reader.readAsDataURL(file);
}

function removeLogo() {
    if (!confirm('Bạn có chắc muốn xóa logo công ty?')) return;

    const img         = document.getElementById('avatarPreviewImg');
    const placeholder = document.getElementById('avatarPlaceholder');
    const overlay     = document.querySelector('.avatar-overlay');

    img.src          = '';
    img.style.display = 'none';
    if (placeholder) { placeholder.style.display = 'flex'; }
    if (overlay)     { overlay.style.display      = 'none'; }

    document.getElementById('removeLogo').value            = '1';
    document.getElementById('logoInput').value             = '';
    document.getElementById('selectedFileName').style.display = 'none';
}
</script>
@endsection
