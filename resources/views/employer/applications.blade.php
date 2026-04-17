@extends('layouts.master')

@section('title', 'Xem và duyệt CV | MyJobCV')

@section('content')
<div class="container account-grid">

    @include('partials.employer-sidebar', ['active' => 'applications'])

    <main class="account-content">
        <h1 class="account-content-title">📥 Đơn ứng tuyển</h1>
        <p class="account-content-subtitle">Xem và duyệt hồ sơ ứng tuyển từ các ứng viên</p>

        {{-- Thông báo --}}
        @if(session('success'))
            <div style="background:#d1fae5; border:1px solid #6ee7b7; color:#065f46; padding:12px 16px; border-radius:8px; margin-bottom:20px; font-weight:500;">
                {{ session('success') }}
            </div>
        @endif

        {{-- BỘ LỌC THEO JOB --}}
        <div style="background:#fff; border:1px solid #e2e8f0; border-radius:12px; padding:16px 20px; margin-bottom:24px; display:flex; align-items:center; gap:14px; flex-wrap:wrap;">
            <label style="font-weight:600; color:#374151; font-size:14px;">Lọc theo bài đăng:</label>
            <form method="GET" action="{{ route('employer.applications') }}" style="display:flex; align-items:center; gap:10px; flex:1; flex-wrap:wrap;">
                <select name="job_id" class="form-control" style="max-width:380px; padding:8px 12px;">
                    <option value="">-- Tất cả bài đăng --</option>
                    @foreach($myJobs as $job)
                        <option value="{{ $job->id }}" {{ $jobId == $job->id ? 'selected' : '' }}>
                            {{ $job->title }}
                        </option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-outline" style="padding:8px 20px;">Lọc</button>
                @if($jobId)
                    <a href="{{ route('employer.applications') }}" style="font-size:13px; color:#64748b;">Xóa bộ lọc ✕</a>
                @endif
            </form>
        </div>

        {{-- DANH SÁCH CÁC ĐƠN ỨNG TUYỂN --}}
        @if($applications->count() > 0)
            <div style="display:flex; flex-direction:column; gap:14px;">
                @foreach($applications as $app)
                @php
                    $statusCfg = match($app->status) {
                        'approved' => ['bg'=>'#d1fae5','color'=>'#065f46','label'=>'✅ Đã duyệt'],
                        'rejected' => ['bg'=>'#fee2e2','color'=>'#991b1b','label'=>'❌ Từ chối'],
                        default    => ['bg'=>'#fef9c3','color'=>'#854d0e','label'=>'⏳ Chờ duyệt'],
                    };
                @endphp
                <div style="background:#fff; border:1px solid #e2e8f0; border-radius:12px; padding:20px; transition:box-shadow .2s;"
                     onmouseover="this.style.boxShadow='0 4px 15px rgba(0,0,0,0.08)'"
                     onmouseout="this.style.boxShadow='none'">

                    <div style="display:flex; justify-content:space-between; align-items:flex-start; gap:16px; flex-wrap:wrap;">

                        {{-- THÔNG TIN ỨNG VIÊN --}}
                        <div style="flex:1; min-width:0;">
                            <div style="display:flex; align-items:center; gap:12px; margin-bottom:8px;">
                                <a href="{{ route('user.show', $app->user->id ?? 0) }}" target="_blank" style="display:block; text-decoration:none;">
                                    @if(isset($app->user) && $app->user->avatar)
                                        <img src="{{ asset('storage/'.$app->user->avatar) }}" alt="Avatar" style="width:48px; height:48px; border-radius:50%; object-fit:cover; border:2px solid #e0f2f1;">
                                    @else
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($app->user->name ?? 'U') }}&background=00b14f&color=fff&size=80"
                                             alt="Avatar"
                                             style="width:48px; height:48px; border-radius:50%; border:2px solid #e0f2f1;">
                                    @endif
                                </a>
                                <div>
                                    <div style="font-weight:700; font-size:16px; color:#1e293b;">
                                        <a href="{{ route('user.show', $app->user->id ?? 0) }}" target="_blank" style="color:inherit; text-decoration:none;">{{ $app->user->name ?? 'Ứng viên' }}</a>
                                    </div>
                                    <div style="font-size:13px; color:#64748b;">
                                        {{ $app->user->email ?? '' }}
                                    </div>
                                </div>
                            </div>

                            <div style="display:flex; gap:16px; flex-wrap:wrap; font-size:13px; color:#64748b;">
                                <span>💼 <strong style="color:#374151;">{{ $app->job->title ?? 'N/A' }}</strong></span>
                                <span>🕐 {{ $app->created_at->format('d/m/Y H:i') }}</span>
                            </div>

                            @if($app->cover_letter)
                                <div style="margin-top:10px; background:#f8fafc; border-left:3px solid #00b14f; padding:10px 14px; border-radius:0 8px 8px 0; font-size:13px; color:#374151; line-height:1.6;">
                                    <strong style="font-size:12px; text-transform:uppercase; color:#94a3b8; display:block; margin-bottom:4px;">Thư giới thiệu</strong>
                                    {{ Str::limit($app->cover_letter, 200) }}
                                </div>
                            @endif

                            {{-- AI Summary Box --}}
                            @if($app->ai_summary)
                                <div style="margin-top:10px; background:linear-gradient(135deg,#f0f9ff,#e0f2fe); border:1px solid #bae6fd; border-radius:10px; padding:12px 14px;">
                                    <div style="display:flex; align-items:center; gap:6px; margin-bottom:7px;">
                                        <span style="font-size:15px;">🤖</span>
                                        <strong style="font-size:11px; text-transform:uppercase; letter-spacing:.5px; color:#0369a1;">Phân tích AI</strong>
                                    </div>
                                    <div style="font-size:13px; color:#0c4a6e; line-height:1.65; white-space:pre-line;">{{ $app->ai_summary }}</div>
                                </div>
                            @endif
                        </div>

                        {{-- ACTIONS --}}
                        <div style="display:flex; flex-direction:column; align-items:flex-end; gap:10px; min-width:160px;">
                            {{-- Badge trạng thái --}}
                            <span style="padding:6px 14px; border-radius:20px; font-size:12px; font-weight:700; background:{{ $statusCfg['bg'] }}; color:{{ $statusCfg['color'] }};">
                                {{ $statusCfg['label'] }}
                            </span>

                            {{-- Xem CV --}}
                            @if($app->cv_path)
                                <a href="{{ asset('storage/' . $app->cv_path) }}"
                                   target="_blank"
                                   style="display:inline-flex; align-items:center; gap:6px; background:#eff6ff; color:#2563eb; padding:8px 14px; border-radius:8px; font-size:13px; font-weight:600; text-decoration:none; border:1px solid #bfdbfe;">
                                    📄 Xem CV/Hồ sơ
                                </a>
                            @endif

                            {{-- Duyệt / Từ chối --}}
                            @if($app->status === 'pending')
                                <div style="display:flex; gap:8px;">
                                    <form action="{{ route('employer.applications.status', $app->id) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="status" value="approved">
                                        <button type="submit"
                                                style="background:#00b14f; color:#fff; border:none; padding:8px 14px; border-radius:8px; font-size:13px; font-weight:600; cursor:pointer; transition:all .2s;"
                                                onmouseover="this.style.background='#007a36'"
                                                onmouseout="this.style.background='#00b14f'">
                                            ✅ Duyệt
                                        </button>
                                    </form>
                                    <form action="{{ route('employer.applications.status', $app->id) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="status" value="rejected">
                                        <button type="submit"
                                                onclick="return confirm('Bạn chắc chắn muốn từ chối đơn này?')"
                                                style="background:#fee2e2; color:#dc2626; border:1px solid #fca5a5; padding:8px 14px; border-radius:8px; font-size:13px; font-weight:600; cursor:pointer;">
                                            ❌ Từ chối
                                        </button>
                                    </form>
                                </div>
                            @else
                                {{-- Đặt lại --}}
                                <form action="{{ route('employer.applications.status', $app->id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="status" value="pending">
                                    <button type="submit"
                                            style="background:#f1f5f9; color:#64748b; border:1px solid #e2e8f0; padding:6px 12px; border-radius:8px; font-size:12px; font-weight:500; cursor:pointer;">
                                        🔄 Đặt lại chờ duyệt
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div style="margin-top:24px;">
                {{ $applications->appends(request()->query())->links() }}
            </div>
        @else
            <div style="text-align:center; padding:60px 20px; background:#f8fafc; border-radius:12px; border:2px dashed #e2e8f0;">
                <div style="font-size:56px; margin-bottom:16px;">📥</div>
                <h3 style="color:#1e293b; margin-bottom:8px;">Chưa có đơn ứng tuyển nào</h3>
                <p style="color:#94a3b8;">
                    @if($jobId)
                        Tin tuyển dụng này chưa có ứng viên nào nộp hồ sơ.
                    @else
                        Chưa có ứng viên nào ứng tuyển vào các vị trí của bạn.
                    @endif
                </p>
            </div>
        @endif

    </main>
</div>
@endsection
