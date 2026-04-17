@extends('layouts.master')

@section('title', $post->title . ' | MyJobCV')

@section('content')
<div class="container" style="margin-top:28px; margin-bottom:60px;">

    {{-- Breadcrumb --}}
    <div class="breadcrumb">
        <a href="{{ url('/') }}">Trang chủ</a>
        <span style="margin:0 6px; opacity:.5;">/</span>
        <a href="{{ route('posts.list') }}">Góc nghề nghiệp</a>
        <span style="margin:0 6px; opacity:.5;">/</span>
        <span style="color:var(--text-main);">{{ Str::limit($post->title, 50) }}</span>
    </div>

    <div class="job-detail-grid">

        {{-- ===== NỘI DUNG CHÍNH ===== --}}
        <div class="main-content">
            <div class="content-block">

                {{-- Ảnh bìa --}}
                <div style="margin:-30px -30px 28px; border-radius:8px 8px 0 0; overflow:hidden; max-height:380px;">
                    <img src="{{ $post->thumbnail_url }}" alt="{{ $post->title }}"
                         style="width:100%; height:380px; object-fit:cover; display:block;">
                </div>

                {{-- Header bài viết --}}
                <div class="article-header">
                    <h1 class="article-title">{{ $post->title }}</h1>
                    <div class="article-meta">
                        <img src="https://ui-avatars.com/api/?name=MyJobCV&background=00b14f&color=fff&size=80"
                             alt="Author" style="border-radius:50%;">
                        <div>
                            <strong>MyJobCV Blog</strong><br>
                            <span>Đăng ngày {{ $post->created_at->format('d/m/Y') }}
                                • Cập nhật {{ $post->updated_at->format('d/m/Y') }}
                                • Đọc {{ max(1, round(str_word_count(strip_tags($post->content)) / 200)) }} phút
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Tóm tắt nếu có --}}
                @if($post->excerpt)
                <div style="background:#f0fdf4; border-left:4px solid #00b14f; padding:14px 18px;
                            border-radius:0 8px 8px 0; margin-bottom:24px; color:#374151;
                            font-style:italic; font-size:15px; line-height:1.7;">
                    {{ $post->excerpt }}
                </div>
                @endif

                {{-- Nội dung bài viết --}}
                <div class="article-content">
                    {!! $post->content !!}
                </div>

                {{-- CTA cuối bài --}}
                <div style="margin-top:36px; padding:24px; background:linear-gradient(135deg,#f0fdf4,#dcfce7);
                            border-radius:12px; border:1px solid #bbf7d0; text-align:center;">
                    <p style="font-size:16px; font-weight:700; color:#065f46; margin-bottom:12px;">
                        🚀 Sẵn sàng bước vào thị trường lao động?
                    </p>
                    <a href="{{ route('jobs.list') }}" class="btn btn-primary"
                       style="display:inline-block; padding:12px 28px; font-size:15px;">
                        Xem việc làm ngay →
                    </a>
                </div>

                {{-- Bài viết liên quan --}}
                @if($relatedPosts->count())
                <div style="margin-top:36px;">
                    <h2 style="font-size:20px; font-weight:700; color:var(--dark); margin-bottom:16px;
                               border-left:4px solid var(--primary); padding-left:12px;">
                        Bài viết liên quan
                    </h2>
                    <div style="display:grid; grid-template-columns:repeat(2,1fr); gap:16px;">
                        @foreach($relatedPosts as $related)
                        <a href="{{ route('post.detail', $related->slug) }}"
                           style="display:flex; gap:12px; text-decoration:none; border:1px solid #e2e8f0;
                                  border-radius:10px; padding:12px; background:#fafafa; transition:all .2s;"
                           onmouseover="this.style.borderColor='#00b14f'; this.style.background='#fff';"
                           onmouseout="this.style.borderColor='#e2e8f0'; this.style.background='#fafafa';">
                            <img src="{{ $related->thumbnail_url }}" alt="{{ $related->title }}"
                                 style="width:72px; height:56px; object-fit:cover; border-radius:6px; flex-shrink:0;">
                            <div>
                                <div style="font-size:13px; font-weight:600; color:#1e293b; line-height:1.4;
                                            display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">
                                    {{ $related->title }}
                                </div>
                                <div style="font-size:11px; color:#94a3b8; margin-top:4px;">
                                    {{ $related->created_at->format('d/m/Y') }}
                                </div>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif

            </div>
        </div>

        {{-- ===== SIDEBAR ===== --}}
        <aside class="sidebar">

            {{-- Việc làm HOT --}}
            <div class="content-block sidebar-block">
                <h3>💼 Việc làm HOT</h3>
                @foreach($hotJobs as $job)
                <div class="sidebar-job-item">
                    @if(optional($job->company)->logo)
                        <img src="{{ asset('storage/' . $job->company->logo) }}"
                             alt="Logo" class="sidebar-job-img">
                    @else
                        <div class="sidebar-job-img"
                             style="background:linear-gradient(135deg,#00b14f,#005a28);
                                    display:flex;align-items:center;justify-content:center;
                                    font-size:20px;color:#fff;border-radius:4px;">
                            🏢
                        </div>
                    @endif
                    <div class="sidebar-job-info">
                        <h4><a href="{{ url('/job/' . $job->id) }}"
                               style="color:#333; text-decoration:none;">{{ Str::limit($job->title, 38) }}</a></h4>
                        <div class="company">{{ optional($job->company)->name }}</div>
                        <div class="salary">{{ $job->salary }}</div>
                    </div>
                </div>
                @endforeach

                <a href="{{ route('jobs.list') }}"
                   style="display:block; text-align:center; margin-top:14px; padding:9px;
                          background:var(--primary); color:#fff; border-radius:6px;
                          font-size:13px; font-weight:600; text-decoration:none;">
                    Xem tất cả việc làm →
                </a>
            </div>

            {{-- Quảng cáo / CTA --}}
            <div class="content-block" style="background:linear-gradient(135deg,#00b14f,#005a28); text-align:center; padding:24px;">
                <div style="font-size:36px; margin-bottom:10px;">📋</div>
                <h3 style="color:#fff; font-size:16px; margin-bottom:8px;">Tạo CV miễn phí</h3>
                <p style="color:rgba(255,255,255,.85); font-size:13px; margin-bottom:14px; line-height:1.6;">
                    Hàng nghìn nhà tuyển dụng đang tìm kiếm ứng viên phù hợp!
                </p>
                <a href="{{ route('register') }}"
                   style="display:block; background:#fff; color:#00b14f; padding:10px;
                          border-radius:6px; font-size:13px; font-weight:700; text-decoration:none;">
                    Đăng ký ngay →
                </a>
            </div>

        </aside>
    </div>
</div>

<style>
.article-content h2 {
    font-size: 20px;
    border-left: 4px solid var(--primary);
    padding-left: 10px;
    margin: 28px 0 14px;
    color: var(--dark);
}
.article-content h3 {
    font-size: 17px;
    margin: 22px 0 10px;
    color: var(--dark);
    font-weight: 700;
}
.article-content p {
    margin-bottom: 16px;
    line-height: 1.85;
    color: #374151;
}
.article-content ul, .article-content ol {
    padding-left: 20px;
    margin-bottom: 16px;
    line-height: 1.85;
    color: #374151;
}
.article-content ul { list-style: disc; }
.article-content ol { list-style: decimal; }
.article-content li { margin-bottom: 8px; }
.article-content strong { color: #1e293b; }
.article-content img {
    max-width: 100%; border-radius: 8px; margin: 18px 0; display: block;
}
</style>
@endsection