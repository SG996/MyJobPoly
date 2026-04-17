@extends('layouts.master')

@section('title', 'Danh sách Việc Làm | MyJobCV')

@section('content')
    <section class="hero-section" style="padding: 30px 0; background: var(--light);">
        <div class="container">
            <form action="{{ route('jobs.list') }}" method="GET" class="search-box">
                <input type="text" name="keyword" class="search-input" placeholder="Vị trí ứng tuyển, tên công ty..." value="{{ request('keyword') }}">
                <select name="location" class="search-select">
                    <option value="all">Tất cả địa điểm</option>
                    <option value="Hà Nội" {{ request('location') == 'Hà Nội' ? 'selected' : '' }}>Hà Nội</option>
                    <option value="TP. Hồ Chí Minh" {{ request('location') == 'TP. Hồ Chí Minh' ? 'selected' : '' }}>TP. HCM</option>
                    <option value="Miền Bắc" {{ request('location') == 'Miền Bắc' ? 'selected' : '' }}>Miền Bắc</option>
                    <option value="Miền Nam" {{ request('location') == 'Miền Nam' ? 'selected' : '' }}>Miền Nam</option>
                </select>
                <select name="category_id" class="search-select">
                    <option value="all">Tất cả ngành nghề</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-primary">Tìm kiếm</button>
            </form>
        </div>
    </section>

    <section class="section-jobs container" style="margin-top: 30px;">
        <div class="section-header">
            <div class="section-title">
                <h2>
                    @if(request('keyword') || (request('category_id') && request('category_id') != 'all') || (request('location') && request('location') != 'all'))
                        Kết quả tìm kiếm
                    @else
                        Tất cả việc làm
                    @endif
                </h2>
                <p style="color: var(--text-muted); margin-top: 5px;">Hiển thị danh sách các việc làm tuyển dụng</p>
            </div>

            <div class="filter-section">
                <span class="filter-label"><i class="fas fa-filter"></i> Lọc theo:</span>
                @foreach($locations as $displayName => $dbValue)
                    <a href="{{ request()->fullUrlWithQuery(['location' => $dbValue ? $dbValue : 'all', 'page' => 1]) }}"
                       class="filter-tag {{ (request('location') == $dbValue) || (request('location') == 'all' && !$dbValue) || (!request('location') && !$dbValue) ? 'active' : '' }}">
                        {{ $displayName }}
                    </a>
                @endforeach
            </div>
        </div>

        <div class="job-grid">
            @forelse($jobs as $job)
                <a href="{{ url('/job/' . $job->id) }}" style="text-decoration: none;">
                    <div class="job-card">
                        <div class="job-header">
                            @php
                                $jcName = optional($job->company)->name ?? 'C';
                                $jcLetter = mb_strtoupper(mb_substr($jcName, 0, 1));
                                $jcGrads = [['#6366f1','#8b5cf6'],['#ec4899','#f43f5e'],['#f59e0b','#ef4444'],['#10b981','#059669'],['#3b82f6','#6366f1'],['#14b8a6','#10b981'],['#f97316','#ef4444'],['#8b5cf6','#ec4899'],['#0ea5e9','#3b82f6'],['#00b14f','#005a28']];
                                $jcIdx = abs(crc32($jcName)) % count($jcGrads);
                                $jcG1 = $jcGrads[$jcIdx][0]; $jcG2 = $jcGrads[$jcIdx][1];
                                $jcGid = 'jgp_' . $job->id;
                            @endphp
                            @if(optional($job->company)->logo)
                                <img src="{{ str_starts_with($job->company->logo, 'http') ? $job->company->logo : asset('storage/' . $job->company->logo) }}" 
                                     alt="Logo" class="job-logo" style="object-fit:cover;"
                                     onerror="this.style.display='none';this.nextElementSibling.style.display='block'">
                                <svg class="job-logo" style="display:none;object-fit:cover;" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg">
                                    <defs><linearGradient id="{{ $jcGid }}e" x1="0%" y1="0%" x2="100%" y2="100%">
                                        <stop offset="0%" style="stop-color:{{ $jcG1 }}"/><stop offset="100%" style="stop-color:{{ $jcG2 }}"/>
                                    </linearGradient></defs>
                                    <rect width="60" height="60" rx="4" fill="url(#{{ $jcGid }}e)"/>
                                    <text x="30" y="38" text-anchor="middle" font-family="Arial,sans-serif" font-size="24" font-weight="800" fill="white">{{ $jcLetter }}</text>
                                </svg>
                            @else
                                <svg class="job-logo" style="object-fit:cover;" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg">
                                    <defs><linearGradient id="{{ $jcGid }}" x1="0%" y1="0%" x2="100%" y2="100%">
                                        <stop offset="0%" style="stop-color:{{ $jcG1 }}"/><stop offset="100%" style="stop-color:{{ $jcG2 }}"/>
                                    </linearGradient></defs>
                                    <rect width="60" height="60" rx="4" fill="url(#{{ $jcGid }})"/>
                                    <text x="30" y="38" text-anchor="middle" font-family="Arial,sans-serif" font-size="24" font-weight="800" fill="white">{{ $jcLetter }}</text>
                                </svg>
                            @endif
                            <div class="job-info">
                                <h3>{{ $job->title }}</h3>
                                <p class="company-name">{{ optional($job->company)->name ?? 'Công ty ẩn danh' }}</p>
                            </div>
                        </div>
                        <div class="job-tags">
                            <span class="tag tag-salary">{{ $job->salary }}</span>
                            <span class="tag">{{ $job->location }}</span>
                            <span class="tag">Hạn: {{ \Carbon\Carbon::parse($job->deadline)->format('d/m/Y') }}</span>
                        </div>
                    </div>
                </a>
            @empty
                <div style="grid-column: span 3; text-align: center; padding: 40px; color: var(--text-muted);">
                    Hiện chưa thấy công việc nào phù hợp với điều kiện tìm kiếm của bạn.
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
    </section>
@endsection
