@extends('layouts.master')

@section('title', 'Tuyển dụng, tìm việc làm lương cao | MyJobCV')

@section('content')

{{-- ============================================================
     HERO SECTION - REDESIGNED with Banner Carousel
============================================================ --}}
<section class="hero-v3">
    {{-- Banner Carousel Background --}}
    <div class="hero-banner-carousel" id="heroBannerCarousel">
        <div class="hbc-slide active" style="background-image: url('{{ asset('images/banner1.png') }}')"></div>
        <div class="hbc-slide" style="background-image: url('{{ asset('images/banner2.png') }}')"></div>
        <div class="hbc-slide" style="background-image: url('{{ asset('images/banner3.png') }}')"></div>
        <div class="hbc-overlay"></div>
    </div>

    {{-- Carousel dots --}}
    <div class="hbc-dots">
        <span class="hbc-dot active" onclick="goToSlide(0)"></span>
        <span class="hbc-dot" onclick="goToSlide(1)"></span>
        <span class="hbc-dot" onclick="goToSlide(2)"></span>
    </div>

    <div class="container hero-v3-inner">
        {{-- Left: Text content --}}
        <div class="hero-v3-text">
            <div class="hero-badge">
                <span class="hero-badge-dot"></span>
                {{ number_format($stats['jobs']) }}+ việc làm đang chờ bạn
            </div>
            <h1 class="hero-v3-title">
                Tìm <span class="hero-v3-accent">Công Việc<br>Mơ Ước</span> Của Bạn
            </h1>
            <p class="hero-v3-sub">
                Kết nối hàng nghìn ứng viên với các nhà tuyển dụng hàng đầu Việt Nam.
                Cơ hội nghề nghiệp đang chờ bạn khám phá ngay hôm nay!
            </p>

            {{-- Stats row --}}
            <div class="hero-v3-stats">
                <div class="hvs-item">
                    <div class="hvs-num">{{ number_format($stats['jobs']) }}+</div>
                    <div class="hvs-lbl">💼 Việc làm</div>
                </div>
                <div class="hvs-sep"></div>
                <div class="hvs-item">
                    <div class="hvs-num">{{ number_format($stats['companies']) }}+</div>
                    <div class="hvs-lbl">🏢 Công ty</div>
                </div>
                <div class="hvs-sep"></div>
                <div class="hvs-item">
                    <div class="hvs-num">{{ number_format($stats['users']) }}+</div>
                    <div class="hvs-lbl">👥 Ứng viên</div>
                </div>
            </div>
        </div>

        {{-- Right: Search Card (Glassmorphism) --}}
        <div class="hero-v3-card">
            <div class="hvc-header">
                <span class="hvc-icon">🔎</span>
                <span>Tìm việc làm ngay</span>
            </div>
            <form action="{{ route('jobs.list') }}" method="GET" class="hvc-form">
                <div class="hvc-field">
                    <label class="hvc-label">Vị trí / Công ty</label>
                    <div class="hvc-input-wrap">
                        <span class="hvc-fi">💼</span>
                        <input type="text" name="keyword" placeholder="Nhập tên vị trí, kỹ năng...">
                    </div>
                </div>
                <div class="hvc-field">
                    <label class="hvc-label">Khu vực</label>
                    <div class="hvc-input-wrap">
                        <span class="hvc-fi">📍</span>
                        <select name="location">
                            <option value="all">Tất cả khu vực</option>
                            <option value="Hà Nội">Hà Nội</option>
                            <option value="TP. Hồ Chí Minh">TP. Hồ Chí Minh</option>
                            <option value="Miền Bắc">Miền Bắc</option>
                            <option value="Miền Nam">Miền Nam</option>
                        </select>
                    </div>
                </div>
                <div class="hvc-field">
                    <label class="hvc-label">Ngành nghề</label>
                    <div class="hvc-input-wrap">
                        <span class="hvc-fi">🏷️</span>
                        <select name="category_id">
                            <option value="all">Tất cả ngành</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <button type="submit" class="hvc-btn">
                    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
                    Tìm kiếm việc làm
                </button>
            </form>
            <div class="hvc-tags">
                <span class="hvc-tags-label">Phổ biến:</span>
                @foreach($categories->take(4) as $cat)
                    <a href="{{ route('jobs.list', ['category_id' => $cat->id]) }}" class="hvc-tag">{{ $cat->name }}</a>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Wave --}}
    <div class="hero-wave">
        <svg viewBox="0 0 1440 80" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
            <path d="M0,40 C360,80 1080,0 1440,40 L1440,80 L0,80 Z" fill="#F3F5F7"/>
        </svg>
    </div>
</section>

{{-- Banner carousel JS --}}
<script>
(function() {
    var slides = document.querySelectorAll('.hbc-slide');
    var dots   = document.querySelectorAll('.hbc-dot');
    var cur    = 0;
    var timer;

    function goToSlide(n) {
        slides[cur].classList.remove('active');
        dots[cur].classList.remove('active');
        cur = (n + slides.length) % slides.length;
        slides[cur].classList.add('active');
        dots[cur].classList.add('active');
        clearInterval(timer);
        timer = setInterval(next, 5000);
    }
    window.goToSlide = goToSlide;

    function next() { goToSlide(cur + 1); }
    timer = setInterval(next, 5000);
})();
</script>

{{-- ============================================================
     DANH MỤC NGÀNH NGHỀ
============================================================ --}}
<section style="background:#F3F5F7; padding:48px 0 0;">
    <div class="container">
        <div class="section-head">
            <div>
                <h2 class="section-head-title">🏷️ Khám phá theo ngành nghề</h2>
                <p class="section-head-sub">Tìm kiếm việc làm theo đúng lĩnh vực chuyên môn của bạn</p>
            </div>
            <a href="{{ route('jobs.list') }}" class="btn-see-all">Xem tất cả →</a>
        </div>

        <div class="cat-grid">
            @foreach($categories as $cat)
            @php
                $icons = ['💻','📊','🏗️','🎨','💊','📚','🎯','🏭','🚗','🌿','💰','📱','⚖️','🔬','✈️','🏠'];
                $colors = ['#6366f1','#ec4899','#f59e0b','#10b981','#3b82f6','#8b5cf6','#ef4444','#06b6d4','#84cc16','#f97316','#14b8a6','#a855f7','#0ea5e9','#d946ef','#fb7185','#22d3ee'];
                $i = ($loop->index) % count($icons);
            @endphp
            <a href="{{ route('jobs.list', ['category_id' => $cat->id]) }}" class="cat-card">
                <div class="cat-icon" style="background:{{ $colors[$i] }}1a; color:{{ $colors[$i] }};">
                    {{ $icons[$i] }}
                </div>
                <div class="cat-name">{{ $cat->name }}</div>
                <div class="cat-count">
                    {{ $cat->jobs()->where('is_active', true)->count() }} việc làm
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>

{{-- ============================================================
     VIỆC LÀM NỔI BẬT
============================================================ --}}
<section style="background:#F3F5F7; padding:52px 0;">
    <div class="container">
        <div class="section-head">
            <div>
                <h2 class="section-head-title">💼 Việc làm nổi bật</h2>
                <p class="section-head-sub">{{ $jobs->total() }} cơ hội việc làm đang chờ bạn khám phá</p>
            </div>

            {{-- Filter location --}}
            <div class="location-filter">
                <a href="{{ url('/') }}"
                   class="lf-tag {{ !request('location') ? 'active' : '' }}">Tất cả</a>
                @foreach($locations as $name => $val)
                    @if($val)
                    <a href="{{ url('/') . '?location=' . urlencode($val) }}"
                       class="lf-tag {{ request('location') == $val ? 'active' : '' }}">{{ $name }}</a>
                    @endif
                @endforeach
            </div>
        </div>

        <div class="job-grid-v2">
            @forelse($jobs as $job)
            <a href="{{ url('/job/' . $job->id) }}" class="job-card-v2">
                {{-- Logo --}}
                <div class="jcv2-logo">
                    @php
                        $jcName = optional($job->company)->name ?? 'C';
                        $jcLetter = mb_strtoupper(mb_substr($jcName, 0, 1));
                        $jcGrads = [['#6366f1','#8b5cf6'],['#ec4899','#f43f5e'],['#f59e0b','#ef4444'],['#10b981','#059669'],['#3b82f6','#6366f1'],['#14b8a6','#10b981'],['#f97316','#ef4444'],['#8b5cf6','#ec4899'],['#0ea5e9','#3b82f6'],['#00b14f','#005a28']];
                        $jcIdx = abs(crc32($jcName)) % count($jcGrads);
                        $jcG1 = $jcGrads[$jcIdx][0]; $jcG2 = $jcGrads[$jcIdx][1];
                        $jcGid = 'jg' . $job->id;
                    @endphp
                    @if(optional($job->company)->logo)
                        <img src="{{ asset('storage/' . $job->company->logo) }}" alt="Logo"
                             style="width:52px;height:52px;object-fit:cover;border-radius:10px;display:block;"
                             onerror="this.style.display='none';this.nextElementSibling.style.display='block'">
                        <svg style="display:none;border-radius:10px;" width="52" height="52" viewBox="0 0 52 52" xmlns="http://www.w3.org/2000/svg">
                            <defs><linearGradient id="{{ $jcGid }}e" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" style="stop-color:{{ $jcG1 }}"/><stop offset="100%" style="stop-color:{{ $jcG2 }}"/>
                            </linearGradient></defs>
                            <rect width="52" height="52" rx="10" fill="url(#{{ $jcGid }}e)"/>
                            <text x="26" y="34" text-anchor="middle" font-family="Arial,sans-serif" font-size="22" font-weight="800" fill="white">{{ $jcLetter }}</text>
                        </svg>
                    @else
                        <svg width="52" height="52" viewBox="0 0 52 52" xmlns="http://www.w3.org/2000/svg" style="border-radius:10px;display:block;">
                            <defs><linearGradient id="{{ $jcGid }}" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" style="stop-color:{{ $jcG1 }}"/><stop offset="100%" style="stop-color:{{ $jcG2 }}"/>
                            </linearGradient></defs>
                            <rect width="52" height="52" rx="10" fill="url(#{{ $jcGid }})"/>
                            <text x="26" y="34" text-anchor="middle" font-family="Arial,sans-serif" font-size="22" font-weight="800" fill="white">{{ $jcLetter }}</text>
                        </svg>
                    @endif
                </div>

                {{-- Info --}}
                <div class="jcv2-info">
                    <div class="jcv2-company">{{ optional($job->company)->name ?? 'Công ty ẩn danh' }}</div>
                    <h3 class="jcv2-title">{{ $job->title }}</h3>
                    <div class="jcv2-tags">
                        <span class="jcv2-tag salary">💰 {{ $job->salary }}</span>
                        <span class="jcv2-tag">📍 {{ $job->location }}</span>
                        <span class="jcv2-tag">🎓 {{ $job->experience }}</span>
                    </div>
                </div>

                {{-- Deadline --}}
                @php $dl = \Carbon\Carbon::now()->diffInDays(\Carbon\Carbon::parse($job->deadline), false); @endphp
                <div class="jcv2-footer">
                    @if($dl > 0)
                        <span class="jcv2-deadline ok">Còn {{ intval($dl) }} ngày</span>
                    @else
                        <span class="jcv2-deadline over">Hết hạn</span>
                    @endif
                    <span class="jcv2-apply">Ứng tuyển →</span>
                </div>
            </a>
            @empty
            <div style="grid-column:1/-1; text-align:center; padding:60px; color:#94a3b8;">
                <div style="font-size:48px; margin-bottom:12px;">📭</div>
                <p>Chưa có việc làm phù hợp tại khu vực này.</p>
            </div>
            @endforelse
        </div>

        {{-- Phân trang --}}
        @if($jobs->hasPages())
        <div class="pagination-v2">
            @if($jobs->onFirstPage())
                <span class="pv2-btn disabled">‹</span>
            @else
                <a href="{{ $jobs->previousPageUrl() }}" class="pv2-btn">‹</a>
            @endif

            @foreach($jobs->getUrlRange(max(1,$jobs->currentPage()-2), min($jobs->lastPage(),$jobs->currentPage()+2)) as $pg => $url)
                <a href="{{ $url }}" class="pv2-btn {{ $pg == $jobs->currentPage() ? 'active' : '' }}">{{ $pg }}</a>
            @endforeach

            @if($jobs->hasMorePages())
                <a href="{{ $jobs->nextPageUrl() }}" class="pv2-btn">›</a>
            @else
                <span class="pv2-btn disabled">›</span>
            @endif
        </div>
        @endif

        <div style="text-align:center; margin-top:24px;">
            <a href="{{ route('jobs.list') }}" class="btn-see-all-lg">
                Xem tất cả {{ number_format($stats['jobs']) }} việc làm →
            </a>
        </div>
    </div>
</section>

{{-- ============================================================
     CÔNG TY NỔI BẬT
============================================================ --}}
@if($topCompanies->count())
<section class="section-companies">
    <div class="container">
        <div class="section-head">
            <div>
                <h2 class="section-head-title">🏢 Công ty hàng đầu</h2>
                <p class="section-head-sub">Những doanh nghiệp đang tích cực tuyển dụng nhất</p>
            </div>
            <a href="{{ route('jobs.list') }}" class="btn-see-all">Xem tất cả →</a>
        </div>

        <div class="company-grid">
            @foreach($topCompanies as $co)
            @php
                $coLetter = mb_strtoupper(mb_substr($co->name, 0, 1));
                $coGrads = [
                    ['#6366f1','#8b5cf6'], ['#ec4899','#f43f5e'], ['#f59e0b','#ef4444'],
                    ['#10b981','#059669'], ['#3b82f6','#6366f1'], ['#14b8a6','#10b981'],
                    ['#f97316','#ef4444'], ['#8b5cf6','#ec4899'], ['#0ea5e9','#3b82f6'],
                    ['#00b14f','#005a28']
                ];
                $cgi = abs(crc32($co->name)) % count($coGrads);
                $cg1 = $coGrads[$cgi][0]; $cg2 = $coGrads[$cgi][1];
                $cgid = 'cg' . $co->id;
            @endphp
            <a href="{{ route('company.show', $co->id) }}" class="company-card">
                <div class="cc-logo">
                    @php
                        $cgFallback = 'data:image/svg+xml;charset=utf-8,' . rawurlencode('<svg width="64" height="64" viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg"><defs><linearGradient id="' . $cgid . 'f" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" style="stop-color:' . $cg1 . '"/><stop offset="100%" style="stop-color:' . $cg2 . '"/></linearGradient></defs><rect width="64" height="64" rx="12" fill="url(#' . $cgid . 'f)"/><text x="32" y="42" text-anchor="middle" font-family="Arial,sans-serif" font-size="26" font-weight="800" fill="white">' . $coLetter . '</text></svg>');
                    @endphp
                    @if($co->logo)
                        <img src="{{ asset('storage/' . $co->logo) }}" alt="{{ $co->name }}"
                             style="width:100%;height:100%;object-fit:cover;border-radius:12px;display:block;"
                             onerror="this.style.display='none';this.nextElementSibling.style.display='block'">
                        <svg style="display:none;border-radius:12px;" width="64" height="64" viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg">
                            <defs>
                                <linearGradient id="{{ $cgid }}e" x1="0%" y1="0%" x2="100%" y2="100%">
                                    <stop offset="0%" style="stop-color:{{ $cg1 }}"/>
                                    <stop offset="100%" style="stop-color:{{ $cg2 }}"/>
                                </linearGradient>
                            </defs>
                            <rect width="64" height="64" rx="12" fill="url(#{{ $cgid }}e)"/>
                            <text x="32" y="42" text-anchor="middle" font-family="Arial,sans-serif" font-size="26" font-weight="800" fill="white">{{ $coLetter }}</text>
                        </svg>
                    @else
                        <svg width="64" height="64" viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg" style="border-radius:12px;display:block;">
                            <defs>
                                <linearGradient id="{{ $cgid }}" x1="0%" y1="0%" x2="100%" y2="100%">
                                    <stop offset="0%" style="stop-color:{{ $cg1 }}"/>
                                    <stop offset="100%" style="stop-color:{{ $cg2 }}"/>
                                </linearGradient>
                            </defs>
                            <rect width="64" height="64" rx="12" fill="url(#{{ $cgid }})"/>
                            <text x="32" y="42" text-anchor="middle" font-family="Arial,sans-serif" font-size="26" font-weight="800" fill="white">{{ $coLetter }}</text>
                        </svg>
                    @endif
                </div>
                <div class="cc-name">{{ Str::limit($co->name, 30) }}</div>
                <div class="cc-jobs">{{ $co->jobs_count }} vị trí tuyển dụng</div>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ============================================================
     BANNER KÊU GỌI NHÀ TUYỂN DỤNG
============================================================ --}}
<section class="section-cta-employer">
    <div class="container">
        <div class="cta-employer-box">
            <div class="cta-emp-left">
                <div style="font-size:52px; margin-bottom:16px;">🚀</div>
                <h2 style="font-size:26px; font-weight:800; color:#fff; margin-bottom:10px; line-height:1.3;">
                    Bạn là nhà tuyển dụng?
                </h2>
                <p style="color:rgba(255,255,255,.85); font-size:15px; line-height:1.7; max-width:480px;">
                    Đăng tin tuyển dụng miễn phí và tiếp cận hàng nghìn ứng viên chất lượng cao đang tìm kiếm cơ hội mới mỗi ngày.
                </p>
                <div style="display:flex; gap:12px; margin-top:24px; flex-wrap:wrap;">
                    <a href="{{ route('register.employer') }}"
                       style="background:#fff; color:#00b14f; padding:13px 28px; border-radius:8px;
                              font-weight:700; font-size:15px; text-decoration:none; transition:all .2s;"
                       onmouseover="this.style.transform='translateY(-2px)'"
                       onmouseout="this.style.transform=''">
                        Đăng ký nhà tuyển dụng
                    </a>
                    <a href="{{ route('jobs.list') }}"
                       style="background:rgba(255,255,255,.15); color:#fff; padding:13px 28px;
                              border-radius:8px; font-weight:600; font-size:15px; text-decoration:none;
                              border:1.5px solid rgba(255,255,255,.3); transition:all .2s;"
                       onmouseover="this.style.background='rgba(255,255,255,.25)'"
                       onmouseout="this.style.background='rgba(255,255,255,.15)'">
                        Xem việc làm →
                    </a>
                </div>
            </div>
            <div class="cta-emp-right">
                <div class="cta-badge-stack">
                    <div class="cta-badge">
                        <span style="font-size:22px;">✅</span>
                        <div><strong>Đăng tin miễn phí</strong><br><span>Không mất phí ban đầu</span></div>
                    </div>
                    <div class="cta-badge">
                        <span style="font-size:22px;">👥</span>
                        <div><strong>{{ number_format($stats['users']) }}+ ứng viên</strong><br><span>Đang tìm kiếm việc làm</span></div>
                    </div>
                    <div class="cta-badge">
                        <span style="font-size:22px;">⚡</span>
                        <div><strong>Phê duyệt nhanh</strong><br><span>Tin đăng lên ngay lập tức</span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ============================================================
     BÀI VIẾT MỚI NHẤT
============================================================ --}}
@if($latestPosts->count())
<section style="background:#F3F5F7; padding:52px 0;">
    <div class="container">
        <div class="section-head">
            <div>
                <h2 class="section-head-title">📚 Cẩm nang nghề nghiệp</h2>
                <p class="section-head-sub">Bí kíp tìm việc, viết CV và phát triển sự nghiệp từ chuyên gia</p>
            </div>
            <a href="{{ route('posts.list') }}" class="btn-see-all">Xem tất cả →</a>
        </div>

        <div class="post-grid-home">
            @foreach($latestPosts as $post)
            <a href="{{ route('post.detail', $post->slug) }}" class="post-card-home">
                <div class="pch-img">
                    <img src="{{ $post->thumbnail_url }}" alt="{{ $post->title }}">
                    <div class="pch-overlay">Đọc ngay →</div>
                </div>
                <div class="pch-body">
                    <div class="pch-date">{{ $post->created_at->format('d/m/Y') }}</div>
                    <h3 class="pch-title">{{ $post->title }}</h3>
                    <p class="pch-excerpt">
                        {{ $post->excerpt ?? Str::limit(strip_tags($post->content), 100) }}
                    </p>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ============================================================
     CSS INLINE
============================================================ --}}
<style>
/* =========================================================
   HERO V3 - Banner Carousel + Glassmorphism card
   ========================================================= */
.hero-v3 {
    position: relative;
    min-height: 600px;
    display: flex;
    align-items: center;
    overflow: hidden;
    padding: 80px 0 100px;
}

/* Banner Carousel */
.hero-banner-carousel { position: absolute; inset: 0; z-index: 0; }
.hbc-slide {
    position: absolute; inset: 0;
    background-size: cover; background-position: center;
    opacity: 0; transition: opacity 1.2s ease;
}
.hbc-slide.active { opacity: 1; }
.hbc-overlay {
    position: absolute; inset: 0;
    background: linear-gradient(
        135deg,
        rgba(0,30,15,.88) 0%,
        rgba(0,90,45,.75) 50%,
        rgba(0,160,70,.58) 100%
    );
}

/* Carousel dots */
.hbc-dots {
    position: absolute; bottom: 96px; left: 50%;
    transform: translateX(-50%); z-index: 10;
    display: flex; gap: 8px;
}
.hbc-dot {
    width: 10px; height: 10px; border-radius: 50%;
    background: rgba(255,255,255,.4); cursor: pointer;
    transition: all .35s; border: none;
}
.hbc-dot.active { background: #fff; width: 28px; border-radius: 5px; }

/* Hero v3 inner layout */
.hero-v3-inner {
    position: relative; z-index: 2;
    display: grid;
    grid-template-columns: 1fr 460px;
    gap: 60px; align-items: center;
}

/* Hero v3 text */
.hero-v3-text { color: #fff; }

.hero-badge {
    display: inline-flex; align-items: center; gap: 8px;
    background: rgba(255,255,255,.13);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255,255,255,.25);
    border-radius: 40px;
    padding: 6px 16px 6px 10px;
    font-size: 13px; font-weight: 600; color: #fff;
    margin-bottom: 22px;
}
.hero-badge-dot {
    width: 8px; height: 8px; border-radius: 50%;
    background: #4ade80;
    animation: pulse-dot 2s infinite;
    display: inline-block; flex-shrink: 0;
}
@keyframes pulse-dot {
    0%, 100% { box-shadow: 0 0 0 0 rgba(74,222,128,.6); }
    50% { box-shadow: 0 0 0 7px rgba(74,222,128,0); }
}

.hero-v3-title {
    font-size: 52px; font-weight: 900;
    line-height: 1.1; margin-bottom: 18px; color: #fff;
    text-shadow: 0 2px 20px rgba(0,0,0,.25);
}
.hero-v3-accent {
    background: linear-gradient(90deg, #4ade80, #a3e635);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}
.hero-v3-sub {
    font-size: 16px; color: rgba(255,255,255,.85);
    line-height: 1.75; margin-bottom: 36px; max-width: 500px;
}

/* Stats glassbox */
.hero-v3-stats {
    display: flex; align-items: center;
    background: rgba(255,255,255,.1);
    backdrop-filter: blur(12px);
    border: 1px solid rgba(255,255,255,.2);
    border-radius: 14px; padding: 16px 24px;
    max-width: 420px;
}
.hvs-item { flex: 1; text-align: center; }
.hvs-num { font-size: 26px; font-weight: 800; color: #fff; line-height: 1; margin-bottom: 4px; }
.hvs-lbl { font-size: 12px; color: rgba(255,255,255,.75); font-weight: 600; }
.hvs-sep { width: 1px; height: 40px; background: rgba(255,255,255,.25); margin: 0 8px; }

/* Glassmorphism Search Card */
.hero-v3-card {
    background: rgba(255,255,255,.97);
    backdrop-filter: blur(20px);
    border-radius: 20px; padding: 28px;
    box-shadow: 0 24px 80px rgba(0,0,0,.3), 0 0 0 1px rgba(255,255,255,.4) inset;
}
.hvc-header {
    display: flex; align-items: center; gap: 10px;
    font-size: 17px; font-weight: 800; color: #1e293b;
    margin-bottom: 20px; padding-bottom: 16px;
    border-bottom: 2px solid #f1f5f9;
}
.hvc-icon { font-size: 22px; }
.hvc-form { display: flex; flex-direction: column; gap: 14px; margin-bottom: 16px; }
.hvc-field { display: flex; flex-direction: column; gap: 6px; }
.hvc-label { font-size: 12px; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: .5px; }
.hvc-input-wrap {
    display: flex; align-items: center; gap: 10px;
    border: 1.5px solid #e2e8f0; border-radius: 10px; padding: 0 14px;
    transition: border-color .2s, box-shadow .2s;
}
.hvc-input-wrap:focus-within {
    border-color: #00b14f;
    box-shadow: 0 0 0 3px rgba(0,177,79,.1);
}
.hvc-fi { font-size: 16px; flex-shrink: 0; }
.hvc-input-wrap input, .hvc-input-wrap select {
    border: none; outline: none; background: transparent;
    font-size: 14px; color: #1e293b; width: 100%;
    padding: 13px 0; font-family: inherit; cursor: pointer;
}
.hvc-btn {
    background: linear-gradient(135deg, #00b14f, #00913f);
    color: #fff; border: none; cursor: pointer;
    padding: 15px 24px; border-radius: 10px;
    font-size: 15px; font-weight: 700; font-family: inherit;
    display: flex; align-items: center; justify-content: center; gap: 8px;
    transition: all .25s; box-shadow: 0 4px 16px rgba(0,177,79,.35);
}
.hvc-btn:hover {
    background: linear-gradient(135deg, #00913f, #005a28);
    transform: translateY(-2px); box-shadow: 0 8px 24px rgba(0,177,79,.45);
}
.hvc-tags { display: flex; align-items: center; flex-wrap: wrap; gap: 6px; }
.hvc-tags-label { font-size: 12px; color: #94a3b8; font-weight: 600; }
.hvc-tag {
    background: #f0fdf4; color: #00913f; border: 1px solid #bbf7d0;
    padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 600;
    text-decoration: none; transition: all .2s;
}
.hvc-tag:hover { background: #00b14f; color: #fff; border-color: #00b14f; }

.hero-wave { position: absolute; bottom: 0; left: 0; right: 0; line-height: 0; z-index: 3; }
.hero-wave svg { display: block; width: 100%; }

/* =========================================================
   SECTION SHARED
   ========================================================= */
.section-head {
    display: flex; justify-content: space-between; align-items: flex-end;
    margin-bottom: 28px;
}
.section-head-title { font-size: 22px; font-weight: 800; color: #1e293b; margin-bottom: 4px; }
.section-head-sub { font-size: 14px; color: #64748b; }
.btn-see-all {
    color: #00b14f; font-size: 14px; font-weight: 700;
    text-decoration: none; white-space: nowrap; transition: color .2s;
}
.btn-see-all:hover { color: #005a28; }

/* Category grid */
.cat-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(140px, 1fr)); gap: 14px; }
.cat-card {
    background: #fff; border-radius: 12px; padding: 20px 14px;
    text-align: center; text-decoration: none;
    border: 1.5px solid #e2e8f0; transition: all .22s; cursor: pointer;
}
.cat-card:hover { border-color: #00b14f; box-shadow: 0 6px 24px rgba(0,177,79,.12); transform: translateY(-3px); }
.cat-icon { width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 22px; margin: 0 auto 10px; }
.cat-name { font-size: 13px; font-weight: 700; color: #1e293b; margin-bottom: 4px; }
.cat-count { font-size: 12px; color: #00b14f; font-weight: 600; }

/* Location filter */
.location-filter { display: flex; gap: 6px; flex-wrap: wrap; }
.lf-tag { padding: 6px 14px; border-radius: 20px; font-size: 13px; font-weight: 600; text-decoration: none; background: #fff; color: #64748b; border: 1.5px solid #e2e8f0; transition: all .2s; }
.lf-tag.active, .lf-tag:hover { background: #00b14f; color: #fff; border-color: #00b14f; }

/* Job grid */
.job-grid-v2 { display: grid; grid-template-columns: repeat(auto-fill, minmax(340px, 1fr)); gap: 16px; margin-bottom: 28px; }
.job-card-v2 { background: #fff; border-radius: 12px; padding: 20px; border: 1.5px solid #e2e8f0; text-decoration: none; display: flex; flex-direction: column; gap: 14px; transition: all .22s; }
.job-card-v2:hover { border-color: #00b14f; box-shadow: 0 8px 28px rgba(0,177,79,.12); transform: translateY(-3px); }
.jcv2-logo { width: 52px; height: 52px; border-radius: 10px; overflow: hidden; flex-shrink: 0; display: flex; align-items: center; justify-content: center; }
.jcv2-logo img { width: 100%; height: 100%; object-fit: cover; }
.jcv2-company { font-size: 12px; color: #64748b; font-weight: 600; margin-bottom: 4px; }
.jcv2-title { font-size: 15px; font-weight: 700; color: #1e293b; line-height: 1.4; margin: 0; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
.job-card-v2:hover .jcv2-title { color: #00b14f; }
.jcv2-tags { display: flex; flex-wrap: wrap; gap: 6px; margin-top: 8px; }
.jcv2-tag { padding: 3px 10px; border-radius: 20px; font-size: 12px; font-weight: 500; background: #f1f5f9; color: #475569; }
.jcv2-tag.salary { background: rgba(0,177,79,.1); color: #00913f; font-weight: 700; }
.jcv2-footer { display: flex; justify-content: space-between; align-items: center; margin-top: auto; }
.jcv2-deadline { font-size: 12px; font-weight: 700; padding: 3px 10px; border-radius: 20px; }
.jcv2-deadline.ok { background: #f0fdf4; color: #16a34a; border: 1px solid #bbf7d0; }
.jcv2-deadline.over { background: #fef2f2; color: #dc2626; border: 1px solid #fecaca; }
.jcv2-apply { font-size: 12px; font-weight: 700; color: #00b14f; opacity: 0; transition: opacity .2s; }
.job-card-v2:hover .jcv2-apply { opacity: 1; }

/* Pagination */
.pagination-v2 { display: flex; justify-content: center; gap: 6px; }
.pv2-btn { width: 36px; height: 36px; border-radius: 8px; display: flex; align-items: center; justify-content: center; border: 1.5px solid #e2e8f0; color: #64748b; font-size: 14px; font-weight: 600; text-decoration: none; transition: all .2s; }
.pv2-btn.active, .pv2-btn:hover { background: #00b14f; color: #fff; border-color: #00b14f; }
.pv2-btn.disabled { opacity: .35; pointer-events: none; }

.btn-see-all-lg { display: inline-block; padding: 14px 36px; background: transparent; color: #00b14f; border: 2px solid #00b14f; border-radius: 8px; font-size: 15px; font-weight: 700; text-decoration: none; transition: all .2s; }
.btn-see-all-lg:hover { background: #00b14f; color: #fff; }

/* Company section */
.section-companies { background: #fff; padding: 52px 0; }
.company-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(160px, 1fr)); gap: 16px; }
.company-card { background: #fafafa; border: 1.5px solid #e2e8f0; border-radius: 12px; padding: 24px 16px; text-align: center; text-decoration: none; transition: all .22s; }
.company-card:hover { border-color: #00b14f; box-shadow: 0 6px 24px rgba(0,177,79,.1); transform: translateY(-2px); background: #fff; }
.cc-logo { width: 64px; height: 64px; border-radius: 12px; margin: 0 auto 12px; overflow: hidden; display: flex; align-items: center; justify-content: center; }
.cc-logo img { width: 100%; height: 100%; object-fit: cover; }
.cc-name { font-size: 13px; font-weight: 700; color: #1e293b; margin-bottom: 4px; line-height: 1.4; }
.cc-jobs { font-size: 12px; color: #00b14f; font-weight: 600; }

/* CTA Employer */
.section-cta-employer { background: #F3F5F7; padding: 52px 0; }
.cta-employer-box { background: linear-gradient(135deg, #00b14f, #005a28); border-radius: 20px; padding: 52px; display: grid; grid-template-columns: 1fr auto; gap: 48px; align-items: center; position: relative; overflow: hidden; }
.cta-employer-box::before { content: '🚀'; position: absolute; right: -20px; top: -20px; font-size: 200px; opacity: .06; pointer-events: none; }
.cta-badge-stack { display: flex; flex-direction: column; gap: 14px; }
.cta-badge { display: flex; align-items: center; gap: 14px; background: rgba(255,255,255,.12); border: 1px solid rgba(255,255,255,.2); border-radius: 12px; padding: 14px 18px; min-width: 240px; }
.cta-badge strong { display: block; color: #fff; font-size: 14px; margin-bottom: 2px; }
.cta-badge span { color: rgba(255,255,255,.75); font-size: 12px; }

/* Posts */
.post-grid-home { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; }
.post-card-home { background: #fff; border-radius: 12px; overflow: hidden; text-decoration: none; border: 1.5px solid #e2e8f0; transition: all .22s; display: flex; flex-direction: column; }
.post-card-home:hover { border-color: #00b14f; box-shadow: 0 8px 28px rgba(0,177,79,.1); transform: translateY(-3px); }
.pch-img { height: 180px; overflow: hidden; position: relative; }
.pch-img img { width: 100%; height: 100%; object-fit: cover; transition: transform .3s; }
.post-card-home:hover .pch-img img { transform: scale(1.05); }
.pch-overlay { position: absolute; inset: 0; background: rgba(0,177,79,.7); display: flex; align-items: center; justify-content: center; color: #fff; font-size: 14px; font-weight: 700; opacity: 0; transition: opacity .25s; }
.post-card-home:hover .pch-overlay { opacity: 1; }
.pch-body { padding: 18px; flex: 1; }
.pch-date { font-size: 11px; color: #94a3b8; margin-bottom: 6px; font-weight: 600; }
.pch-title { font-size: 15px; font-weight: 700; color: #1e293b; line-height: 1.4; margin-bottom: 8px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; transition: color .2s; }
.post-card-home:hover .pch-title { color: #00b14f; }
.pch-excerpt { font-size: 13px; color: #64748b; line-height: 1.6; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; }

/* Responsive */
@media (max-width: 1280px) {
    .hero-v3-inner { grid-template-columns: 1fr 400px; gap: 40px; }
    .hero-v3-title { font-size: 42px; }
}
@media (max-width: 1024px) {
    .hero-v3-inner { grid-template-columns: 1fr; gap: 32px; }
    .hero-v3-title { font-size: 36px; }
    .hero-v3-sub { max-width: 100%; }
    .hero-v3-stats { max-width: 100%; }
    .post-grid-home { grid-template-columns: 1fr 1fr; }
    .cta-employer-box { grid-template-columns: 1fr; }
}
@media (max-width: 768px) {
    .hero-v3 { padding: 60px 0 80px; min-height: auto; }
    .hero-v3-title { font-size: 28px; }
    .hbc-dots { bottom: 76px; }
    .job-grid-v2 { grid-template-columns: 1fr; }
    .post-grid-home { grid-template-columns: 1fr; }
    .cat-grid { grid-template-columns: repeat(3, 1fr); }
    .company-grid { grid-template-columns: repeat(3, 1fr); }
    .cta-employer-box { padding: 28px; }
    .section-head { flex-direction: column; align-items: flex-start; gap: 10px; }
}
</style>

@endsection

