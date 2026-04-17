@extends('layouts.master')

@section('title', ($company->name ?? 'Công ty') . ' | MyJobCV')

@section('content')

{{-- ========== HERO BANNER CÔNG TY ========== --}}
<div class="company-hero">
    <div class="container">
        <div class="company-hero-inner">

            {{-- Logo --}}
            <div class="company-hero-logo">
                @if($company->logo)
                    <img src="{{ asset('storage/' . $company->logo) }}" alt="{{ $company->name }}">
                @else
                    <div class="company-logo-placeholder">
                        {{ mb_substr($company->name, 0, 1) }}
                    </div>
                @endif
            </div>

            {{-- Thông tin chính --}}
            <div class="company-hero-info">
                <h1 class="company-hero-name">{{ $company->name }}</h1>

                <div class="company-hero-meta">
                    @if($company->address)
                        <span class="company-meta-item">
                            📍 {{ $company->address }}
                        </span>
                    @endif
                    @if($company->hotline)
                        <span class="company-meta-item">
                            📞 {{ $company->hotline }}
                        </span>
                    @endif
                    @if($company->email)
                        <span class="company-meta-item">
                            ✉️ {{ $company->email }}
                        </span>
                    @endif
                </div>

                <div class="company-hero-stats">
                    <div class="company-stat-badge">
                        <span class="badge-number">{{ $totalJobs }}</span>
                        <span class="badge-label">Việc làm Full-time</span>
                    </div>
                    @if(isset($totalMiniTasks) && $totalMiniTasks > 0)
                    <div class="company-stat-badge" style="background:rgba(124,58,237,0.2); border-color:rgba(124,58,237,0.4);">
                        <span class="badge-number" style="color:#e9d5ff;">{{ $totalMiniTasks }}</span>
                        <span class="badge-label" style="color:#ddd6fe;">Mini Task & Freelance</span>
                    </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>

{{-- ========== NỘI DUNG CHÍNH ========== --}}
<div class="container company-body">

    <div class="company-layout">

        {{-- CỘT TRÁI: Giới thiệu + Danh sách việc --}}
        <div class="company-main">

            {{-- Giới thiệu công ty --}}
            @if($company->description)
            <div class="company-section-card">
                <div class="company-section-heading">
                    <span class="section-icon">🏢</span>
                    Giới thiệu công ty
                </div>
                <div class="company-description">
                    {!! nl2br(e($company->description)) !!}
                </div>
            </div>
            @endif

            {{-- Danh sách việc làm --}}
            <div class="company-section-card">
                <div class="company-section-heading">
                    <span class="section-icon">💼</span>
                    Việc làm đang tuyển
                    <span class="job-count-badge">{{ $totalJobs }}</span>
                </div>

                @forelse($jobs as $job)
                    <a href="{{ url('/job/' . $job->id) }}" class="company-job-card">
                        <div class="company-job-info">
                            <div class="company-job-title">{{ $job->title }}</div>
                            <div class="company-job-tags">
                                <span class="cjt salary">💰 {{ $job->salary }}</span>
                                <span class="cjt location">📍 {{ $job->location }}</span>
                                <span class="cjt exp">🎓 {{ $job->experience }}</span>
                                @if($job->category)
                                    <span class="cjt cat">🏷️ {{ $job->category->name }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="company-job-deadline">
                            @php
                                $daysLeft = \Carbon\Carbon::now()->diffInDays(\Carbon\Carbon::parse($job->deadline), false);
                            @endphp
                            @if($daysLeft > 0)
                                <span class="deadline-remaining">Còn {{ intval($daysLeft) }} ngày</span>
                            @else
                                <span class="deadline-over">Hết hạn</span>
                            @endif
                            <div class="apply-arrow">Ứng tuyển →</div>
                        </div>
                    </a>
                @empty
                    <div class="company-no-jobs">
                        <div style="font-size:48px; margin-bottom:12px; opacity:.4;">📭</div>
                        <p>Hiện tại chưa có tin tuyển dụng nào.</p>
                    </div>
                @endforelse

                {{-- Phân trang --}}
                @if($jobs->hasPages())
                    <div style="margin-top:20px;">
                        {{ $jobs->appends(request()->except('jobs_page'))->links() }}
                    </div>
                @endif
            </div>

            {{-- Danh sách Mini Tasks --}}
            <div class="company-section-card">
                <div class="company-section-heading">
                    <span class="section-icon">🗂️</span>
                    Mini Tasks & Freelance
                    <span class="job-count-badge" style="color:#7c3aed; background:#faf5ff; border-color:#ddd6fe;">{{ $totalMiniTasks ?? 0 }}</span>
                </div>

                @forelse($miniTasks as $mt)
                    <a href="{{ url('/freelance/' . $mt->slug) }}" class="company-job-card" style="border-left:4px solid {{ $mt->type === 'internship' ? '#10b981' : '#7c3aed' }};">
                        <div class="company-job-info">
                            <div class="company-job-title">{{ $mt->title }}</div>
                            <div class="company-job-tags">
                                <span class="cjt" style="background:{{ $mt->type === 'internship' ? '#ecfdf5' : '#f3e8ff' }}; color:{{ $mt->type === 'internship' ? '#059669' : '#6d28d9' }};">
                                    {{ $mt->type === 'internship' ? '🎓 Thực tập' : '💼 Freelance' }}
                                </span>
                                <span class="cjt salary">💰 {{ number_format($mt->budget_min, 0, ',', '.') }}{{ $mt->budget_max ? ' - '.number_format($mt->budget_max, 0, ',', '.') : '' }}đ</span>
                                <span class="cjt location">📍 {{ $mt->location }}</span>
                            </div>
                        </div>
                        <div class="company-job-deadline">
                            @php
                                $daysLeftMt = \Carbon\Carbon::now()->diffInDays(\Carbon\Carbon::parse($mt->deadline), false);
                            @endphp
                            @if($daysLeftMt > 0)
                                <span class="deadline-remaining" style="color:#7c3aed; background:#f3e8ff; border-color:#e9d5ff;">Còn {{ intval($daysLeftMt) }} ngày</span>
                            @else
                                <span class="deadline-over">Hết hạn</span>
                            @endif
                            <div class="apply-arrow" style="color:#7c3aed;">Xem chi tiết →</div>
                        </div>
                    </a>
                @empty
                    <div class="company-no-jobs">
                        <div style="font-size:48px; margin-bottom:12px; opacity:.4;">📭</div>
                        <p>Hiện tại chưa có mini task hay dự án freelance nào.</p>
                    </div>
                @endforelse

                {{-- Phân trang --}}
                @if(isset($miniTasks) && $miniTasks->hasPages())
                    <div style="margin-top:20px;">
                        {{ $miniTasks->appends(request()->except('minitasks_page'))->links() }}
                    </div>
                @endif
            </div>

        </div>

        {{-- CỘT PHẢI: Thông tin nhanh --}}
        <aside class="company-sidebar">
            <div class="company-section-card">
                <div class="company-section-heading" style="margin-bottom:16px;">
                    <span class="section-icon">ℹ️</span>
                    Thông tin công ty
                </div>

                <div class="company-info-list">
                    @if($company->tax_code)
                        <div class="company-info-row">
                            <span class="ci-label">🏷️ Mã số thuế</span>
                            <span class="ci-value">{{ $company->tax_code }}</span>
                        </div>
                    @endif
                    @if($company->email)
                        <div class="company-info-row">
                            <span class="ci-label">✉️ Email</span>
                            <span class="ci-value">{{ $company->email }}</span>
                        </div>
                    @endif
                    @if($company->hotline)
                        <div class="company-info-row">
                            <span class="ci-label">📞 Hotline</span>
                            <span class="ci-value">{{ $company->hotline }}</span>
                        </div>
                    @endif
                    @if($company->address)
                        <div class="company-info-row">
                            <span class="ci-label">📍 Địa chỉ</span>
                            <span class="ci-value">{{ $company->address }}</span>
                        </div>
                    @endif
                    <div class="company-info-row">
                        <span class="ci-label">💼 Vị trí Full-time</span>
                        <span class="ci-value" style="color:#00b14f; font-weight:700;">{{ $totalJobs }} vị trí</span>
                    </div>
                    <div class="company-info-row">
                        <span class="ci-label">🗂️ Mini Task / Freelance</span>
                        <span class="ci-value" style="color:#7c3aed; font-weight:700;">{{ $totalMiniTasks ?? 0 }} vị trí</span>
                    </div>
                </div>
            </div>

            {{-- CTA --}}
            @auth
                @if(auth()->user()->role == 0)
                    <div class="company-cta-card">
                        <div style="font-size:32px; margin-bottom:10px;">🚀</div>
                        <p>Ứng tuyển ngay để không bỏ lỡ cơ hội tiếp theo!</p>
                        <a href="{{ url('/jobs') }}" class="btn btn-primary"
                           style="display:block; text-align:center; margin-top:14px; padding:12px;">
                            Xem tất cả việc làm
                        </a>
                    </div>
                @endif
            @else
                <div class="company-cta-card">
                    <div style="font-size:32px; margin-bottom:10px;">👋</div>
                    <p>Đăng ký tài khoản để ứng tuyển ngay hôm nay!</p>
                    <a href="{{ route('register') }}" class="btn btn-primary"
                       style="display:block; text-align:center; margin-top:14px; padding:12px;">
                        Đăng ký miễn phí
                    </a>
                </div>
            @endauth
        </aside>
    </div>
</div>

<style>
/* ===== HERO ===== */
.company-hero {
    background: linear-gradient(135deg, #00b14f 0%, #005a28 100%);
    padding: 48px 0 40px;
    position: relative;
    overflow: hidden;
}

.company-hero::before {
    content: '';
    position: absolute;
    inset: 0;
    background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.04'%3E%3Ccircle cx='30' cy='30' r='20'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
}

.company-hero-inner {
    display: flex;
    align-items: center;
    gap: 32px;
    position: relative;
    z-index: 1;
}

.company-hero-logo {
    flex-shrink: 0;
    width: 120px;
    height: 120px;
    border-radius: 20px;
    background: #fff;
    border: 4px solid rgba(255,255,255,.3);
    overflow: hidden;
    box-shadow: 0 8px 32px rgba(0,0,0,.2);
    display: flex;
    align-items: center;
    justify-content: center;
}

.company-hero-logo img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.company-logo-placeholder {
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, #00b14f, #005a28);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 52px;
    font-weight: 800;
    color: #fff;
}

.company-hero-name {
    font-size: 28px;
    font-weight: 800;
    color: #fff;
    margin: 0 0 12px;
    line-height: 1.3;
    text-shadow: 0 2px 8px rgba(0,0,0,.15);
}

.company-hero-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 14px;
    margin-bottom: 18px;
}

.company-meta-item {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    color: rgba(255,255,255,.9);
    font-size: 14px;
    font-weight: 500;
}

.company-hero-stats { display: flex; gap: 16px; }

.company-stat-badge {
    background: rgba(255,255,255,.15);
    backdrop-filter: blur(8px);
    border: 1px solid rgba(255,255,255,.25);
    border-radius: 12px;
    padding: 10px 20px;
    text-align: center;
    color: #fff;
}

.badge-number {
    display: block;
    font-size: 24px;
    font-weight: 800;
    line-height: 1;
    margin-bottom: 2px;
}

.badge-label {
    font-size: 12px;
    opacity: .85;
    font-weight: 500;
}

/* ===== BODY LAYOUT ===== */
.company-body { padding: 32px 0 60px; }

.company-layout {
    display: grid;
    grid-template-columns: 1fr 320px;
    gap: 24px;
    align-items: start;
}

/* ===== SECTION CARD ===== */
.company-section-card {
    background: #fff;
    border-radius: 14px;
    border: 1px solid #e2e8f0;
    padding: 28px;
    margin-bottom: 20px;
    box-shadow: 0 2px 12px rgba(0,0,0,.04);
}

.company-section-heading {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 17px;
    font-weight: 800;
    color: #1e293b;
    border-bottom: 2px solid #f1f5f9;
    padding-bottom: 14px;
    margin-bottom: 20px;
}

.section-icon { font-size: 18px; }

.job-count-badge {
    margin-left: auto;
    background: #f0fdf4;
    color: #00b14f;
    border: 1px solid #bbf7d0;
    font-size: 12px;
    font-weight: 700;
    padding: 2px 10px;
    border-radius: 20px;
}

/* ===== MÔ TẢ ===== */
.company-description {
    font-size: 15px;
    line-height: 1.85;
    color: #374151;
}

/* ===== JOB CARD TRONG CÔNG TY ===== */
.company-job-card {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 16px 18px;
    border: 1px solid #e2e8f0;
    border-radius: 10px;
    margin-bottom: 12px;
    text-decoration: none;
    transition: all .22s;
    background: #fafafa;
    gap: 16px;
}

.company-job-card:hover {
    border-color: #00b14f;
    background: #fff;
    box-shadow: 0 4px 18px rgba(0,177,79,.1);
    transform: translateY(-2px);
}

.company-job-info { flex: 1; }

.company-job-title {
    font-size: 15px;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 8px;
    line-height: 1.4;
    transition: color .2s;
}

.company-job-card:hover .company-job-title { color: #00b14f; }

.company-job-tags { display: flex; flex-wrap: wrap; gap: 6px; }

.cjt {
    display: inline-block;
    padding: 3px 10px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 500;
    background: #f1f5f9;
    color: #475569;
}

.cjt.salary { background: rgba(0,177,79,.1); color: #00913f; font-weight: 600; }

.company-job-deadline {
    flex-shrink: 0;
    text-align: right;
}

.deadline-remaining {
    display: inline-block;
    background: #f0fdf4;
    color: #16a34a;
    border: 1px solid #bbf7d0;
    font-size: 12px;
    font-weight: 700;
    padding: 4px 10px;
    border-radius: 20px;
    margin-bottom: 8px;
    white-space: nowrap;
}

.deadline-over {
    display: inline-block;
    background: #fef2f2;
    color: #dc2626;
    border: 1px solid #fecaca;
    font-size: 12px;
    font-weight: 700;
    padding: 4px 10px;
    border-radius: 20px;
    margin-bottom: 8px;
    white-space: nowrap;
}

.apply-arrow {
    font-size: 12px;
    font-weight: 600;
    color: #00b14f;
    opacity: 0;
    transition: opacity .2s;
    white-space: nowrap;
}

.company-job-card:hover .apply-arrow { opacity: 1; }

.company-no-jobs {
    text-align: center;
    padding: 40px 20px;
    color: #94a3b8;
    font-size: 14px;
}

/* ===== SIDEBAR INFO ===== */
.company-info-list { display: flex; flex-direction: column; gap: 14px; }

.company-info-row {
    display: flex;
    flex-direction: column;
    gap: 4px;
    padding-bottom: 14px;
    border-bottom: 1px dashed #e2e8f0;
}

.company-info-row:last-child { border-bottom: none; padding-bottom: 0; }

.ci-label {
    font-size: 12px;
    color: #94a3b8;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: .4px;
}

.ci-value {
    font-size: 14px;
    font-weight: 600;
    color: #334155;
    line-height: 1.4;
}

/* ===== CTA ===== */
.company-cta-card {
    background: linear-gradient(135deg, #f0fdf4, #dcfce7);
    border: 1px solid #bbf7d0;
    border-radius: 14px;
    padding: 24px;
    text-align: center;
    margin-bottom: 20px;
}

.company-cta-card p {
    font-size: 14px;
    color: #374151;
    line-height: 1.6;
    margin: 0;
}

@media (max-width: 900px) {
    .company-layout { grid-template-columns: 1fr; }
    .company-hero-inner { flex-direction: column; text-align: center; }
    .company-hero-meta { justify-content: center; }
}
</style>

@endsection
