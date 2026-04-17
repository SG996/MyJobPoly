@extends('admin.layouts.app')

@section('title', 'Quản lý Bài viết')
@section('page-title', '📝 Quản lý Bài viết')
@section('page-subtitle', 'Danh sách tất cả bài viết trên hệ thống')

@section('content')

<div class="breadcrumb">
    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
    <span class="breadcrumb-sep">/</span>
    <span>Bài viết</span>
</div>

<div class="card">
    <div class="card-header">
        <div class="card-title">Danh sách bài viết ({{ $posts->total() }})</div>
        <a href="{{ route('admin.posts.create') }}" class="btn btn-primary">＋ Thêm bài viết</a>
    </div>
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th style="width:60px;">#</th>
                    <th style="width:80px;">Ảnh</th>
                    <th>Tiêu đề</th>
                    <th>Mô tả ngắn</th>
                    <th style="width:120px;">Trạng thái</th>
                    <th style="width:100px;">Ngày tạo</th>
                    <th style="text-align:right; width:160px;">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @forelse($posts as $post)
                <tr>
                    <td style="color:var(--text-secondary);font-size:12px;">{{ $post->id }}</td>
                    <td>
                        <img src="{{ $post->thumbnail_url }}" alt=""
                             style="width:52px;height:38px;object-fit:cover;border-radius:6px;border:1px solid var(--border);">
                    </td>
                    <td>
                        <div style="font-weight:600;max-width:260px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                            {{ $post->title }}
                        </div>
                        <div style="font-size:11px;color:var(--text-secondary);margin-top:2px;">
                            /{{ $post->slug }}
                        </div>
                    </td>
                    <td>
                        <div style="max-width:240px;font-size:13px;color:var(--text-secondary);
                                    white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                            {{ $post->excerpt ?? '—' }}
                        </div>
                    </td>
                    <td>
                        @if($post->is_published)
                            <span class="badge badge-success">● Công khai</span>
                        @else
                            <span class="badge badge-danger">● Ẩn</span>
                        @endif
                    </td>
                    <td style="color:var(--text-secondary);font-size:12px;">
                        {{ $post->created_at->format('d/m/Y') }}
                    </td>
                    <td>
                        <div style="display:flex;gap:5px;justify-content:flex-end;">
                            <a href="{{ url('/post-detail?slug=' . $post->slug) }}" target="_blank"
                               class="btn btn-outline btn-sm" title="Xem trước">👁</a>
                            <a href="{{ route('admin.posts.edit', $post->id) }}" class="btn btn-outline btn-sm">✏️</a>
                            <form action="{{ route('admin.posts.toggle', $post->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-sm {{ $post->is_published ? 'btn-warning' : 'btn-success' }}"
                                        style="{{ $post->is_published ? 'background:#f59e0b;color:#fff;' : '' }}"
                                        title="{{ $post->is_published ? 'Ẩn bài' : 'Công khai' }}">
                                    {{ $post->is_published ? '🔒' : '📢' }}
                                </button>
                            </form>
                            <form action="{{ route('admin.posts.destroy', $post->id) }}" method="POST" style="display:inline;"
                                  onsubmit="return confirm('Xác nhận xóa bài viết này?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">🗑</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align:center;padding:50px;color:var(--text-secondary);">
                        <div style="font-size:40px;margin-bottom:10px;opacity:.3;">📝</div>
                        Chưa có bài viết nào. <a href="{{ route('admin.posts.create') }}" style="color:var(--primary);">Tạo ngay →</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($posts->hasPages())
    <div class="card-body" style="border-top:1px solid var(--border);">
        <div class="pagination">
            @if($posts->onFirstPage())
                <span class="page-link" style="opacity:.4;">‹</span>
            @else
                <a href="{{ $posts->previousPageUrl() }}" class="page-link">‹</a>
            @endif
            @foreach($posts->getUrlRange(max(1,$posts->currentPage()-2), min($posts->lastPage(),$posts->currentPage()+2)) as $page => $url)
                <a href="{{ $url }}" class="page-link {{ $page == $posts->currentPage() ? 'active' : '' }}">{{ $page }}</a>
            @endforeach
            @if($posts->hasMorePages())
                <a href="{{ $posts->nextPageUrl() }}" class="page-link">›</a>
            @else
                <span class="page-link" style="opacity:.4;">›</span>
            @endif
        </div>
    </div>
    @endif
</div>

@endsection
