<aside class="account-sidebar">
    <div class="account-user-info">
        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=00b14f&color=fff&size=150" alt="Avatar" class="account-user-avatar" style="width: 80px; height: 80px; border-radius: 50%; border: 3px solid #e0f2f1; margin-bottom: 15px; object-fit: cover;">
        <div class="account-user-name" style="font-size: 16px; font-weight: 700; color: #333; margin-bottom: 5px;">{{ Auth::user()->name }}</div>
        <div class="account-user-email" style="font-size: 13px; color: #7f878f;">{{ Auth::user()->email }}</div>

        {{-- Trạng thái xác thực SV --}}
        @if(Auth::user()->is_student_verified)
            <div style="margin-top:8px;">
                <span style="background:#dcfce7; color:#166534; font-size:11px; font-weight:700; padding:3px 12px; border-radius:20px; border:1px solid #86efac;">
                    🎓 Sinh viên đã xác thực
                </span>
            </div>
        @else
            <div style="margin-top:8px;">
                <a href="{{ route('account.verify_student') }}"
                   style="background:#fef3c7; color:#92400e; font-size:11px; font-weight:700; padding:3px 12px; border-radius:20px; border:1px solid #fde68a; text-decoration:none; display:inline-block;">
                    ⚠️ Chưa xác thực SV
                </a>
            </div>
        @endif
    </div>

    <nav class="account-nav">
        <a href="{{ url('/account') }}" class="{{ request()->is('account') || ($active ?? '') == 'profile' ? 'active' : '' }}">
            <span class="account-nav-icon">👤</span> Thông tin cá nhân
        </a>
        <a href="{{ route('account.applied_jobs') }}" class="{{ request()->routeIs('account.applied_jobs') || ($active ?? '') == 'applied_jobs' ? 'active' : '' }}">
            <span class="account-nav-icon">💼</span> Việc làm đã ứng tuyển
        </a>
        <a href="{{ route('account.saved_jobs') }}" class="{{ request()->routeIs('account.saved_jobs') || ($active ?? '') == 'saved_jobs' ? 'active' : '' }}">
            <span class="account-nav-icon">❤️</span> Việc làm đã lưu
        </a>

        {{-- Freelance --}}
        <div style="font-size:10px; font-weight:800; color:#94a3b8; text-transform:uppercase; letter-spacing:.8px; padding:12px 0 6px; margin-top:4px; border-top:1px solid #e2e8f0;">
            Freelance
        </div>
        <a href="{{ route('account.freelance') }}" class="{{ request()->routeIs('account.freelance') ? 'active' : '' }}">
            <span class="account-nav-icon">💼</span> Dự án của tôi
        </a>
        <a href="{{ route('account.verify_student') }}" class="{{ request()->routeIs('account.verify_student') ? 'active' : '' }}"
           style="{{ Auth::user()->is_student_verified ? '' : 'position:relative;' }}">
            <span class="account-nav-icon">🎓</span> Xác thực sinh viên
            @if(!Auth::user()->is_student_verified)
                <span style="background:#ef4444; color:#fff; font-size:9px; font-weight:800; padding:1px 5px; border-radius:8px; margin-left:auto;">!</span>
            @endif
        </a>

        <a href="{{ route('logout') }}" style="color: #dc3545; margin-top: 20px;">
            <span class="account-nav-icon">🚪</span> Đăng xuất
        </a>
    </nav>
</aside>
