@extends('layouts.master')

@section('title', ($currentCategory ? $currentCategory->name : 'Tất cả việc làm') . ' | MyJobCV')

@section('content')
    <div class="container category-page-grid">

        <aside class="category-sidebar-left">
            <h3 class="category-sidebar-title"><i class="fas fa-list"></i> Lọc theo ngành nghề</h3>
            <ul class="category-list-custom">
                <li>
                    <a href="{{ url('/danh-muc') }}" class="{{ !$currentCategory ? 'active' : '' }}">
                        <span>Tất cả ngành nghề</span>
                    </a>
                </li>

                @foreach($categories as $cat)
                    <li>
                        <a href="{{ url('/danh-muc/' . $cat->slug) }}"
                           class="{{ ($currentCategory && $currentCategory->id == $cat->id) ? 'active' : '' }}">
                            <span>{{ $cat->name }}</span>
                            <span style="font-size: 12px; background: var(--bg-gray); padding: 2px 8px; border-radius: 10px; color: #777;">
                                {{ $cat->jobs_count ?? 0 }}
                            </span>
                        </a>
                    </li>
                @endforeach
            </ul>
        </aside>

        <main class="category-main-content">

            <div class="section-header" style="margin-bottom: 25px; border-bottom: 1px solid #eee; padding-bottom: 15px;">
                <h1 style="font-size: 24px; color: var(--dark); margin: 0;">
                    Việc làm: <span style="color: var(--primary);">{{ $currentCategory ? $currentCategory->name : 'Tất cả ngành nghề' }}</span>
                </h1>
                <p style="color: var(--text-muted); margin-top: 8px; font-size: 15px;">Tìm thấy <strong>{{ $jobs->total() }}</strong> công việc phù hợp</p>
            </div>

            <div class="job-grid-custom">
                @forelse($jobs as $job)
                    <a href="{{ url('/job/' . $job->id) }}" style="text-decoration: none;">
                        <div class="job-card">
                            <div class="job-header">
                                <img src="{{ optional($job->company)->logo ?? 'https://via.placeholder.com/60' }}" alt="Logo" class="job-logo">
                                <div class="job-info">
                                    <h3>{{ $job->title }}</h3>
                                    <p class="company-name">{{ optional($job->company)->name ?? 'Công ty ẩn danh' }}</p>
                                </div>
                            </div>
                            <div class="job-tags">
                                <span class="tag tag-salary">{{ $job->salary }}</span>
                                <span class="tag">{{ $job->location }}</span>
                            </div>
                        </div>
                    </a>
                @empty
                    <div style="grid-column: span 3; text-align: center; padding: 60px; background: white; border-radius: 8px; border: 1px solid var(--border-color);">
                        <img src="https://cdn-icons-png.flaticon.com/512/7486/7486747.png" alt="Empty" style="width: 80px; opacity: 0.5; margin-bottom: 15px;">
                        <h3 style="color: var(--dark); margin-bottom: 5px;">Rất tiếc!</h3>
                        <p style="color: var(--text-muted);">Hiện chưa có công việc nào trong danh mục này.</p>
                        <a href="{{ url('/danh-muc') }}" class="btn btn-primary" style="margin-top: 15px; display: inline-block;">Xem tất cả việc làm</a>
                    </div>
                @endforelse
            </div>

            @if ($jobs->hasPages())
                <div class="pagination-container">
                    <ul class="my-pagination">
                        @if ($jobs->onFirstPage())
                            <li><span class="page-link-custom disabled">&#10094;</span></li>
                        @else
                            <li><a href="{{ $jobs->previousPageUrl() }}" class="page-link-custom">&#10094;</a></li>
                        @endif

                        @for ($i = 1; $i <= $jobs->lastPage(); $i++)
                            @if ($i == $jobs->currentPage())
                                <li><span class="page-link-custom active">{{ $i }}</span></li>
                            @else
                                <li><a href="{{ $jobs->url($i) }}" class="page-link-custom">{{ $i }}</a></li>
                            @endif
                        @endfor

                        @if ($jobs->hasMorePages())
                            <li><a href="{{ $jobs->nextPageUrl() }}" class="page-link-custom">&#10095;</a></li>
                        @else
                            <li><span class="page-link-custom disabled">&#10095;</span></li>
                        @endif
                    </ul>
                </div>
            @endif

        </main>
    </div>
@endsection