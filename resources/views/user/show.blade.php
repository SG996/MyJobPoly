@extends('layouts.master')

@section('title', 'Hồ sơ ứng viên | MyJobCV')

@section('content')
<div class="container" style="max-width:800px; margin:40px auto 60px;">
    
    <div style="background:#fff; border:1px solid #e2e8f0; border-radius:16px; overflow:hidden; box-shadow:0 10px 25px -5px rgba(0,0,0,0.05);">
        {{-- Header / Cover --}}
        <div style="height:120px; background:linear-gradient(135deg, #0f172a, #334155); position:relative;">
        </div>

        <div style="padding:0 30px 40px; text-align:center; position:relative; margin-top:-60px;">
            {{-- Avatar --}}
            <div style="width:120px; height:120px; border-radius:50%; border:5px solid #fff; background:#e2e8f0; overflow:hidden; display:flex; align-items:center; justify-content:center; margin:0 auto 16px; position:relative; z-index:2; box-shadow:0 4px 6px -1px rgba(0,0,0,0.1);">
                @if($user->avatar)
                    <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar" style="width:100%; height:100%; object-fit:cover;">
                @else
                    <span style="font-size:42px; font-weight:800; color:#94a3b8;">{{ mb_substr($user->name, 0, 1) }}</span>
                @endif
            </div>

            <h1 style="font-size:24px; font-weight:800; color:#1e293b; margin-bottom:4px; display:flex; align-items:center; justify-content:center; gap:8px;">
                {{ $user->name }}
                @if($user->is_student_verified)
                    <span title="Sinh viên đã xác thực" style="color:#10b981; font-size:18px;">✅</span>
                @endif
            </h1>
            
            @if($user->title)
                <div style="font-size:16px; color:#475569; font-weight:500; margin-bottom:12px;">{{ $user->title }}</div>
            @endif

            @if($user->is_student_verified)
                <div style="display:inline-flex; align-items:center; gap:6px; background:#ecfdf5; color:#059669; padding:6px 14px; border-radius:20px; font-size:13px; font-weight:700; border:1px solid #a7f3d0; margin-bottom:16px;">
                    🎓 Sinh viên đã xác thực
                </div>
            @endif

            <div style="display:flex; flex-wrap:wrap; justify-content:center; gap:20px; margin-top:16px;">
                @if($user->email)
                <div style="display:flex; align-items:center; gap:6px; font-size:14px; color:#64748b;">
                    <span>📧</span> {{ $user->email }}
                </div>
                @endif
                
                @if($user->phone)
                <div style="display:flex; align-items:center; gap:6px; font-size:14px; color:#64748b;">
                    <span>📞</span> {{ $user->phone }}
                </div>
                @endif

                @if($user->gender)
                <div style="display:flex; align-items:center; gap:6px; font-size:14px; color:#64748b;">
                    <span>👤</span> Giới tính: {{ ucfirst($user->gender) }}
                </div>
                @endif
                
                @if($user->address)
                <div style="display:flex; align-items:center; gap:6px; font-size:14px; color:#64748b;">
                    <span>📍</span> {{ $user->address }}
                </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Bio / Giới thiệu --}}
    @if($user->bio)
    <div style="background:#fff; border:1px solid #e2e8f0; border-radius:16px; padding:30px; margin-top:24px; box-shadow:0 4px 6px -1px rgba(0,0,0,0.02);">
        <h2 style="font-size:18px; font-weight:700; color:#1e293b; border-left:4px solid #3b82f6; padding-left:12px; margin-bottom:16px;">Giới thiệu bản thân</h2>
        <div style="font-size:15px; color:#475569; line-height:1.7;">
            {!! nl2br(e($user->bio)) !!}
        </div>
    </div>
    @endif

</div>
@endsection
