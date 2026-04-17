@extends('layouts.master')
@section('title', 'Freelance mini task! | MyJobCV')

@section('content')
<div style="background:linear-gradient(135deg,#7c3aed,#4f46e5); padding:52px 0; margin-bottom:0;">
    <div class="container" style="text-align:center; color:#fff;">
        <h1 style="font-size:36px; font-weight:900; margin-bottom:10px;">
            💼 Freelance mini task!
        </h1>
        <p style="font-size:16px; color:rgba(255,255,255,.85); margin-bottom:28px;">
            Tìm dự án phù hợp cho bạn
        </p>
        {{-- Bộ lọc --}}
        <form action="{{ route('freelance.index') }}" method="GET"
              style="background:rgba(255,255,255,.1); backdrop-filter:blur(12px); border-radius:14px;
                     padding:20px; display:flex; flex-wrap:wrap; gap:12px; max-width:800px; margin:0 auto;">
            <input type="text" name="keyword" value="{{ request('keyword') }}"
                   placeholder="Tìm dự án..."
                   style="flex:1; min-width:200px; padding:12px 16px; border-radius:8px;
                          border:none; font-size:14px; outline:none;">
            <select name="type" style="padding:12px 16px; border-radius:8px; border:none; font-size:14px;">
                <option value="">Tất cả loại</option>
                <option value="freelance" {{ request('type')=='freelance' ? 'selected' : '' }}>Freelance</option>
                <option value="internship" {{ request('type')=='internship' ? 'selected' : '' }}>Thực tập</option>
            </select>
            <select name="work_type" style="padding:12px 16px; border-radius:8px; border:none; font-size:14px;">
                <option value="">Hình thức</option>
                <option value="online" {{ request('work_type')=='online' ? 'selected' : '' }}>Làm online</option>
                <option value="offline" {{ request('work_type')=='offline' ? 'selected' : '' }}>Trực tiếp</option>
                <option value="hybrid" {{ request('work_type')=='hybrid' ? 'selected' : '' }}>Hybrid</option>
            </select>
            <button type="submit"
                    style="background:#fff; color:#7c3aed; border:none; padding:12px 24px;
                           border-radius:8px; font-weight:700; font-size:14px; cursor:pointer;">
                🔍 Tìm kiếm
            </button>
            @if(request()->anyFilled(['keyword','type','work_type']))
                <a href="{{ route('freelance.index') }}"
                   style="color:rgba(255,255,255,.8); font-size:13px; align-self:center; text-decoration:none;">✕ Xóa lọc</a>
            @endif
        </form>
    </div>
</div>

<div class="container" style="padding-top:40px; padding-bottom:60px;">

    {{-- Stats bar --}}
    <div style="display:flex; gap:20px; margin-bottom:28px; flex-wrap:wrap;">
        <div style="background:#f5f3ff; border:1px solid #ede9fe; border-radius:10px; padding:14px 20px; flex:1; min-width:120px; text-align:center;">
            <div style="font-size:22px; font-weight:800; color:#7c3aed;">{{ $tasks->total() }}</div>
            <div style="font-size:12px; color:#6d28d9; font-weight:600;">Dự án đang mở</div>
        </div>
    </div>

    @if($tasks->count() === 0)
        <div style="text-align:center; padding:80px 20px; color:#94a3b8;">
            <div style="font-size:52px; margin-bottom:16px;">📭</div>
            <p style="font-size:16px;">Không tìm thấy dự án phù hợp.</p>
            <a href="{{ route('freelance.index') }}" style="color:#7c3aed; text-decoration:none; font-weight:600;">Xem tất cả dự án →</a>
        </div>
    @else
        <div style="display:grid; grid-template-columns:repeat(auto-fill,minmax(340px,1fr)); gap:18px;">
            @foreach($tasks as $task)
            <a href="{{ route('freelance.show', $task->slug) }}" class="fl-card">
                {{-- Header --}}
                <div class="fl-card-head">
                    <div style="display:flex; align-items:center; gap:10px;">
                        @if(optional(optional($task->employer)->company)->logo)
                            <img src="{{ asset('storage/' . $task->employer->company->logo) }}"
                                 style="width:40px; height:40px; border-radius:8px; object-fit:cover; border:1px solid #e2e8f0;">
                        @else
                            <div style="width:40px; height:40px; border-radius:8px;
                                        background:linear-gradient(135deg,#7c3aed,#4f46e5);
                                        display:flex; align-items:center; justify-content:center;
                                        color:#fff; font-weight:800; font-size:16px;">
                                {{ mb_substr(optional(optional($task->employer)->company)->name ?? $task->employer->name, 0, 1) }}
                            </div>
                        @endif
                        <div>
                            <div style="font-size:11px; color:#64748b;">
                                {{ optional(optional($task->employer)->company)->name ?? $task->employer->name }}
                            </div>
                            <div style="font-size:10px; color:#94a3b8;">
                                Đăng {{ $task->created_at->format('d/m/Y') }}
                            </div>
                        </div>
                    </div>
                    <div class="fl-type-badge {{ $task->type === 'internship' ? 'internship' : 'freelance' }}">
                        {{ $task->type === 'internship' ? '🎓 Thực tập' : '💼 Freelance' }}
                    </div>
                </div>

                {{-- Title --}}
                <h3 class="fl-card-title">{{ $task->title }}</h3>

                {{-- Info grid --}}
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:8px; margin-bottom:14px;">
                    <div class="fl-info-item">💰 {{ $task->budgetFormatted() }}</div>
                    <div class="fl-info-item">📍 {{ $task->location }}</div>
                    <div class="fl-info-item">🖥️ {{ $task->workTypeLabel() }}</div>
                    <div class="fl-info-item">💳 {{ $task->paymentTypeLabel() }}</div>
                </div>

                {{-- Footer --}}
                <div style="display:flex; justify-content:space-between; align-items:center; padding-top:12px; border-top:1px dashed #e2e8f0;">
                    <span style="font-size:12px; color:#ef4444; font-weight:600;">
                        ⏱️ {{ $task->timeRemaining() }}
                    </span>
                    <span style="font-size:12px; color:#7c3aed; font-weight:700;">
                        👥 {{ $task->applications()->where('status','accepted')->count() }}/{{ $task->max_workers }} người
                    </span>
                </div>
            </a>
            @endforeach
        </div>

        {{-- Pagination --}}
        @if($tasks->hasPages())
        <div class="pagination-v2" style="margin-top:32px;">
            @if($tasks->onFirstPage())
                <span class="pv2-btn disabled">‹</span>
            @else
                <a href="{{ $tasks->previousPageUrl() }}" class="pv2-btn">‹</a>
            @endif
            @foreach($tasks->getUrlRange(max(1,$tasks->currentPage()-2),min($tasks->lastPage(),$tasks->currentPage()+2)) as $pg => $url)
                <a href="{{ $url }}" class="pv2-btn {{ $pg==$tasks->currentPage()?'active':'' }}">{{ $pg }}</a>
            @endforeach
            @if($tasks->hasMorePages())
                <a href="{{ $tasks->nextPageUrl() }}" class="pv2-btn">›</a>
            @else
                <span class="pv2-btn disabled">›</span>
            @endif
        </div>
        @endif
    @endif
</div>

<style>
.fl-card {
    background:#fff; border-radius:14px; padding:20px;
    border:1.5px solid #e2e8f0; text-decoration:none; display:block;
    transition:all .22s;
}
.fl-card:hover {
    border-color:#7c3aed; box-shadow:0 8px 28px rgba(124,58,237,.12);
    transform:translateY(-3px);
}
.fl-card-head {
    display:flex; justify-content:space-between; align-items:flex-start;
    margin-bottom:14px;
}
.fl-card-title {
    font-size:16px; font-weight:700; color:#1e293b; line-height:1.4;
    margin-bottom:12px;
    display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden;
}
.fl-card:hover .fl-card-title { color:#7c3aed; }
.fl-type-badge {
    font-size:11px; font-weight:700; padding:4px 10px; border-radius:20px; white-space:nowrap;
}
.fl-type-badge.freelance { background:#eff6ff; color:#2563eb; }
.fl-type-badge.internship { background:#f0fdf4; color:#16a34a; }
.fl-info-item {
    font-size:12px; color:#475569; background:#f8fafc; border-radius:6px;
    padding:5px 10px; font-weight:500;
}
</style>
@endsection
