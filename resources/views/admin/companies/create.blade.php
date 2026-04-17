@extends('admin.layouts.app')

@section('title', 'Thêm Công ty')
@section('page-title', '🏢 Thêm Công ty')
@section('page-subtitle', 'Điền thông tin để tạo hồ sơ công ty mới')

@section('content')

<div class="breadcrumb">
    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
    <span class="breadcrumb-sep">/</span>
    <a href="{{ route('admin.companies.index') }}">Công ty</a>
    <span class="breadcrumb-sep">/</span>
    <span>Thêm mới</span>
</div>

<div class="card">
    <div class="card-header">
        <div class="card-title">Thông tin công ty</div>
        <a href="{{ route('admin.companies.index') }}" class="btn btn-outline btn-sm">← Quay lại</a>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.companies.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Tên công ty <span style="color:var(--danger)">*</span></label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="VD: Công ty TNHH ABC" required>
                    @error('name')<div style="color:var(--danger);font-size:12px;margin-top:4px;">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Mã số thuế <span style="color:var(--danger)">*</span></label>
                    <input type="text" name="tax_code" class="form-control" value="{{ old('tax_code') }}" placeholder="VD: 0101234567" required>
                    @error('tax_code')<div style="color:var(--danger);font-size:12px;margin-top:4px;">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Email liên hệ <span style="color:var(--danger)">*</span></label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="VD: contact@abc.com" required>
                    @error('email')<div style="color:var(--danger);font-size:12px;margin-top:4px;">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Hotline / Số điện thoại <span style="color:var(--danger)">*</span></label>
                    <input type="text" name="hotline" class="form-control" value="{{ old('hotline') }}" placeholder="VD: 0987654321" required>
                    @error('hotline')<div style="color:var(--danger);font-size:12px;margin-top:4px;">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Địa chỉ trụ sở <span style="color:var(--danger)">*</span></label>
                <input type="text" name="address" class="form-control" value="{{ old('address') }}" placeholder="VD: Số 1, Đường ABC, Quận XYZ, TP.HCM" required>
                @error('address')<div style="color:var(--danger);font-size:12px;margin-top:4px;">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label class="form-label">Logo công ty (Tùy chọn)</label>
                <input type="file" name="logo" class="form-control" accept="image/jpeg,image/png,image/webp,image/gif">
                <div style="color:var(--text-secondary);font-size:12px;margin-top:4px;">Chấp nhận file ảnh (PNG, JPG, WEBP). Tối đa 2MB.</div>
                @error('logo')<div style="color:var(--danger);font-size:12px;margin-top:4px;">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label class="form-label">Giới thiệu công ty</label>
                <textarea name="description" class="form-control" rows="5" placeholder="Mô tả về quy mô, lĩnh vực hoạt động, văn hóa công ty...">{{ old('description') }}</textarea>
                @error('description')<div style="color:var(--danger);font-size:12px;margin-top:4px;">{{ $message }}</div>@enderror
            </div>

            <div style="display:flex;gap:12px;">
                <button type="submit" class="btn btn-primary">💾 Lưu công ty</button>
                <a href="{{ route('admin.companies.index') }}" class="btn btn-outline">Hủy</a>
            </div>
        </form>
    </div>
</div>

@endsection
