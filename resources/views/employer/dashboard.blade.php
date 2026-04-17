@extends('layouts.master')

@section('title', 'Bảng điều khiển nhà tuyển dụng | MyJobCV')

@section('content')
<div class="container account-grid">

    @include('partials.employer-sidebar', ['active' => 'dashboard'])

    <main class="account-content">

        {{-- HEADER --}}
        <div style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:15px; margin-bottom:28px;">
            <div>
                <h1 class="account-content-title" style="margin-bottom:4px;">
                    👋 Xin chào, {{ $company->name ?? Auth::user()->name }}!
                </h1>
                <p class="account-content-subtitle">Đây là bảng điều khiển tuyển dụng của bạn.</p>
            </div>
            <a href="{{ route('employer.jobs.create') }}" class="btn btn-primary" style="padding:12px 24px; font-weight:700; border-radius:10px; display:flex; align-items:center; gap:8px;">
                <span style="font-size:18px;">+</span> Đăng tin tuyển dụng
            </a>
        </div>

        {{-- Thông báo --}}
        @if(session('success'))
            <div style="background:#d1fae5; border:1px solid #6ee7b7; color:#065f46; padding:12px 16px; border-radius:8px; margin-bottom:20px; font-weight:500;">
                {{ session('success') }}
            </div>
        @endif

        {{-- THỐNG KÊ --}}
        <div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(180px,1fr)); gap:16px; margin-bottom:32px;">
            <div class="employer-stat-card" style="background:linear-gradient(135deg,#00b14f,#007a36);">
                <div class="employer-stat-icon">📋</div>
                <div class="employer-stat-number">{{ $totalJobs }}</div>
                <div class="employer-stat-label">Bài đăng</div>
            </div>
            <div class="employer-stat-card" style="background:linear-gradient(135deg,#3b82f6,#1d4ed8);">
                <div class="employer-stat-icon">✅</div>
                <div class="employer-stat-number">{{ $activeJobs }}</div>
                <div class="employer-stat-label">Đang hoạt động</div>
            </div>
            <div class="employer-stat-card" style="background:linear-gradient(135deg,#f59e0b,#d97706);">
                <div class="employer-stat-icon">📥</div>
                <div class="employer-stat-number">{{ $totalApplications }}</div>
                <div class="employer-stat-label">Tổng đơn ứng tuyển</div>
            </div>
            <div class="employer-stat-card" style="background:linear-gradient(135deg,#ef4444,#dc2626);">
                <div class="employer-stat-icon">⏳</div>
                <div class="employer-stat-number">{{ $pendingApplications }}</div>
                <div class="employer-stat-label">Chờ xét duyệt</div>
            </div>
        </div>

        {{-- HAI CỘT: BÀI ĐĂNG GẦN NHẤT + ĐƠN ỨNG TUYỂN GẦN NHẤT --}}
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:24px;">

            {{-- Bài đăng gần nhất --}}
            <div>
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:14px;">
                    <h2 style="font-size:16px; font-weight:700; color:#1e293b;">📋 Bài đăng gần nhất</h2>
                    <a href="{{ route('employer.jobs.index') }}" style="font-size:13px; color:var(--primary);">Xem tất cả →</a>
                </div>

                @forelse($recentJobs as $job)
                    <div style="background:#fff; border:1px solid #e2e8f0; border-radius:10px; padding:14px 16px; margin-bottom:10px; transition:box-shadow .2s;" onmouseover="this.style.boxShadow='0 4px 15px rgba(0,0,0,0.08)'" onmouseout="this.style.boxShadow='none'">
                        <div style="display:flex; justify-content:space-between; align-items:flex-start; gap:8px;">
                            <div>
                                <div style="font-weight:600; color:#1e293b; font-size:14px; margin-bottom:4px;">{{ $job->title }}</div>
                                <div style="font-size:12px; color:#64748b;">
                                    📥 {{ $job->applications->count() }} đơn ứng tuyển
                                    · 🗓️ HSD: {{ \Carbon\Carbon::parse($job->deadline)->format('d/m/Y') }}
                                </div>
                            </div>
                            <span style="font-size:11px; padding:3px 8px; border-radius:20px; font-weight:600; white-space:nowrap;
                                background:{{ $job->is_active ? '#d1fae5' : '#fee2e2' }};
                                color:{{ $job->is_active ? '#065f46' : '#991b1b' }};">
                                {{ $job->is_active ? 'Đang đăng' : 'Đã ẩn' }}
                            </span>
                        </div>
                    </div>
                @empty
                    <div style="text-align:center; padding:30px; color:#94a3b8; background:#f8fafc; border-radius:10px; border:2px dashed #e2e8f0;">
                        <div style="font-size:36px; margin-bottom:8px;">📋</div>
                        <div>Chưa có bài đăng nào.</div>
                        <a href="{{ route('employer.jobs.create') }}" style="color:var(--primary); font-weight:600; font-size:14px;">Đăng tin ngay →</a>
                    </div>
                @endforelse
            </div>

            {{-- Đơn ứng tuyển gần nhất --}}
            <div>
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:14px;">
                    <h2 style="font-size:16px; font-weight:700; color:#1e293b;">📥 Đơn ứng tuyển gần nhất</h2>
                    <a href="{{ route('employer.applications') }}" style="font-size:13px; color:var(--primary);">Xem tất cả →</a>
                </div>

                @forelse($recentApplications as $app)
                    <div style="background:#fff; border:1px solid #e2e8f0; border-radius:10px; padding:14px 16px; margin-bottom:10px;">
                        <div style="display:flex; justify-content:space-between; align-items:flex-start; gap:8px;">
                            <div>
                                <div style="font-weight:600; color:#1e293b; font-size:14px;">{{ $app->user->name ?? 'Ứng viên' }}</div>
                                <div style="font-size:12px; color:#64748b; margin-top:3px;">
                                    💼 {{ $app->job->title ?? '' }}
                                </div>
                                <div style="font-size:12px; color:#94a3b8; margin-top:2px;">
                                    🕐 {{ $app->created_at->diffForHumans() }}
                                </div>
                            </div>
                            @php
                                $statusStyle = match($app->status) {
                                    'approved' => ['bg'=>'#d1fae5','color'=>'#065f46','label'=>'✅ Đã duyệt'],
                                    'rejected' => ['bg'=>'#fee2e2','color'=>'#991b1b','label'=>'❌ Từ chối'],
                                    default    => ['bg'=>'#fef9c3','color'=>'#854d0e','label'=>'⏳ Chờ duyệt'],
                                };
                            @endphp
                            <span style="font-size:11px; padding:3px 8px; border-radius:20px; font-weight:600; white-space:nowrap; background:{{ $statusStyle['bg'] }}; color:{{ $statusStyle['color'] }};">
                                {{ $statusStyle['label'] }}
                            </span>
                        </div>
                    </div>
                @empty
                    <div style="text-align:center; padding:30px; color:#94a3b8; background:#f8fafc; border-radius:10px; border:2px dashed #e2e8f0;">
                        <div style="font-size:36px; margin-bottom:8px;">📥</div>
                        <div>Chưa có đơn ứng tuyển nào.</div>
                    </div>
                @endforelse
            </div>

        </div>

    </main>
</div>

<style>
.employer-stat-card {
    border-radius: 14px;
    padding: 20px;
    color: #fff;
    text-align: center;
    box-shadow: 0 4px 15px rgba(0,0,0,0.12);
    transition: transform .25s, box-shadow .25s;
}
.employer-stat-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.18);
}
.employer-stat-icon { font-size: 28px; margin-bottom: 8px; }
.employer-stat-number { font-size: 36px; font-weight: 800; line-height: 1; margin-bottom: 5px; }
.employer-stat-label { font-size: 13px; opacity: .88; font-weight: 500; }

@media (max-width: 768px) {
    .container.account-grid { grid-template-columns: 1fr !important; }
}
</style>
@endsection
