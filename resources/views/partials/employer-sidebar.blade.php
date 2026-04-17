<aside class="account-sidebar">
    <div class="account-user-info">
        @php $company = Auth::user()->company; @endphp

        @if($company && $company->logo)
            <div style="width:72px; height:72px; border-radius:12px; margin:0 auto 12px; border:3px solid #e0f2f1; overflow:hidden; background:#f1f5f9;">
                <img src="{{ asset('storage/' . $company->logo) }}" alt="Logo"
                     style="width:100%; height:100%; object-fit:cover;">
            </div>
        @else
            <div style="width:72px; height:72px; border-radius:12px; background:linear-gradient(135deg,#00b14f,#005a28); display:flex; align-items:center; justify-content:center; font-size:32px; margin:0 auto 12px; border:3px solid #e0f2f1;">
                🏢
            </div>
        @endif

        <div class="account-user-name" style="font-size:15px; font-weight:700; color:#1e293b; margin-bottom:4px; text-align:center; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">
            {{ $company->name ?? Auth::user()->name }}
        </div>
        <div class="account-user-email" style="font-size:12px; color:#64748b; text-align:center; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">
            {{ Auth::user()->email }}
        </div>

        @if($company && $company->tax_code)
            <div style="margin-top:6px; text-align:center;">
                <span style="background:#f0fdf4; color:#16a34a; font-size:11px; font-weight:600; padding:3px 10px; border-radius:20px; border:1px solid #bbf7d0;">
                    🏷️ MST: {{ $company->tax_code }}
                </span>
            </div>
        @endif

        <div style="margin-top:10px; text-align:center;">
            <span style="background:#fef9c3; color:#854d0e; font-size:11px; font-weight:700; padding:3px 10px; border-radius:20px; border:1px solid #fde68a;">
                💼 Nhà tuyển dụng
            </span>
        </div>
    </div>

    <nav class="account-nav">
        <a href="{{ route('employer.dashboard') }}"
           class="{{ ($active ?? '') == 'dashboard' ? 'active' : '' }}">
            <span class="account-nav-icon">📊</span> Tổng quan
        </a>

        <a href="{{ route('employer.jobs.create') }}"
           class="{{ ($active ?? '') == 'post-job' ? 'active' : '' }}">
            <span class="account-nav-icon">✏️</span> Đăng tin tuyển dụng
        </a>

        <a href="{{ route('employer.jobs.index') }}"
           class="{{ ($active ?? '') == 'my-jobs' ? 'active' : '' }}">
            <span class="account-nav-icon">📋</span> Quản lý bài đăng
        </a>

        <a href="{{ route('employer.applications') }}"
           class="{{ ($active ?? '') == 'applications' ? 'active' : '' }}">
            <span class="account-nav-icon">📥</span> Xem CV & Duyệt hồ sơ
        </a>

        <a href="{{ route('employer.profile') }}"
           class="{{ ($active ?? '') == 'profile' ? 'active' : '' }}">
            <span class="account-nav-icon">🏢</span> Thông tin công ty
        </a>

        {{-- Freelance Section --}}
        <div style="font-size:10px; font-weight:800; color:#94a3b8; text-transform:uppercase; letter-spacing:.8px; padding:12px 0 6px; margin-top:4px; border-top:1px solid #e2e8f0;">
            Freelance
        </div>
        <a href="{{ route('employer.mini-tasks.index') }}"
           class="{{ ($active ?? '') == 'mini-tasks' || request()->routeIs('employer.mini-tasks.*') ? 'active' : '' }}"
           style="{{ request()->routeIs('employer.mini-tasks.*') ? 'background:#f5f3ff; color:#7c3aed; border-left:3px solid #7c3aed;' : '' }}">
            <span class="account-nav-icon">💼</span> Mini Tasks của tôi
            @php $myTaskCount = \App\Models\MiniTask::where('employer_id', Auth::id())->where('status','open')->count(); @endphp
            @if($myTaskCount > 0)
                <span style="background:#7c3aed; color:#fff; font-size:9px; font-weight:800; padding:1px 6px; border-radius:10px; margin-left:auto;">{{ $myTaskCount }}</span>
            @endif
        </a>
        <a href="{{ route('employer.mini-tasks.create') }}"
           style="font-size:13px; padding-left:32px !important;">
            <span class="account-nav-icon">➕</span> Đăng dự án mới
        </a>

        <a href="{{ route('logout') }}" style="color:#dc3545; margin-top:20px;">
            <span class="account-nav-icon">🚪</span> Đăng xuất
        </a>
    </nav>
</aside>
