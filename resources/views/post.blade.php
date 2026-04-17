@extends('layouts.master')

@section('title', 'Cẩm nang nghề nghiệp - Góc chia sẻ | MyJobCV')

@section('content')
<div class="container" style="margin-top:32px; margin-bottom:60px;">

    <div class="job-detail-grid">

        {{-- ===== CỘT CHÍNH ===== --}}
        <div class="main-content">
            <div class="content-block">

                {{-- Header --}}
                <div class="blog-list-header">
                    <h1 class="blog-list-title">📚 Cẩm Nang Nghề Nghiệp</h1>
                    <p style="color:var(--text-muted); font-size:14px; margin-top:6px;">
                        Tổng hợp {{ $posts->total() }} bài viết hữu ích về nghề nghiệp, kỹ năng & thị trường lao động
                    </p>
                </div>

                {{-- Danh sách bài viết --}}
                @forelse($posts as $post)
                <article class="article-card">
                    <a href="{{ route('post.detail', $post->slug) }}" class="article-img-wrapper">
                        <img src="{{ $post->thumbnail_url }}" alt="{{ $post->title }}" class="article-card-img">
                    </a>
                    <div class="article-card-content">
                        <a href="{{ route('post.detail', $post->slug) }}" class="article-card-title">
                            {{ $post->title }}
                        </a>
                        <div class="article-card-meta">
                            {{ $post->created_at->format('d/m/Y') }} • Bởi MyJobCV Team
                        </div>
                        <p class="article-card-excerpt">
                            {{ $post->excerpt ?? mb_substr(strip_tags($post->content), 0, 160) . '...' }}
                        </p>
                        <a href="{{ route('post.detail', $post->slug) }}"
                           style="display:inline-block; margin-top:10px; font-size:13px; font-weight:600;
                                  color: var(--primary); text-decoration:none;">
                            Đọc tiếp →
                        </a>
                    </div>
                </article>
                @empty
                <div style="text-align:center; padding:60px 20px; color:var(--text-muted);">
                    <div style="font-size:48px; margin-bottom:12px;">📭</div>
                    <p>Chưa có bài viết nào.</p>
                </div>
                @endforelse

                {{-- Phân trang --}}
                @if($posts->hasPages())
                <div class="pagination" style="margin-top:24px;">
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
                @endif

            </div>
        </div>

        {{-- ===== SIDEBAR ===== --}}
        <aside class="sidebar">

            {{-- Bài viết mới nhất --}}
            <div class="content-block sidebar-block">
                <h3>🔥 Bài viết nổi bật</h3>
                <ul class="category-list">
                    @foreach($recentPosts as $recent)
                    <li style="border-bottom:1px dashed #eee; padding:10px 0;">
                        <a href="{{ route('post.detail', $recent->slug) }}"
                           style="color:var(--text-main); font-size:13px; font-weight:600;
                                  display:block; line-height:1.5; text-decoration:none;
                                  transition:color .2s;"
                           onmouseover="this.style.color='var(--primary)'"
                           onmouseout="this.style.color='var(--text-main)'">
                            {{ $recent->title }}
                        </a>
                        <span style="font-size:11px; color:var(--text-muted);">
                            {{ $recent->created_at->format('d/m/Y') }}
                        </span>
                    </li>
                    @endforeach
                </ul>
            </div>

            {{-- Việc làm HOT --}}
            <div class="content-block sidebar-block">
                <h3>💼 Việc làm HOT</h3>
                @foreach($hotJobs as $job)
                <div class="sidebar-job-item">
                    @if(optional($job->company)->logo)
                        <img src="{{ asset('storage/' . $job->company->logo) }}"
                             alt="Logo" class="sidebar-job-img">
                    @else
                        <div class="sidebar-job-img" style="background:linear-gradient(135deg,#00b14f,#005a28);
                             display:flex;align-items:center;justify-content:center;font-size:20px;color:#fff;">
                            🏢
                        </div>
                    @endif
                    <div class="sidebar-job-info">
                        <h4><a href="{{ url('/job/' . $job->id) }}"
                               style="color:#333; text-decoration:none;">{{ Str::limit($job->title, 40) }}</a></h4>
                        <div class="company">{{ optional($job->company)->name }}</div>
                        <div class="salary">{{ $job->salary }}</div>
                    </div>
                </div>
                @endforeach
            </div>

        </aside>
    </div>
</div>
@endsection