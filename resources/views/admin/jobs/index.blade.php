@extends('admin.layouts.app')

@section('title', 'Quản lý Việc làm')
@section('page-title', '💼 Quản lý Việc làm')
@section('page-subtitle', 'Danh sách tất cả việc làm trên hệ thống')

@section('content')

<div class="breadcrumb">
    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
    <span class="breadcrumb-sep">/</span>
    <span>Việc làm</span>
</div>

<div class="card">
    <div class="card-header">
        <div class="card-title">Danh sách việc làm ({{ $jobs->total() }})</div>
        <a href="{{ route('admin.jobs.create') }}" class="btn btn-primary">
            ＋ Thêm việc làm
        </a>
    </div>
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Tiêu đề</th>
                    <th>Công ty</th>
                    <th>Danh mục</th>
                    <th>Địa điểm</th>
                    <th>Lương</th>
                    <th>Trạng thái</th>
                    <th>Ngày tạo</th>
                    <th style="text-align:right;">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @forelse($jobs as $job)
                <tr>
                    <td style="color:var(--text-secondary);font-size:12px;">{{ $job->id }}</td>
                    <td>
                        <div style="font-weight:500;max-width:220px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $job->title }}</div>
                    </td>
                    <td>{{ $job->company->name ?? '—' }}</td>
                    <td>{{ $job->category->name ?? '—' }}</td>
                    <td>{{ $job->location ?? '—' }}</td>
                    <td>{{ $job->salary ?? '—' }}</td>
                    <td>
                        @if($job->is_active)
                            <span class="badge badge-success">● Hoạt động</span>
                        @else
                            <span class="badge badge-danger">● Ẩn</span>
                        @endif
                    </td>
                    <td style="color:var(--text-secondary);font-size:12px;">{{ $job->created_at->format('d/m/Y') }}</td>
                    <td>
                        <div style="display:flex;gap:6px;justify-content:flex-end;">
                            <a href="{{ route('admin.jobs.edit', $job->id) }}" class="btn btn-outline btn-sm">✏️ Sửa</a>
                            <form action="{{ route('admin.jobs.toggle', $job->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-sm {{ $job->is_active ? 'btn-warning' : 'btn-success' }}"
                                    style="{{ $job->is_active ? 'background:#f59e0b;color:#fff;' : '' }}">
                                    {{ $job->is_active ? '🔒 Ẩn' : '👁 Hiện' }}
                                </button>
                            </form>
                            <form action="{{ route('admin.jobs.destroy', $job->id) }}" method="POST" style="display:inline;"
                                  onsubmit="return confirm('Xác nhận xóa việc làm này?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">🗑 Xóa</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" style="text-align:center;padding:40px;color:var(--text-secondary);">
                        Chưa có việc làm nào.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($jobs->hasPages())
    <div class="card-body" style="border-top:1px solid var(--border);">
        <div class="pagination">
            {{-- Pagination links --}}
            @if($jobs->onFirstPage())
                <span class="page-link" style="opacity:.4;">‹</span>
            @else
                <a href="{{ $jobs->previousPageUrl() }}" class="page-link">‹</a>
            @endif

            @foreach($jobs->getUrlRange(max(1,$jobs->currentPage()-2), min($jobs->lastPage(),$jobs->currentPage()+2)) as $page => $url)
                <a href="{{ $url }}" class="page-link {{ $page == $jobs->currentPage() ? 'active' : '' }}">{{ $page }}</a>
            @endforeach

            @if($jobs->hasMorePages())
                <a href="{{ $jobs->nextPageUrl() }}" class="page-link">›</a>
            @else
                <span class="page-link" style="opacity:.4;">›</span>
            @endif
        </div>
    </div>
    @endif
</div>

@endsection
