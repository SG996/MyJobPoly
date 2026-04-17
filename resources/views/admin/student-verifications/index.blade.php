@extends('admin.layouts.app')
@section('title', 'Duyệt xác thực sinh viên')

@section('content')
<div style="margin-bottom:24px;">
    <h1 style="font-size:22px; font-weight:800; color:#1e293b;">🎓 Xác thực sinh viên</h1>
    <p style="color:#64748b; font-size:14px;">Duyệt hoặc từ chối yêu cầu xác thực sinh viên</p>
</div>

{{-- Stats --}}
<div style="display:grid; grid-template-columns:repeat(3,1fr); gap:16px; margin-bottom:24px;">
    <div class="content-block" style="text-align:center; padding:20px; border-top:3px solid #f59e0b;">
        <div style="font-size:26px; font-weight:800; color:#f59e0b;">{{ $stats['pending'] }}</div>
        <div style="font-size:13px; color:#64748b;">Chờ duyệt</div>
    </div>
    <div class="content-block" style="text-align:center; padding:20px; border-top:3px solid #16a34a;">
        <div style="font-size:26px; font-weight:800; color:#16a34a;">{{ $stats['approved'] }}</div>
        <div style="font-size:13px; color:#64748b;">Đã duyệt</div>
    </div>
    <div class="content-block" style="text-align:center; padding:20px; border-top:3px solid #dc2626;">
        <div style="font-size:26px; font-weight:800; color:#dc2626;">{{ $stats['rejected'] }}</div>
        <div style="font-size:13px; color:#64748b;">Đã từ chối</div>
    </div>
</div>

{{-- Filter --}}
<div style="margin-bottom:16px; display:flex; gap:8px; flex-wrap:wrap;">
    @foreach([''=>'Tất cả','pending'=>'⏳ Chờ duyệt','approved'=>'✅ Đã duyệt','rejected'=>'❌ Từ chối'] as $val => $lbl)
    <a href="{{ route('admin.student-verifications.index', ['status'=>$val]) }}"
       style="padding:7px 16px; border-radius:20px; font-size:13px; font-weight:600; text-decoration:none;
              background:{{ request('status')==$val ? '#1e293b' : '#f1f5f9' }};
              color:{{ request('status')==$val ? '#fff' : '#475569' }};">
        {{ $lbl }}
    </a>
    @endforeach
</div>

@if(session('success'))
    <div style="background:#f0fdf4; border:1px solid #bbf7d0; border-radius:8px; padding:12px 16px; margin-bottom:16px; color:#166534; font-size:14px; font-weight:600;">✅ {{ session('success') }}</div>
@endif

<div style="display:grid; gap:16px;">
    @forelse($verifications as $v)
    <div class="content-block" style="padding:20px;">
        <div style="display:flex; gap:20px; align-items:flex-start; flex-wrap:wrap;">

            {{-- Ảnh thẻ SV --}}
            <a href="{{ asset('storage/' . $v->card_image) }}" target="_blank"
               style="flex-shrink:0; display:block; width:120px; height:80px; border-radius:8px; overflow:hidden; border:2px solid #e2e8f0;">
                <img src="{{ asset('storage/' . $v->card_image) }}" alt="Thẻ SV"
                     style="width:100%; height:100%; object-fit:cover;">
            </a>

            {{-- Thông tin --}}
            <div style="flex:1; min-width:220px;">
                <div style="display:flex; align-items:center; gap:10px; margin-bottom:8px;">
                    <span style="font-size:15px; font-weight:700; color:#1e293b;">{{ $v->user->name }}</span>
                    @php
                        $badge = ['pending'=>['#f59e0b','#fffbeb','⏳ Chờ duyệt'],'approved'=>['#16a34a','#f0fdf4','✅ Đã duyệt'],'rejected'=>['#dc2626','#fef2f2','❌ Từ chối']][$v->status];
                    @endphp
                    <span style="background:{{ $badge[1] }}; color:{{ $badge[0] }}; padding:3px 10px; border-radius:20px; font-size:11px; font-weight:700;">{{ $badge[2] }}</span>
                </div>
                <div style="font-size:13px; color:#475569; margin-bottom:4px;">📧 {{ $v->user->email }}</div>
                <div style="font-size:13px; color:#475569; margin-bottom:4px;">🆔 Mã SV: <strong>{{ $v->student_id }}</strong></div>
                <div style="font-size:13px; color:#475569; margin-bottom:4px;">🏫 Trường: <strong>{{ $v->school_name }}</strong></div>
                <div style="font-size:11px; color:#94a3b8;">Gửi {{ $v->created_at->format('d/m/Y H:i') }}</div>
                @if($v->admin_note)
                    <div style="font-size:12px; color:#dc2626; margin-top:6px; background:#fef2f2; padding:6px 10px; border-radius:6px;">Lý do từ chối: {{ $v->admin_note }}</div>
                @endif
            </div>

            {{-- Actions --}}
            @if($v->isPending())
            <div style="min-width:200px; display:flex; flex-direction:column; gap:8px;">
                <form action="{{ route('admin.student-verifications.approve', $v->id) }}" method="POST">
                    @csrf
                    <button type="submit"
                            style="width:100%; background:#16a34a; color:#fff; border:none; padding:10px; border-radius:8px; font-weight:700; font-size:13px; cursor:pointer;">
                        ✅ Duyệt xác thực
                    </button>
                </form>
                <form action="{{ route('admin.student-verifications.reject', $v->id) }}" method="POST">
                    @csrf
                    <textarea name="admin_note" rows="2" required
                              placeholder="Lý do từ chối..."
                              style="width:100%; padding:8px; border:1.5px solid #e2e8f0; border-radius:6px; font-size:12px; resize:none; margin-bottom:6px;"></textarea>
                    <button type="submit"
                            style="width:100%; background:#dc2626; color:#fff; border:none; padding:10px; border-radius:8px; font-weight:700; font-size:13px; cursor:pointer;">
                        ❌ Từ chối
                    </button>
                </form>
            </div>
            @endif
        </div>
    </div>
    @empty
    <div class="content-block" style="text-align:center; padding:60px; color:#94a3b8;">
        <div style="font-size:40px; margin-bottom:12px;">📭</div>
        <p>Không có yêu cầu nào {{ request('status') ? 'với trạng thái này' : '' }}.</p>
    </div>
    @endforelse
</div>

<div style="margin-top:20px;">{{ $verifications->links() }}</div>
@endsection
