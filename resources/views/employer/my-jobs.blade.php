@extends('layouts.master')

@section('title', 'Quản lý bài đăng | MyJobCV')

@section('content')
<div class="container account-grid">

    @include('partials.employer-sidebar', ['active' => 'my-jobs'])

    <main class="account-content">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px;">
            <div>
                <h1 class="account-content-title" style="margin-bottom:4px;">📋 Quản lý bài đăng</h1>
                <p class="account-content-subtitle">Tất cả tin tuyển dụng của công ty bạn</p>
            </div>
            <a href="{{ route('employer.jobs.create') }}" class="btn btn-primary" style="padding:10px 20px; font-weight:700;">
                + Đăng tin mới
            </a>
        </div>

        @if(session('success'))
            <div style="background:#d1fae5; border:1px solid #6ee7b7; color:#065f46; padding:12px 16px; border-radius:8px; margin-bottom:20px;">
                {{ session('success') }}
            </div>
        @endif

        @if($jobs->count() > 0)
            <div style="background:#fff; border:1px solid #e2e8f0; border-radius:12px; overflow:hidden;">
                <table style="width:100%; border-collapse:collapse;">
                    <thead>
                        <tr style="background:#f8fafc; border-bottom:2px solid #e2e8f0;">
                            <th style="padding:14px 16px; text-align:left; font-size:13px; color:#64748b; font-weight:700; text-transform:uppercase;">Tiêu đề</th>
                            <th style="padding:14px 16px; text-align:center; font-size:13px; color:#64748b; font-weight:700; text-transform:uppercase;">Đơn ứng tuyển</th>
                            <th style="padding:14px 16px; text-align:center; font-size:13px; color:#64748b; font-weight:700; text-transform:uppercase;">Hạn nộp</th>
                            <th style="padding:14px 16px; text-align:center; font-size:13px; color:#64748b; font-weight:700; text-transform:uppercase;">Trạng thái</th>
                            <th style="padding:14px 16px; text-align:center; font-size:13px; color:#64748b; font-weight:700; text-transform:uppercase;">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($jobs as $job)
                        <tr style="border-bottom:1px solid #f1f5f9;" onmouseover="this.style.background='#fafafa'" onmouseout="this.style.background='transparent'">
                            <td style="padding:14px 16px;">
                                <div style="font-weight:600; color:#1e293b; font-size:14px;">{{ $job->title }}</div>
                                <div style="font-size:12px; color:#94a3b8; margin-top:3px;">
                                    📍 {{ $job->location }} · 💰 {{ $job->salary }}
                                </div>
                            </td>
                            <td style="padding:14px 16px; text-align:center;">
                                <a href="{{ route('employer.applications', ['job_id' => $job->id]) }}"
                                   style="background:#eff6ff; color:#2563eb; padding:4px 12px; border-radius:20px; font-size:13px; font-weight:700; text-decoration:none; display:inline-block;">
                                    {{ $job->applications_count }} đơn
                                </a>
                            </td>
                            <td style="padding:14px 16px; text-align:center; font-size:13px; color:#64748b;">
                                {{ \Carbon\Carbon::parse($job->deadline)->format('d/m/Y') }}
                            </td>
                            <td style="padding:14px 16px; text-align:center;">
                                <span style="padding:4px 12px; border-radius:20px; font-size:11px; font-weight:700;
                                    background:{{ $job->is_active ? '#d1fae5' : '#fee2e2' }};
                                    color:{{ $job->is_active ? '#065f46' : '#991b1b' }};">
                                    {{ $job->is_active ? '✅ Đang đăng' : '⛔ Đã ẩn' }}
                                </span>
                            </td>
                            <td style="padding:14px 16px; text-align:center;">
                                <div style="display:inline-flex; gap:6px; align-items:center;">
                                    <a href="{{ route('employer.jobs.edit', $job->id) }}"
                                       style="background:#eff6ff; color:#2563eb; border:none; padding:6px 12px; border-radius:6px; font-size:12px; font-weight:600; text-decoration:none;">
                                        ✏️ Sửa
                                    </a>
                                    <form action="{{ route('employer.jobs.toggle', $job->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" style="background:{{ $job->is_active ? '#fee2e2' : '#d1fae5' }}; color:{{ $job->is_active ? '#991b1b' : '#065f46' }}; border:none; padding:6px 12px; border-radius:6px; font-size:12px; font-weight:600; cursor:pointer;">
                                            {{ $job->is_active ? '⛔ Ẩn' : '✅ Bật' }}
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div style="margin-top:20px;">
                {{ $jobs->links() }}
            </div>
        @else
            <div style="text-align:center; padding:60px 20px; background:#f8fafc; border-radius:12px; border:2px dashed #e2e8f0;">
                <div style="font-size:56px; margin-bottom:16px;">📋</div>
                <h3 style="color:#1e293b; margin-bottom:8px;">Chưa có bài đăng nào</h3>
                <p style="color:#94a3b8; margin-bottom:20px;">Bắt đầu tuyển dụng bằng cách đăng tin việc làm đầu tiên của bạn!</p>
                <a href="{{ route('employer.jobs.create') }}" class="btn btn-primary" style="padding:12px 28px; font-weight:700;">
                    🚀 Đăng tin tuyển dụng ngay
                </a>
            </div>
        @endif

    </main>
</div>
@endsection
