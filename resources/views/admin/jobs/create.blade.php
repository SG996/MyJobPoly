@extends('admin.layouts.app')

@section('title', 'Thêm việc làm')
@section('page-title', '＋ Thêm việc làm mới')
@section('page-subtitle', 'Điền thông tin để đăng việc làm mới')

@section('content')

<div class="breadcrumb">
    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
    <span class="breadcrumb-sep">/</span>
    <a href="{{ route('admin.jobs.index') }}">Việc làm</a>
    <span class="breadcrumb-sep">/</span>
    <span>Thêm mới</span>
</div>

<div class="card">
    <div class="card-header">
        <div class="card-title">Thông tin việc làm</div>
        <a href="{{ route('admin.jobs.index') }}" class="btn btn-outline btn-sm">← Quay lại</a>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.jobs.store') }}" method="POST">
            @csrf

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Tiêu đề công việc <span style="color:var(--danger)">*</span></label>
                    <input type="text" name="title" class="form-control" value="{{ old('title') }}"
                           placeholder="VD: Senior PHP Developer" required>
                    @error('title')<div style="color:var(--danger);font-size:12px;margin-top:4px;">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Công ty <span style="color:var(--danger)">*</span></label>
                    <select name="company_id" class="form-control" required>
                        <option value="">-- Chọn công ty --</option>
                        @foreach($companies as $company)
                            <option value="{{ $company->id }}" {{ old('company_id') == $company->id ? 'selected' : '' }}>
                                {{ $company->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('company_id')<div style="color:var(--danger);font-size:12px;margin-top:4px;">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Danh mục <span style="color:var(--danger)">*</span></label>
                    <select name="category_id" class="form-control" required>
                        <option value="">-- Chọn danh mục --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')<div style="color:var(--danger);font-size:12px;margin-top:4px;">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Địa điểm <span style="color:var(--danger)">*</span></label>
                    <input type="text" name="location" class="form-control" value="{{ old('location') }}"
                           placeholder="VD: Hà Nội" required>
                    @error('location')<div style="color:var(--danger);font-size:12px;margin-top:4px;">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Mức lương</label>
                    <input type="text" name="salary" class="form-control" value="{{ old('salary') }}"
                           placeholder="VD: 15-25 triệu">
                </div>
                <div class="form-group">
                    <label class="form-label">Kinh nghiệm</label>
                    <input type="text" name="experience" class="form-control" value="{{ old('experience') }}"
                           placeholder="VD: 2-3 năm">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Hạn nộp hồ sơ</label>
                    <input type="date" name="deadline" class="form-control" value="{{ old('deadline') }}">
                </div>
                <div class="form-group">
                    <label class="form-label">Trạng thái</label>
                    <select name="is_active" class="form-control">
                        <option value="1" {{ old('is_active', '1') == '1' ? 'selected' : '' }}>✅ Đang hiển thị</option>
                        <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>🔒 Ẩn</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Mô tả công việc <span style="color:var(--danger)">*</span></label>
                <textarea name="description" class="form-control" rows="5" placeholder="Mô tả chi tiết công việc..." required>{{ old('description') }}</textarea>
                @error('description')<div style="color:var(--danger);font-size:12px;margin-top:4px;">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label class="form-label">Yêu cầu ứng viên</label>
                <textarea name="requirements" class="form-control" rows="4" placeholder="Liệt kê các yêu cầu cần có...">{{ old('requirements') }}</textarea>
            </div>

            <div class="form-group">
                <label class="form-label">Phúc lợi</label>
                <textarea name="benefits" class="form-control" rows="4" placeholder="Liệt kê các phúc lợi cho nhân viên...">{{ old('benefits') }}</textarea>
            </div>

            <div style="display:flex;gap:12px;">
                <button type="submit" class="btn btn-primary">💾 Lưu việc làm</button>
                <a href="{{ route('admin.jobs.index') }}" class="btn btn-outline">Hủy</a>
            </div>
        </form>
    </div>
</div>

@endsection
