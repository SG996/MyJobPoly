@extends('admin.layouts.app')
@section('title', 'Quản lý Dự án Freelance')

@section('content')
<div class="flex-between" style="margin-bottom:24px;">
    <div>
        <h1 style="font-size:22px; font-weight:800; color:#1e293b;">💼 Dự án Freelance</h1>
        <p style="color:#64748b; font-size:14px;">Quản lý tất cả mini tasks trên hệ thống</p>
    </div>
</div>

{{-- Stats --}}
<div style="display:grid; grid-template-columns:repeat(4,1fr); gap:16px; margin-bottom:24px;">
    <div class="content-block" style="text-align:center; padding:20px;">
        <div style="font-size:26px; font-weight:800; color:#7c3aed;">{{ $stats['total'] }}</div>
        <div style="font-size:13px; color:#64748b;">Tổng dự án</div>
    </div>
    <div class="content-block" style="text-align:center; padding:20px;">
        <div style="font-size:26px; font-weight:800; color:#16a34a;">{{ $stats['open'] }}</div>
        <div style="font-size:13px; color:#64748b;">Đang mở</div>
    </div>
    <div class="content-block" style="text-align:center; padding:20px;">
        <div style="font-size:26px; font-weight:800; color:#2563eb;">{{ $stats['in_progress'] }}</div>
        <div style="font-size:13px; color:#64748b;">Đang thực hiện</div>
    </div>
    <div class="content-block" style="text-align:center; padding:20px;">
        <div style="font-size:26px; font-weight:800; color:#d97706;">{{ $stats['completed'] }}</div>
        <div style="font-size:13px; color:#64748b;">Hoàn thành</div>
    </div>
</div>

<div class="content-block">
    @if(session('success'))
        <div style="background:#f0fdf4; border:1px solid #bbf7d0; border-radius:8px; padding:12px 16px; margin-bottom:16px; color:#166534; font-size:14px; font-weight:600;">✅ {{ session('success') }}</div>
    @endif

    <table class="admin-table" style="width:100%; border-collapse:collapse; font-size:13px;">
        <thead>
            <tr style="border-bottom:2px solid #e2e8f0; text-align:left;">
                <th style="padding:12px 8px; color:#475569; font-weight:700;">ID</th>
                <th style="padding:12px 8px; color:#475569; font-weight:700;">Dự án</th>
                <th style="padding:12px 8px; color:#475569; font-weight:700;">Loại</th>
                <th style="padding:12px 8px; color:#475569; font-weight:700;">Ngân sách</th>
                <th style="padding:12px 8px; color:#475569; font-weight:700;">Ứng viên</th>
                <th style="padding:12px 8px; color:#475569; font-weight:700;">Trạng thái</th>
                <th style="padding:12px 8px; color:#475569; font-weight:700;">Hạn nộp</th>
                <th style="padding:12px 8px; color:#475569; font-weight:700;">Hành động</th>
            </tr>
        </thead>
        <tbody>
            @forelse($tasks as $task)
            <tr style="border-bottom:1px solid #f1f5f9;">
                <td style="padding:12px 8px; color:#94a3b8;">#{{ $task->id }}</td>
                <td style="padding:12px 8px;">
                    <div style="font-weight:700; color:#1e293b;">{{ Str::limit($task->title, 45) }}</div>
                    <div style="font-size:11px; color:#64748b;">{{ optional(optional($task->employer)->company)->name ?? $task->employer->name }}</div>
                </td>
                <td style="padding:12px 8px;">
                    <span style="background:{{ $task->type==='internship' ? '#f0fdf4' : '#eff6ff' }}; color:{{ $task->type==='internship' ? '#16a34a' : '#2563eb' }}; padding:3px 10px; border-radius:20px; font-size:11px; font-weight:700;">
                        {{ $task->type === 'internship' ? '🎓 Thực tập' : '💼 Freelance' }}
                    </span>
                </td>
                <td style="padding:12px 8px; font-weight:600; color:#7c3aed;">{{ $task->budgetFormatted() }}</td>
                <td style="padding:12px 8px; text-align:center;">{{ $task->applications_count }}</td>
                <td style="padding:12px 8px;">
                    @php $sc = ['open'=>'#16a34a','in_progress'=>'#2563eb','completed'=>'#d97706','cancelled'=>'#dc2626'][$task->status] ?? '#64748b'; @endphp
                    <span style="background:{{ $sc }}18; color:{{ $sc }}; padding:3px 10px; border-radius:20px; font-size:11px; font-weight:700;">
                        {{ ['open'=>'Đang mở','in_progress'=>'Đang làm','completed'=>'Xong','cancelled'=>'Đã hủy'][$task->status] ?? $task->status }}
                    </span>
                </td>
                <td style="padding:12px 8px; color:#ef4444; font-size:12px;">{{ $task->deadline->format('d/m/Y') }}</td>
                <td style="padding:12px 8px;">
                    <form action="{{ route('admin.mini-tasks.toggle', $task->id) }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" style="background:{{ $task->is_active ? '#fef9c3' : '#f0fdf4' }}; color:{{ $task->is_active ? '#854d0e' : '#166534' }}; border:none; padding:4px 10px; border-radius:6px; font-size:11px; font-weight:700; cursor:pointer;">
                            {{ $task->is_active ? 'Ẩn' : 'Hiện' }}
                        </button>
                    </form>
                    <form action="{{ route('admin.mini-tasks.destroy', $task->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Xóa dự án này?')">
                        @csrf @method('DELETE')
                        <button type="submit" style="background:#fee2e2; color:#991b1b; border:none; padding:4px 10px; border-radius:6px; font-size:11px; font-weight:700; cursor:pointer; margin-left:4px;">Xóa</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="8" style="padding:48px; text-align:center; color:#94a3b8;">Chưa có dự án nào.</td></tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top:16px;">{{ $tasks->links() }}</div>
</div>
@endsection
