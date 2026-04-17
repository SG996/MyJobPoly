@extends('admin.layouts.app')

@section('title', 'Sửa việc làm')
@section('page-title', '✏️ Chỉnh sửa việc làm')
@section('page-subtitle', 'Cập nhật thông tin việc làm: {{ $job->title }}')

@section('content')

<div class="breadcrumb">
    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
    <span class="breadcrumb-sep">/</span>
    <a href="{{ route('admin.jobs.index') }}">Việc làm</a>
    <span class="breadcrumb-sep">/</span>
    <span>Chỉnh sửa</span>
</div>

<div class="card">
    <div class="card-header">
        <div class="card-title">Thông tin việc làm #{{ $job->id }}</div>
        <a href="{{ route('admin.jobs.index') }}" class="btn btn-outline btn-sm">← Quay lại</a>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.jobs.update', $job->id) }}" method="POST">
            @csrf @method('PUT')

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Tiêu đề công việc <span style="color:var(--danger)">*</span></label>
                    <input type="text" name="title" class="form-control" value="{{ old('title', $job->title) }}" required>
                    @error('title')<div style="color:var(--danger);font-size:12px;margin-top:4px;">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Công ty <span style="color:var(--danger)">*</span></label>
                    <select name="company_id" class="form-control" required>
                        @foreach($companies as $company)
                            <option value="{{ $company->id }}" {{ old('company_id', $job->company_id) == $company->id ? 'selected' : '' }}>
                                {{ $company->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Danh mục <span style="color:var(--danger)">*</span></label>
                    <select name="category_id" class="form-control" required>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $job->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Địa điểm <span style="color:var(--danger)">*</span></label>
                    <input type="text" name="location" class="form-control" value="{{ old('location', $job->location) }}" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Mức lương</label>
                    <input type="text" name="salary" class="form-control" value="{{ old('salary', $job->salary) }}">
                </div>
                <div class="form-group">
                    <label class="form-label">Kinh nghiệm</label>
                    <input type="text" name="experience" class="form-control" value="{{ old('experience', $job->experience) }}">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Hạn nộp hồ sơ</label>
                    <input type="date" name="deadline" class="form-control" value="{{ old('deadline', $job->deadline ? \Carbon\Carbon::parse($job->deadline)->format('Y-m-d') : '') }}">
                </div>
                <div class="form-group">
                    <label class="form-label">Trạng thái</label>
                    <select name="is_active" class="form-control">
                        <option value="1" {{ old('is_active', $job->is_active) == '1' ? 'selected' : '' }}>✅ Đang hiển thị</option>
                        <option value="0" {{ old('is_active', $job->is_active) == '0' ? 'selected' : '' }}>🔒 Ẩn</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Mô tả công việc <span style="color:var(--danger)">*</span></label>
                <textarea name="description" class="form-control" rows="5" required>{{ old('description', $job->description) }}</textarea>
                @error('description')<div style="color:var(--danger);font-size:12px;margin-top:4px;">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label class="form-label">Yêu cầu ứng viên</label>
                <textarea name="requirements" class="form-control" rows="4">{{ old('requirements', $job->requirements) }}</textarea>
            </div>

            <div class="form-group">
                <label class="form-label">Phúc lợi</label>
                <textarea name="benefits" class="form-control" rows="4">{{ old('benefits', $job->benefits) }}</textarea>
            </div>

            <div style="display:flex;gap:12px;">
                <button type="submit" class="btn btn-primary">💾 Cập nhật</button>
                <a href="{{ route('admin.jobs.index') }}" class="btn btn-outline">Hủy</a>
            </div>
        </form>
    </div>
</div>

@endsection
