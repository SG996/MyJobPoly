@extends('layouts.master')
@section('title', 'Mini Tasks của tôi | Nhà tuyển dụng')

@section('content')
<div class="container" style="margin-top:32px; margin-bottom:60px;">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px;">
        <div>
            <h1 style="font-size:22px; font-weight:800; color:#1e293b;">💼 Mini Tasks của tôi</h1>
            <p style="font-size:14px; color:#64748b;">Quản lý các dự án freelance / thực tập bạn đã đăng</p>
        </div>
        <a href="{{ route('employer.mini-tasks.create') }}"
           style="background:linear-gradient(135deg,#7c3aed,#4f46e5); color:#fff; padding:12px 22px; border-radius:8px; font-size:14px; font-weight:700; text-decoration:none;">
            + Đăng dự án mới
        </a>
    </div>

    @if(session('success'))
        <div style="background:#f0fdf4; border:1px solid #bbf7d0; border-radius:8px; padding:14px; margin-bottom:16px; color:#166534; font-size:14px; font-weight:600;">✅ {{ session('success') }}</div>
    @endif

    <div style="display:grid; gap:14px;">
        @forelse($tasks as $task)
        <div class="content-block" style="padding:20px;">
            <div style="display:flex; align-items:flex-start; justify-content:space-between; gap:14px;">
                <div style="flex:1;">
                    <div style="display:flex; align-items:center; gap:10px; margin-bottom:8px;">
                        <span style="font-weight:700; color:#1e293b; font-size:16px;">{{ $task->title }}</span>
                        <span style="background:{{ $task->type==='internship'?'#f0fdf4':'#eff6ff' }}; color:{{ $task->type==='internship'?'#16a34a':'#2563eb' }}; padding:3px 10px; border-radius:20px; font-size:11px; font-weight:700;">
                            {{ $task->type==='internship'?'🎓 Thực tập':'💼 Freelance' }}
                        </span>
                        @if(!$task->is_active)
                            <span style="background:#fef2f2; color:#dc2626; padding:3px 10px; border-radius:20px; font-size:11px; font-weight:700;">Đã ẩn</span>
                        @endif
                    </div>
                    <div style="font-size:13px; color:#64748b; margin-bottom:8px;">
                        💰 {{ $task->budgetFormatted() }} •
                        📍 {{ $task->location }} •
                        Hạn: {{ $task->deadline->format('d/m/Y') }} •
                        👥 {{ $task->accepted_applications_count }}/{{ $task->max_workers }} người được nhận
                    </div>
                    <div style="font-size:13px;">
                        <span style="color:#64748b;">{{ $task->applications_count }} ứng viên</span>
                    </div>
                </div>
                <div style="display:flex; flex-direction:column; gap:8px; align-items:flex-end;">
                    <a href="{{ route('employer.mini-tasks.applications', $task->id) }}"
                       style="background:#f5f3ff; color:#7c3aed; padding:8px 16px; border-radius:8px; font-size:13px; font-weight:700; text-decoration:none; white-space:nowrap;">
                        👥 Xem ứng viên ({{ $task->applications_count }})
                    </a>
                    <a href="{{ route('employer.mini-tasks.edit', $task->id) }}"
                       style="background:#f1f5f9; color:#475569; padding:8px 16px; border-radius:8px; font-size:13px; font-weight:600; text-decoration:none;">
                        ✏️ Sửa
                    </a>
                    <form action="{{ route('employer.mini-tasks.destroy', $task->id) }}" method="POST" onsubmit="return confirm('Xóa dự án này?')">
                        @csrf @method('DELETE')
                        <button type="submit" style="background:#fee2e2; color:#dc2626; border:none; padding:8px 16px; border-radius:8px; font-size:13px; font-weight:600; cursor:pointer;">
                            🗑️ Xóa
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="content-block" style="text-align:center; padding:60px;">
            <div style="font-size:48px; margin-bottom:16px;">📭</div>
            <p style="color:#64748b; font-size:15px; margin-bottom:16px;">Bạn chưa đăng dự án nào.</p>
            <a href="{{ route('employer.mini-tasks.create') }}"
               style="background:#7c3aed; color:#fff; padding:12px 24px; border-radius:8px; font-size:14px; font-weight:700; text-decoration:none;">
                Đăng dự án đầu tiên →
            </a>
        </div>
        @endforelse
    </div>

    <div style="margin-top:16px;">{{ $tasks->links() }}</div>
</div>
@endsection
