@extends('layouts.master')
@section('title', 'Mini Tasks của tôi | MyJobCV')

@section('content')
<div class="container" style="margin-top:32px; margin-bottom:60px;">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px;">
        <h1 style="font-size:22px; font-weight:800; color:#1e293b;">💼 Dự án Freelance của tôi</h1>
        <a href="{{ route('freelance.index') }}"
           style="background:#7c3aed; color:#fff; padding:10px 20px; border-radius:8px; font-size:13px; font-weight:700; text-decoration:none;">
            + Tìm dự án mới
        </a>
    </div>

    @if(session('success'))
        <div style="background:#f0fdf4; border:1px solid #bbf7d0; border-radius:8px; padding:14px; margin-bottom:16px; color:#166534; font-size:14px; font-weight:600;">✅ {{ session('success') }}</div>
    @endif

    @if($applications->count() === 0)
        <div class="content-block" style="text-align:center; padding:60px;">
            <div style="font-size:48px; margin-bottom:16px;">📭</div>
            <p style="color:#64748b; font-size:15px; margin-bottom:16px;">Bạn chưa ứng tuyển dự án nào.</p>
            <a href="{{ route('freelance.index') }}"
               style="background:#7c3aed; color:#fff; padding:12px 24px; border-radius:8px; font-size:14px; font-weight:700; text-decoration:none;">
                Khám phá dự án freelance →
            </a>
        </div>
    @else
        <div style="display:grid; gap:14px;">
            @foreach($applications as $app)
            <div class="content-block" style="padding:20px;">
                <div style="display:flex; align-items:flex-start; gap:14px;">
                    <div style="flex:1;">
                        <div style="display:flex; align-items:center; gap:10px; margin-bottom:8px;">
                            <a href="{{ route('freelance.show', $app->miniTask->slug) }}"
                               style="font-size:16px; font-weight:700; color:#1e293b; text-decoration:none;">
                                {{ $app->miniTask->title }}
                            </a>
                            <span class="status-badge-{{ $app->statusColor() }}">{{ $app->statusLabel() }}</span>
                        </div>
                        <div style="font-size:13px; color:#64748b; margin-bottom:10px;">
                            💰 {{ $app->miniTask->budgetFormatted() }} •
                            Ứng tuyển {{ $app->created_at->format('d/m/Y') }} •
                            ID #{{ $app->miniTask->id }}
                        </div>

                        {{-- CV đính kèm --}}
                        @if($app->cv_file)
                            @php $ext = pathinfo($app->cv_file, PATHINFO_EXTENSION); @endphp
                            <div style="margin-bottom:8px;">
                                <a href="{{ asset('storage/' . $app->cv_file) }}" target="_blank"
                                   style="display:inline-flex; align-items:center; gap:5px; font-size:12px; color:#7c3aed; font-weight:600; text-decoration:none; background:#f5f3ff; padding:4px 10px; border-radius:6px;">
                                    📎 CV đã nộp @if(strtolower($ext)=='pdf')(PDF)@elseif(in_array(strtolower($ext),['doc','docx']))(Word)@else(Ảnh)@endif
                                </a>
                            </div>
                        @endif

                        {{-- Progress bar --}}
                        @if($app->status === 'accepted' || $app->status === 'completed')
                        <div style="margin-bottom:14px;">
                            <div style="display:flex; justify-content:space-between; font-size:12px; font-weight:600; color:#475569; margin-bottom:4px;">
                                <span>Tiến độ</span>
                                <span>{{ $app->progress_percentage }}%</span>
                            </div>
                            <div style="background:#e2e8f0; border-radius:999px; height:8px;">
                                <div style="background:linear-gradient(90deg,#7c3aed,#4f46e5); height:8px; border-radius:999px; width:{{ $app->progress_percentage }}%; transition:width .4s;"></div>
                            </div>
                        </div>
                        @endif

                        {{-- Payment info if completed --}}
                        @if($app->payment_proof)
                        <div style="background:#f0fdf4; border:1px solid #bbf7d0; border-radius:8px; padding:12px; display:inline-flex; gap:12px; align-items:center;">
                            <span style="font-size:13px; color:#166534; font-weight:600;">✅ Đã thanh toán {{ number_format($app->payment_amount) }}đ</span>
                            <a href="{{ asset('storage/' . $app->payment_proof) }}" target="_blank"
                               style="font-size:12px; color:#16a34a; font-weight:600; text-decoration:none;">Xem bill →</a>
                        </div>
                        @endif
                    </div>

                    {{-- Update progress form (chỉ khi accepted) --}}
                    @if($app->status === 'accepted')
                    <div style="min-width:220px; border-left:1px solid #e2e8f0; padding-left:16px;">
                        <form action="{{ route('freelance.progress', $app->id) }}" method="POST">
                            @csrf
                            <label style="font-size:12px; font-weight:700; color:#475569; display:block; margin-bottom:6px;">Cập nhật tiến độ</label>
                            <div style="display:flex; gap:8px; align-items:center; margin-bottom:8px;">
                                <input type="number" name="progress_percentage" min="0" max="100"
                                       value="{{ $app->progress_percentage }}"
                                       style="width:70px; padding:8px; border:1.5px solid #e2e8f0; border-radius:6px; font-size:13px; font-weight:600;">
                                <span style="font-size:13px; color:#64748b;">%</span>
                            </div>
                            <textarea name="progress_notes" rows="2" placeholder="Ghi chú..."
                                      style="width:100%; padding:8px; border:1.5px solid #e2e8f0; border-radius:6px; font-size:12px; resize:none; margin-bottom:8px;">{{ $app->progress_notes }}</textarea>
                            <button type="submit"
                                    style="width:100%; background:#7c3aed; color:#fff; border:none; padding:8px; border-radius:6px; font-size:12px; font-weight:700; cursor:pointer;">
                                Lưu tiến độ
                            </button>
                        </form>
                    </div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    @endif
</div>

<style>
.status-badge-warning { background:#fef3c7; color:#92400e; padding:3px 10px; border-radius:20px; font-size:11px; font-weight:700; }
.status-badge-info { background:#dbeafe; color:#1e40af; padding:3px 10px; border-radius:20px; font-size:11px; font-weight:700; }
.status-badge-success { background:#dcfce7; color:#166534; padding:3px 10px; border-radius:20px; font-size:11px; font-weight:700; }
.status-badge-danger { background:#fee2e2; color:#991b1b; padding:3px 10px; border-radius:20px; font-size:11px; font-weight:700; }
.status-badge-secondary { background:#f1f5f9; color:#475569; padding:3px 10px; border-radius:20px; font-size:11px; font-weight:700; }
</style>
@endsection
