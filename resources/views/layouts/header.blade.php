<header class="main-header">
    <div class="container header-wrapper">
        <div class="header-left">
            <a href="{{ url('/') }}" class="logo" style="display: flex; align-items: center; gap: 10px; text-decoration: none;">
                <!-- Chèn ảnh Logo của bạn vào thẻ img bên dưới (ví dụ src="{{ asset('images/logo.png') }}") -->
                <img src="{{ asset('images/logo.png') }}" alt="MY-JOB-CV Logo" style="height: 60px; width: auto; object-fit: contain;" id="header-logo-image">
            </a>
        </div>

        <nav class="nav-menu">
            <a href="{{ route('jobs.list') }}">Việc làm</a>
            <a href="{{ route('freelance.index') }}" style="color:#7c3aed; font-weight:700;">Freelance</a>
            <a href="#">Hồ sơ & CV</a>
            <a href="#">Công ty</a>
            <a href="{{ url('/post') }} ">Bài viết</a>
        </nav>

        <div class="header-right">
            @auth
                <div class="user-profile" style="display: flex; align-items: center; gap: 10px;">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=00b14f&color=fff" alt="Avatar" style="width: 36px; height: 36px; border-radius: 50%;">

                    @if(Auth::user()->role == 1)
                        {{-- Admin --}}
                        <a href="{{ route('admin.dashboard') }}" style="font-weight: 600; color: var(--dark); text-decoration: none;">
                            {{ Auth::user()->name }}
                            <span style="background:#fee2e2; color:#dc2626; font-size:10px; font-weight:700; padding:2px 7px; border-radius:10px; margin-left:4px;">ADMIN</span>
                        </a>
                    @elseif(Auth::user()->role == 2)
                        {{-- Nhà tuyển dụng --}}
                        <a href="{{ route('employer.dashboard') }}" style="font-weight: 600; color: var(--dark); text-decoration: none;">
                            {{ Auth::user()->name }}
                            <span style="background:#fef9c3; color:#854d0e; font-size:10px; font-weight:700; padding:2px 7px; border-radius:10px; margin-left:4px;">NTD</span>
                        </a>
                    @else
                        <a href="{{ url('/account') }}" style="font-weight: 600; color: var(--dark); text-decoration: none;">
                            {{ Auth::user()->name }}
                            @if(Auth::user()->is_student_verified)
                                <span style="background:#dcfce7; color:#166534; font-size:10px; font-weight:700; padding:2px 7px; border-radius:10px; margin-left:4px;">SV ✓</span>
                            @endif
                        </a>
                    @endif

                    <a href="{{ route('logout') }}" class="btn btn-outline" style="padding: 6px 15px; font-size: 13px; margin-left: 10px;">
                        Đăng xuất
                    </a>
                </div>
            @else
                <a href="{{ url('/login') }}" class="btn btn-outline">Đăng nhập</a>
                <a href="{{ url('/register') }}" class="btn btn-primary">Đăng ký</a>
            @endauth
        </div>
    </div>
</header>