@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Tổng quan hệ thống MY-JOB-CV')

@section('content')

<!-- STAT CARDS -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon purple">💼</div>
        <div>
            <div class="stat-value">{{ $stats['total_jobs'] }}</div>
            <div class="stat-label">Tổng việc làm</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon green">✅</div>
        <div>
            <div class="stat-value">{{ $stats['active_jobs'] }}</div>
            <div class="stat-label">Đang hoạt động</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon blue">👥</div>
        <div>
            <div class="stat-value">{{ $stats['total_users'] }}</div>
            <div class="stat-label">Người dùng</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon orange">🏷️</div>
        <div>
            <div class="stat-value">{{ $stats['total_categories'] }}</div>
            <div class="stat-label">Danh mục</div>
        </div>
    </div>
</div>

<!-- RECENT JOBS -->
<div class="card">
    <div class="card-header">
        <div class="card-title">🕐 Việc làm mới nhất</div>
        <a href="{{ route('admin.jobs.index') }}" class="btn btn-outline btn-sm">Xem tất cả →</a>
    </div>
    <div class="card-body" style="padding: 0;">
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Tiêu đề công việc</th>
                        <th>Công ty</th>
                        <th>Danh mục</th>
                        <th>Địa điểm</th>
                        <th>Trạng thái</th>
                        <th>Ngày tạo</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($stats['recent_jobs'] as $job)
                    <tr>
                        <td style="color: var(--text-secondary); font-size: 12px;">{{ $job->id }}</td>
                        <td>
                            <div style="font-weight: 500;">{{ $job->title }}</div>
                        </td>
                        <td>{{ $job->company->name ?? '—' }}</td>
                        <td>{{ $job->category->name ?? '—' }}</td>
                        <td>{{ $job->location ?? '—' }}</td>
                        <td>
                            @if($job->is_active)
                                <span class="badge badge-success">● Hoạt động</span>
                            @else
                                <span class="badge badge-danger">● Ẩn</span>
                            @endif
                        </td>
                        <td style="color: var(--text-secondary); font-size: 12px;">{{ $job->created_at->format('d/m/Y') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" style="text-align: center; color: var(--text-secondary); padding: 40px;">Chưa có việc làm nào</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
