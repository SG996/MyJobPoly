@extends('admin.layouts.app')

@section('title', 'Sửa Công ty')
@section('page-title', '🏢 Sửa Công ty')
@section('page-subtitle', 'Cập nhật thông tin hồ sơ công ty')

@section('content')

<div class="breadcrumb">
    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
    <span class="breadcrumb-sep">/</span>
    <a href="{{ route('admin.companies.index') }}">Công ty</a>
    <span class="breadcrumb-sep">/</span>
    <span>Sửa hồ sơ</span>
</div>

<div class="card">
    <div class="card-header">
        <div class="card-title">Thông tin công ty</div>
        <a href="{{ route('admin.companies.index') }}" class="btn btn-outline btn-sm">← Quay lại</a>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.companies.update', $company->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Tên công ty <span style="color:var(--danger)">*</span></label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $company->name) }}" required>
                    @error('name')<div style="color:var(--danger);font-size:12px;margin-top:4px;">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Mã số thuế <span style="color:var(--danger)">*</span></label>
                    <input type="text" name="tax_code" class="form-control" value="{{ old('tax_code', $company->tax_code) }}" required>
                    @error('tax_code')<div style="color:var(--danger);font-size:12px;margin-top:4px;">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Email liên hệ <span style="color:var(--danger)">*</span></label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $company->email) }}" required>
                    @error('email')<div style="color:var(--danger);font-size:12px;margin-top:4px;">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Hotline / Số điện thoại <span style="color:var(--danger)">*</span></label>
                    <input type="text" name="hotline" class="form-control" value="{{ old('hotline', $company->hotline) }}" required>
                    @error('hotline')<div style="color:var(--danger);font-size:12px;margin-top:4px;">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Địa chỉ trụ sở <span style="color:var(--danger)">*</span></label>
                <input type="text" name="address" class="form-control" value="{{ old('address', $company->address) }}" required>
                @error('address')<div style="color:var(--danger);font-size:12px;margin-top:4px;">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label class="form-label">Logo công ty</label>
                @if($company->logo)
                    <div style="margin-bottom: 12px;">
                        <img src="{{ Storage::url($company->logo) }}" alt="Logo" style="width: 80px; height: 80px; border-radius: 8px; border: 1px solid var(--border); object-fit: cover;">
                    </div>
                @endif
                <input type="file" name="logo" class="form-control" accept="image/jpeg,image/png,image/webp,image/gif">
                <div style="color:var(--text-secondary);font-size:12px;margin-top:4px;">Để trống nếu không muốn thay đổi logo hiện tại.</div>
                @error('logo')<div style="color:var(--danger);font-size:12px;margin-top:4px;">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label class="form-label">Giới thiệu công ty</label>
                <textarea name="description" class="form-control" rows="5">{{ old('description', $company->description) }}</textarea>
                @error('description')<div style="color:var(--danger);font-size:12px;margin-top:4px;">{{ $message }}</div>@enderror
            </div>

            <div style="display:flex;gap:12px;">
                <button type="submit" class="btn btn-primary">🔄 Cập nhật công ty</button>
                <a href="{{ route('admin.companies.index') }}" class="btn btn-outline">Hủy</a>
            </div>
        </form>
    </div>
</div>

@endsection
