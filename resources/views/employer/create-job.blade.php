@extends('layouts.master')

@section('title', 'Đăng tin tuyển dụng | MyJobCV')

@section('content')
<div class="container account-grid">

    @include('partials.employer-sidebar', ['active' => 'post-job'])

    <main class="account-content">
        <h1 class="account-content-title">📝 Đăng tin tuyển dụng mới</h1>
        <p class="account-content-subtitle">Điền đầy đủ thông tin để thu hút ứng viên phù hợp nhất</p>

        {{-- Thông báo lỗi --}}
        @if($errors->any())
            <div style="background:#fef2f2; border:1px solid #fca5a5; color:#991b1b; padding:14px 16px; border-radius:8px; margin-bottom:20px;">
                <strong>⚠ Vui lòng kiểm tra lại:</strong>
                <ul style="margin:6px 0 0; padding-left:18px;">
                    @foreach($errors->all() as $err)
                        <li style="font-size:14px;">{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('employer.jobs.store') }}" method="POST" id="post-job-form">
            @csrf

            {{-- THÔNG TIN CƠ BẢN --}}
            <div class="employer-form-section">
                <div class="employer-form-section-title">📌 Thông tin cơ bản</div>

                <div class="form-group">
                    <label class="form-label">Tiêu đề công việc <span class="required">*</span></label>
                    <input type="text" name="title" class="form-control" placeholder="Ví dụ: Lập trình viên PHP Senior" value="{{ old('title') }}" required>
                </div>

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
                    <div class="form-group">
                        <label class="form-label">Danh mục <span class="required">*</span></label>
                        <select name="category_id" class="form-control" required>
                            <option value="">-- Chọn danh mục --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Địa điểm làm việc <span class="required">*</span></label>
                        <input type="text" name="location" class="form-control" placeholder="Ví dụ: Hà Nội, TP.HCM" value="{{ old('location') }}" required>
                    </div>
                </div>

                <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:16px;">
                    <div class="form-group">
                        <label class="form-label">Mức lương <span class="required">*</span></label>
                        <input type="text" name="salary" class="form-control" placeholder="Ví dụ: 15-25 triệu" value="{{ old('salary') }}" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Kinh nghiệm yêu cầu <span class="required">*</span></label>
                        <select name="experience" class="form-control" required>
                            <option value="">-- Chọn --</option>
                            @foreach(['Không yêu cầu', 'Dưới 1 năm', '1 - 2 năm', '2 - 3 năm', '3 - 5 năm', 'Trên 5 năm'] as $exp)
                                <option value="{{ $exp }}" {{ old('experience') == $exp ? 'selected' : '' }}>{{ $exp }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Hạn nộp hồ sơ <span class="required">*</span></label>
                        <input type="date" name="deadline" class="form-control" value="{{ old('deadline') }}" min="{{ date('Y-m-d', strtotime('+1 day')) }}" required>
                    </div>
                </div>

                <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:16px; margin-top:16px;">
                    <div class="form-group">
                        <label class="form-label">Bằng cấp</label>
                        <select name="degree" class="form-control">
                            <option value="">-- Không yêu cầu --</option>
                            @foreach(['Trung cấp', 'Cao đẳng', 'Đại học', 'Thạc sĩ/Tiến sĩ'] as $deg)
                                <option value="{{ $deg }}" {{ old('degree') == $deg ? 'selected' : '' }}>{{ $deg }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Cấp bậc</label>
                        <select name="level" class="form-control">
                            <option value="">-- Có thể thương lượng --</option>
                            @foreach(['Thực tập sinh', 'Nhân viên', 'Trưởng nhóm', 'Quản lý', 'Giám đốc'] as $lvl)
                                <option value="{{ $lvl }}" {{ old('level') == $lvl ? 'selected' : '' }}>{{ $lvl }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Số lượng tuyển</label>
                        <input type="number" name="quantity" class="form-control" value="{{ old('quantity', 1) }}" min="1">
                    </div>
                </div>
            </div>

            {{-- NỘI DUNG --}}
            <div class="employer-form-section">
                <div class="employer-form-section-title">📄 Nội dung chi tiết</div>

                <div class="form-group">
                    <label class="form-label">Mô tả công việc <span class="required">*</span></label>
                    <textarea name="description" class="form-control" rows="6" placeholder="Mô tả chi tiết về vị trí, trách nhiệm công việc..." required>{{ old('description') }}</textarea>
                </div>

                <div class="form-group">
                    <label class="form-label">Yêu cầu ứng viên <span class="required">*</span></label>
                    <textarea name="requirements" class="form-control" rows="5" placeholder="Yêu cầu kỹ năng, kinh nghiệm, bằng cấp..." required>{{ old('requirements') }}</textarea>
                </div>

                <div class="form-group">
                    <label class="form-label">Quyền lợi</label>
                    <textarea name="benefits" class="form-control" rows="4" placeholder="Các phúc lợi, chế độ đãi ngộ dành cho ứng viên...">{{ old('benefits') }}</textarea>
                </div>
            </div>

            {{-- SUBMIT --}}
            <div style="display:flex; gap:12px; justify-content:flex-end; margin-top:24px;">
                <a href="{{ route('employer.dashboard') }}" class="btn btn-outline" style="padding:12px 24px;">Hủy</a>
                <button type="submit" class="btn btn-primary" style="padding:12px 32px; font-weight:700; font-size:16px;">
                    🚀 Đăng tin tuyển dụng
                </button>
            </div>
        </form>
    </main>
</div>

<style>
.required { color: #dc3545; }

.employer-form-section {
    background: #fff;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    padding: 24px;
    margin-bottom: 20px;
}

.employer-form-section-title {
    font-size: 14px;
    font-weight: 800;
    color: #1e293b;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding-bottom: 14px;
    margin-bottom: 18px;
    border-bottom: 2px solid #f1f5f9;
}
</style>
@endsection
