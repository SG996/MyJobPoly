@extends('admin.layouts.app')

@section('title', 'Quản lý Người dùng')
@section('page-title', '👥 Quản lý Người dùng')
@section('page-subtitle', 'Danh sách tài khoản trên hệ thống')

@section('content')

<div class="breadcrumb">
    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
    <span class="breadcrumb-sep">/</span>
    <span>Người dùng</span>
</div>

@if(session('success'))
    <div style="background:#d1fae5;color:#065f46;padding:12px 18px;border-radius:8px;margin-bottom:16px;font-weight:500;">
        ✅ {{ session('success') }}
    </div>
@endif
@if(session('error'))
    <div style="background:#fee2e2;color:#991b1b;padding:12px 18px;border-radius:8px;margin-bottom:16px;font-weight:500;">
        ❌ {{ session('error') }}
    </div>
@endif

{{-- Filter Tabs --}}
<div style="display:flex;gap:10px;margin-bottom:20px;flex-wrap:wrap;">
    @php
        $tabs = [
            'all'      => ['label' => 'Tất cả',       'count' => $countAll,      'color' => '#6366f1'],
            'pending'  => ['label' => '⏳ Chờ duyệt', 'count' => $countPending,  'color' => '#ea580c'],
            'approved' => ['label' => '✅ Đã duyệt',  'count' => $countApproved, 'color' => '#16a34a'],
            'locked'   => ['label' => '🔒 Đã khóa',  'count' => $countLocked,   'color' => '#dc2626'],
        ];
    @endphp
    @foreach($tabs as $key => $tab)
        <a href="{{ route('admin.users.index', ['filter' => $key]) }}"
           style="display:inline-flex;align-items:center;gap:8px;padding:9px 18px;border-radius:8px;font-weight:600;font-size:14px;text-decoration:none;border:2px solid {{ $filter === $key ? $tab['color'] : 'var(--border)' }};background:{{ $filter === $key ? $tab['color'] : 'var(--card-bg)' }};color:{{ $filter === $key ? '#fff' : 'var(--text-secondary)' }};transition:all 0.2s;">
            {{ $tab['label'] }}
            <span style="background:{{ $filter === $key ? 'rgba(255,255,255,0.25)' : 'var(--body-bg)' }};padding:2px 8px;border-radius:20px;font-size:12px;">{{ $tab['count'] }}</span>
        </a>
    @endforeach
</div>

<div class="card">
    <div class="card-header">
        <div class="card-title">
            @if($filter === 'pending') ⏳ Tài khoản chờ duyệt
            @elseif($filter === 'approved') ✅ Tài khoản đã duyệt
            @elseif($filter === 'locked') 🔒 Tài khoản đã khóa
            @else 👥 Tất cả người dùng
            @endif
            ({{ $users->total() }})
        </div>
    </div>
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Tên / Email</th>
                    <th>Vai trò</th>
                    <th>Trạng thái</th>
                    <th>Ngày đăng ký</th>
                    <th style="text-align:right;">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td style="color:var(--text-secondary);font-size:12px;">{{ $user->id }}</td>
                    <td>
                        <div style="display:flex;align-items:center;gap:10px;">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=6366f1&color=fff&size=32"
                                 style="width:36px;height:36px;border-radius:50%;flex-shrink:0;" alt="">
                            <div>
                                <span style="font-weight:600;display:block;color:var(--text-primary);">{{ $user->name }}</span>
                                <span style="font-size:12px;color:var(--text-secondary);">{{ $user->email }}</span>
                            </div>
                        </div>
                    </td>
                    <td>
                        @if($user->role == 1)
                            <span style="background:#fefce8;color:#a16207;padding:4px 10px;border-radius:20px;font-size:12px;font-weight:600;">👑 Admin</span>
                        @elseif($user->role == 2)
                            <span style="background:#e0e7ff;color:#4338ca;padding:4px 10px;border-radius:20px;font-size:12px;font-weight:600;">🏢 Doanh nghiệp</span>
                        @else
                            <span style="background:#f1f5f9;color:#475569;padding:4px 10px;border-radius:20px;font-size:12px;font-weight:600;">👤 Ứng viên</span>
                        @endif
                    </td>
                    <td>
                        @if($user->role == 1)
                            <span style="color:#6366f1;font-weight:600;font-size:13px;">— Hệ thống</span>
                        @elseif($user->is_approved)
                            <span style="color:#16a34a;font-weight:600;font-size:13px;">✅ Đã duyệt</span>
                        @elseif($user->role == 2)
                            <span style="color:#ea580c;font-weight:600;font-size:13px;">⏳ Chờ duyệt</span>
                        @else
                            <span style="color:#dc2626;font-weight:600;font-size:13px;">🔒 Đã khóa</span>
                        @endif
                    </td>
                    <td style="color:var(--text-secondary);font-size:12px;">{{ $user->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        <div style="display:flex;justify-content:flex-end;gap:8px;">
                            {{-- Chỉ hiện nút nếu không phải Admin --}}
                            @if($user->role != 1)
                                <form action="{{ route('admin.users.toggle_approve', $user->id) }}" method="POST">
                                    @csrf
                                    @if($user->is_approved)
                                        <button type="submit" class="btn btn-sm"
                                            style="background:#fef2f2;color:#dc2626;border:1px solid #fecaca;font-weight:600;"
                                            onclick="return confirm('Khóa tài khoản {{ addslashes($user->name) }}?')">
                                            🔒 Khóa
                                        </button>
                                    @else
                                        <button type="submit" class="btn btn-sm"
                                            style="background:#f0fdf4;color:#16a34a;border:1px solid #bbf7d0;font-weight:600;">
                                            ✅ Duyệt
                                        </button>
                                    @endif
                                </form>
                            @else
                                <span style="color:var(--text-secondary);font-size:12px;padding:8px;">—</span>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align:center;padding:50px;color:var(--text-secondary);">
                        <div style="font-size:40px;margin-bottom:12px;">🔍</div>
                        Không có tài khoản nào trong nhóm này.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($users->hasPages())
    <div class="card-body" style="border-top:1px solid var(--border);">
        <div class="pagination">
            @if($users->onFirstPage())
                <span class="page-link" style="opacity:.4;">‹</span>
            @else
                <a href="{{ $users->previousPageUrl() }}" class="page-link">‹</a>
            @endif
            @foreach($users->getUrlRange(max(1,$users->currentPage()-2), min($users->lastPage(),$users->currentPage()+2)) as $page => $url)
                <a href="{{ $url }}" class="page-link {{ $page == $users->currentPage() ? 'active' : '' }}">{{ $page }}</a>
            @endforeach
            @if($users->hasMorePages())
                <a href="{{ $users->nextPageUrl() }}" class="page-link">›</a>
            @else
                <span class="page-link" style="opacity:.4;">›</span>
            @endif
        </div>
    </div>
    @endif
</div>

@endsection
