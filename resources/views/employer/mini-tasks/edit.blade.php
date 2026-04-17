@extends('layouts.master')
@section('title', 'Sửa dự án | MyJobPoly')

@section('content')
<div class="container" style="max-width:800px; margin:32px auto 60px;">
    <div style="margin-bottom:24px;">
        <a href="{{ route('employer.mini-tasks.index') }}" style="color:#64748b; font-size:14px; text-decoration:none;">← Quay lại</a>
        <h1 style="font-size:22px; font-weight:800; color:#1e293b; margin-top:8px;">✏️ Sửa dự án</h1>
    </div>

    @if($errors->any())
        <div style="background:#fef2f2; border:1px solid #fecaca; border-radius:8px; padding:14px; margin-bottom:16px;">
            @foreach($errors->all() as $err)
                <div style="color:#dc2626; font-size:13px; margin-bottom:2px;">• {{ $err }}</div>
            @endforeach
        </div>
    @endif

    <form action="{{ route('employer.mini-tasks.update', $task->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="content-block" style="display:grid; gap:18px;">

            <div>
                <label class="form-label">Tiêu đề dự án <span style="color:#ef4444;">*</span></label>
                <input type="text" name="title" required value="{{ old('title', $task->title) }}" class="form-input"
                       placeholder="VD: Thiết kế logo công ty, Xây dựng landing page...">
            </div>

            <div style="display:grid; grid-template-columns:1fr 1fr; gap:14px;">
                <div>
                    <label class="form-label">Loại dự án <span style="color:#ef4444;">*</span></label>
                    <select name="type" class="form-input">
                        <option value="freelance" {{ old('type', $task->type) == 'freelance' ? 'selected' : '' }}>💼 Freelance</option>
                        <option value="internship" {{ old('type', $task->type) == 'internship' ? 'selected' : '' }}>🎓 Thực tập</option>
                    </select>
                </div>
                <div>
                    <label class="form-label">Số người cần <span style="color:#ef4444;">*</span></label>
                    <input type="number" name="max_workers" min="1" max="100"
                           value="{{ old('max_workers', $task->max_workers) }}" class="form-input" required>
                </div>
            </div>

            <div>
                <label class="form-label">Mô tả chi tiết <span style="color:#ef4444;">*</span></label>
                <textarea name="description" rows="5" required class="form-input"
                          placeholder="Mô tả công việc cần thực hiện, kết quả mong đợi...">{{ old('description', $task->description) }}</textarea>
            </div>

            <div>
                <label class="form-label">Yêu cầu kỹ năng</label>
                <textarea name="requirements" rows="3" class="form-input"
                          placeholder="Liệt kê kỹ năng, kinh nghiệm cần thiết...">{{ old('requirements', $task->requirements) }}</textarea>
            </div>

            <div style="display:grid; grid-template-columns:1fr 1fr; gap:14px;">
                <div>
                    <label class="form-label">Ngân sách tối thiểu (VNĐ) <span style="color:#ef4444;">*</span></label>
                    <input type="number" name="budget_min" min="0"
                           value="{{ old('budget_min', $task->budget_min) }}" class="form-input" required>
                </div>
                <div>
                    <label class="form-label">Ngân sách tối đa (VNĐ) <span style="color:#ef4444;">*</span></label>
                    <input type="number" name="budget_max" min="0"
                           value="{{ old('budget_max', $task->budget_max) }}" class="form-input" required>
                </div>
            </div>

            <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:14px;">
                <div>
                    <label class="form-label">Địa điểm <span style="color:#ef4444;">*</span></label>
                    <input type="text" name="location"
                           value="{{ old('location', $task->location) }}" class="form-input" required>
                </div>
                <div>
                    <label class="form-label">Hình thức làm việc</label>
                    <select name="work_type" class="form-input">
                        <option value="online"  {{ old('work_type', $task->work_type) == 'online'  ? 'selected' : '' }}>🌐 Làm online</option>
                        <option value="offline" {{ old('work_type', $task->work_type) == 'offline' ? 'selected' : '' }}>🏢 Trực tiếp</option>
                        <option value="hybrid"  {{ old('work_type', $task->work_type) == 'hybrid'  ? 'selected' : '' }}>🔄 Hybrid</option>
                    </select>
                </div>
                <div>
                    <label class="form-label">Hình thức trả lương</label>
                    <select name="payment_type" class="form-input">
                        <option value="per_project" {{ old('payment_type', $task->payment_type) == 'per_project' ? 'selected' : '' }}>Theo dự án</option>
                        <option value="per_hour"    {{ old('payment_type', $task->payment_type) == 'per_hour'    ? 'selected' : '' }}>Theo giờ</option>
                        <option value="per_month"   {{ old('payment_type', $task->payment_type) == 'per_month'   ? 'selected' : '' }}>Theo tháng</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="form-label">Hạn nộp hồ sơ <span style="color:#ef4444;">*</span></label>
                <input type="datetime-local" name="deadline" class="form-input" required
                       value="{{ old('deadline', \Carbon\Carbon::parse($task->deadline)->format('Y-m-d\TH:i')) }}">
            </div>

            <div>
                <label class="form-label" style="display:flex; align-items:center; gap:10px; cursor:pointer;">
                    <input type="checkbox" name="is_active" value="1"
                           {{ old('is_active', $task->is_active) ? 'checked' : '' }}
                           style="width:18px; height:18px; cursor:pointer;">
                    <span>Hiển thị dự án (bật/tắt đăng tuyển)</span>
                </label>
            </div>

            <div style="display:flex; gap:12px; justify-content:flex-end; padding-top:8px; border-top:1px solid #e2e8f0;">
                <a href="{{ route('employer.mini-tasks.index') }}"
                   style="padding:12px 24px; border-radius:8px; border:1.5px solid #e2e8f0; color:#64748b; font-size:14px; font-weight:600; text-decoration:none;">
                    Hủy
                </a>
                <button type="submit"
                        style="background:linear-gradient(135deg,#7c3aed,#4f46e5); color:#fff; border:none; padding:12px 28px; border-radius:8px; font-weight:700; font-size:14px; cursor:pointer;">
                    💾 Lưu thay đổi
                </button>
            </div>

        </div>
    </form>
</div>

<style>
.form-label { font-size:13px; font-weight:700; color:#1e293b; display:block; margin-bottom:6px; }
.form-input { width:100%; padding:12px 14px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:14px; font-family:inherit; outline:none; box-sizing:border-box; transition:border-color .2s; }
.form-input:focus { border-color:#7c3aed; }
</style>
@endsection
