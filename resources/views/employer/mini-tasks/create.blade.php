@extends('layouts.master')
@section('title', 'Đăng dự án mới | MyJobCV')

@section('content')
<div class="container" style="max-width:800px; margin:32px auto 60px;">
    <div style="margin-bottom:24px;">
        <a href="{{ route('employer.mini-tasks.index') }}" style="color:#64748b; font-size:14px; text-decoration:none;">← Quay lại</a>
        <h1 style="font-size:22px; font-weight:800; color:#1e293b; margin-top:8px;">✨ Đăng dự án mới</h1>
    </div>

    @if($errors->any())
        <div style="background:#fef2f2; border:1px solid #fecaca; border-radius:8px; padding:14px; margin-bottom:16px;">
            @foreach($errors->all() as $err)
                <div style="color:#dc2626; font-size:13px; margin-bottom:2px;">• {{ $err }}</div>
            @endforeach
        </div>
    @endif

    <form action="{{ route('employer.mini-tasks.store') }}" method="POST">
        @csrf
        <div class="content-block" style="display:grid; gap:18px;">

            <div>
                <label class="form-label">Tiêu đề dự án <span style="color:#ef4444;">*</span></label>
                <input type="text" name="title" required value="{{ old('title') }}" class="form-input"
                       placeholder="VD: Thiết kế logo công ty, Xây dựng landing page...">
            </div>

            <div style="display:grid; grid-template-columns:1fr 1fr; gap:14px;">
                <div>
                    <label class="form-label">Loại dự án <span style="color:#ef4444;">*</span></label>
                    <select name="type" class="form-input">
                        <option value="freelance" {{ old('type')=='freelance'?'selected':'' }}>💼 Freelance</option>
                        <option value="internship" {{ old('type')=='internship'?'selected':'' }}>🎓 Thực tập (Yêu cầu xác thực SV)</option>
                    </select>
                </div>
                <div>
                    <label class="form-label">Số người cần <span style="color:#ef4444;">*</span></label>
                    <input type="number" name="max_workers" min="1" max="100" value="{{ old('max_workers',1) }}" class="form-input" required>
                </div>
            </div>

            <div>
                <label class="form-label">Mô tả chi tiết <span style="color:#ef4444;">*</span></label>
                <textarea name="description" rows="5" required class="form-input"
                          placeholder="Mô tả công việc cần thực hiện, kết quả mong đợi...">{{ old('description') }}</textarea>
            </div>

            <div>
                <label class="form-label">Yêu cầu kỹ năng</label>
                <textarea name="requirements" rows="3" class="form-input"
                          placeholder="Liệt kê kỹ năng, kinh nghiệm cần thiết...">{{ old('requirements') }}</textarea>
            </div>

            <div style="display:grid; grid-template-columns:1fr 1fr; gap:14px;">
                <div>
                    <label class="form-label">Ngân sách tối thiểu (VNĐ) <span style="color:#ef4444;">*</span></label>
                    <input type="number" name="budget_min" min="0" value="{{ old('budget_min',0) }}" class="form-input" required>
                </div>
                <div>
                    <label class="form-label">Ngân sách tối đa (VNĐ) <span style="color:#ef4444;">*</span></label>
                    <input type="number" name="budget_max" min="0" value="{{ old('budget_max',0) }}" class="form-input" required>
                </div>
            </div>

            <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:14px;">
                <div>
                    <label class="form-label">Địa điểm <span style="color:#ef4444;">*</span></label>
                    <input type="text" name="location" value="{{ old('location','Toàn quốc') }}" class="form-input" required>
                </div>
                <div>
                    <label class="form-label">Hình thức làm việc</label>
                    <select name="work_type" class="form-input">
                        <option value="online">🌐 Làm online</option>
                        <option value="offline">🏢 Trực tiếp</option>
                        <option value="hybrid">🔄 Hybrid</option>
                    </select>
                </div>
                <div>
                    <label class="form-label">Hình thức trả lương</label>
                    <select name="payment_type" class="form-input">
                        <option value="per_project">Theo dự án</option>
                        <option value="per_hour">Theo giờ</option>
                        <option value="per_month">Theo tháng</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="form-label">Hạn nộp hồ sơ <span style="color:#ef4444;">*</span></label>
                <input type="datetime-local" name="deadline" value="{{ old('deadline') }}" class="form-input" required
                       min="{{ now()->addDay()->format('Y-m-d\TH:i') }}">
            </div>

            <div style="display:flex; gap:12px; justify-content:flex-end; padding-top:8px; border-top:1px solid #e2e8f0;">
                <a href="{{ route('employer.mini-tasks.index') }}"
                   style="padding:12px 24px; border-radius:8px; border:1.5px solid #e2e8f0; color:#64748b; font-size:14px; font-weight:600; text-decoration:none;">
                    Hủy
                </a>
                <button type="button" id="ai-check-btn" onclick="aiCheckContent()"
                        style="display:inline-flex; align-items:center; gap:6px; background:linear-gradient(135deg,#0ea5e9,#06b6d4); color:#fff; border:none; padding:12px 20px; border-radius:8px; font-weight:700; font-size:14px; cursor:pointer;">
                    🔍 Kiểm tra AI
                </button>
                <button type="submit" id="submit-btn"
                        style="background:linear-gradient(135deg,#7c3aed,#4f46e5); color:#fff; border:none; padding:12px 28px; border-radius:8px; font-weight:700; font-size:14px; cursor:pointer;">
                    🚀 Đăng dự án
                </button>
            </div>

            {{-- AI Moderation Result --}}
            <div id="ai-check-panel" style="display:none; margin-top:4px; border-radius:10px; padding:14px;"></div>
        </div>
    </form>
</div>

<style>
.form-label { font-size:13px; font-weight:700; color:#1e293b; display:block; margin-bottom:6px; }
.form-input { width:100%; padding:12px 14px; border:1.5px solid #e2e8f0; border-radius:8px; font-size:14px; font-family:inherit; outline:none; box-sizing:border-box; transition:border-color .2s; }
.form-input:focus { border-color:#7c3aed; }
</style>

<script>
// =====================================================================
// AI: Kiểm tra nội dung mini-task trước khi submit
// =====================================================================
function aiCheckContent() {
    const title = document.querySelector('input[name="title"]')?.value?.trim();
    const desc  = document.querySelector('textarea[name="description"]')?.value?.trim();

    if (!title || !desc) {
        alert('Vui lòng nhập Tiêu đề và Mô tả trước khi kiểm tra.');
        return;
    }

    const btn   = document.getElementById('ai-check-btn');
    const panel = document.getElementById('ai-check-panel');

    btn.disabled  = true;
    btn.innerHTML = '⏳ Đang kiểm tra...';
    panel.style.display = 'none';

    fetch('{{ route("ai.check_minitask") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
        },
        body: JSON.stringify({ title, description: desc }),
    })
    .then(res => res.json())
    .then(data => {
        btn.disabled    = false;
        btn.innerHTML   = '🔍 Kiểm tra AI';

        // AI không khả dụng (fail-open từ server)
        if (data.ai_available === false) {
            panel.style.cssText = 'display:block; background:linear-gradient(135deg,#fef3c7,#fde68a); border:1.5px solid #f59e0b; border-radius:10px; padding:14px; margin-top:4px;';
            panel.innerHTML = `<div style="display:flex;align-items:flex-start;gap:8px;">
                <span style="font-size:20px;">⚠️</span>
                <div>
                    <strong style="color:#92400e;font-size:14px;">AI kiểm duyệt tạm thời không khả dụng</strong>
                    <div style="color:#78350f;font-size:13px;margin-top:4px;">${data.notice || 'Nội dung sẽ được xét duyệt thủ công sau khi đăng.'}</div>
                    <div style="color:#92400e;font-size:12px;margin-top:6px;">Bạn vẫn có thể đăng dự án bình thường.</div>
                </div>
            </div>`;
        } else if (data.passed) {
            panel.style.cssText = 'display:block; background:linear-gradient(135deg,#f0fdf4,#dcfce7); border:1.5px solid #86efac; border-radius:10px; padding:14px; margin-top:4px;';
            panel.innerHTML = `<div style="display:flex;align-items:center;gap:8px;">
                <span style="font-size:20px;">✅</span>
                <div>
                    <strong style="color:#166534;font-size:14px;">Nội dung đạt yêu cầu!</strong>
                    <div style="color:#16a34a;font-size:13px;margin-top:2px;">AI không phát hiện vi phạm. Bạn có thể đăng dự án.</div>
                </div>
            </div>`;
        } else {
            panel.style.cssText = 'display:block; background:linear-gradient(135deg,#fef2f2,#fee2e2); border:1.5px solid #fca5a5; border-radius:10px; padding:14px; margin-top:4px;';
            panel.innerHTML = `<div style="display:flex;align-items:flex-start;gap:8px;">
                <span style="font-size:20px;">⚠️</span>
                <div>
                    <strong style="color:#991b1b;font-size:14px;">AI phát hiện vấn đề</strong>
                    <div style="color:#dc2626;font-size:13px;margin-top:4px;">${data.reason || 'Nội dung có thể không phù hợp.'}</div>
                    <div style="color:#7f1d1d;font-size:12px;margin-top:6px;">Vui lòng chỉnh sửa nội dung trước khi đăng.</div>
                </div>
            </div>`;
        }
        panel.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    })
    .catch(() => {
        btn.disabled    = false;
        btn.innerHTML   = '🔍 Kiểm tra AI';
        // Lỗi kết nối — hiện trong panel thay vì alert
        panel.style.cssText = 'display:block; background:#1e293b; border:1px solid #475569; border-radius:10px; padding:14px; margin-top:4px; color:#94a3b8; font-size:13px;';
        panel.innerHTML = '🌐 Không thể kết nối đến AI. Kiểm tra lại kết nối mạng và thử lại.';
        panel.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    });
}
</script>
@endsection
