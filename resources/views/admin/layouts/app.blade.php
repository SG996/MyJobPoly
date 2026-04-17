<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel') | MY-JOB-CV</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --primary: #6366f1;
            --primary-dark: #4f46e5;
            --primary-light: #e0e7ff;
            --success: #10b981;
            --danger: #ef4444;
            --warning: #f59e0b;
            --info: #3b82f6;
            --dark: #0f172a;
            --sidebar-bg: #0f172a;
            --sidebar-hover: #1e293b;
            --sidebar-active: #6366f1;
            --sidebar-text: #94a3b8;
            --sidebar-text-active: #ffffff;
            --body-bg: #f1f5f9;
            --card-bg: #ffffff;
            --border: #e2e8f0;
            --text-primary: #1e293b;
            --text-secondary: #64748b;
            --sidebar-width: 260px;
            --header-height: 64px;
            --radius: 12px;
            --shadow: 0 1px 3px rgba(0,0,0,.08), 0 1px 2px rgba(0,0,0,.06);
            --shadow-md: 0 4px 6px -1px rgba(0,0,0,.1), 0 2px 4px -1px rgba(0,0,0,.06);
            --transition: all .2s ease;
        }

        body { font-family: 'Inter', sans-serif; background: var(--body-bg); color: var(--text-primary); display: flex; min-height: 100vh; }

        /* ===== SIDEBAR ===== */
        .sidebar {
            width: var(--sidebar-width);
            background: var(--sidebar-bg);
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0; left: 0; bottom: 0;
            z-index: 100;
            transition: var(--transition);
            overflow: hidden;
        }

        .sidebar-logo {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 20px 24px;
            border-bottom: 1px solid rgba(255,255,255,.06);
            text-decoration: none;
        }

        .sidebar-logo-icon {
            width: 36px; height: 36px;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 18px;
            flex-shrink: 0;
        }

        .sidebar-logo-text { color: #fff; font-weight: 700; font-size: 15px; line-height: 1.2; }
        .sidebar-logo-text span { display: block; color: var(--sidebar-text); font-weight: 400; font-size: 11px; }

        .sidebar-nav { flex: 1; padding: 16px 12px; overflow-y: auto; }

        .nav-section-title {
            font-size: 10px;
            font-weight: 600;
            letter-spacing: .08em;
            text-transform: uppercase;
            color: var(--sidebar-text);
            padding: 12px 12px 6px;
            opacity: .6;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 14px;
            border-radius: 8px;
            text-decoration: none;
            color: var(--sidebar-text);
            font-size: 14px;
            font-weight: 500;
            transition: var(--transition);
            margin-bottom: 2px;
            position: relative;
        }

        .nav-item:hover { background: var(--sidebar-hover); color: #fff; }
        .nav-item.active { background: var(--primary); color: var(--sidebar-text-active); }
        .nav-item.active .nav-icon { color: #fff; }
        .nav-icon { font-size: 18px; width: 20px; text-align: center; flex-shrink: 0; }
        .nav-badge {
            margin-left: auto;
            background: var(--danger);
            color: #fff;
            font-size: 10px;
            font-weight: 700;
            padding: 2px 7px;
            border-radius: 20px;
        }

        .sidebar-footer {
            padding: 16px 12px;
            border-top: 1px solid rgba(255,255,255,.06);
        }

        .sidebar-user {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            border-radius: 8px;
            background: rgba(255,255,255,.04);
        }

        .sidebar-user img { width: 34px; height: 34px; border-radius: 50%; }
        .sidebar-user-info .name { color: #fff; font-size: 13px; font-weight: 600; }
        .sidebar-user-info .role { color: var(--sidebar-text); font-size: 11px; }

        /* ===== MAIN CONTENT ===== */
        .main-wrapper { margin-left: var(--sidebar-width); flex: 1; display: flex; flex-direction: column; min-height: 100vh; }

        .topbar {
            background: var(--card-bg);
            height: var(--header-height);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 28px;
            border-bottom: 1px solid var(--border);
            position: sticky;
            top: 0;
            z-index: 50;
            box-shadow: var(--shadow);
        }

        .topbar-title { font-size: 18px; font-weight: 600; color: var(--text-primary); }
        .topbar-subtitle { font-size: 12px; color: var(--text-secondary); margin-top: 2px; }

        .topbar-right { display: flex; align-items: center; gap: 12px; }

        .topbar-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 38px; height: 38px;
            border-radius: 8px;
            background: var(--body-bg);
            border: 1px solid var(--border);
            cursor: pointer;
            text-decoration: none;
            color: var(--text-secondary);
            font-size: 16px;
            transition: var(--transition);
        }
        .topbar-btn:hover { background: var(--primary-light); color: var(--primary); border-color: var(--primary); }

        .page-content { padding: 28px; flex: 1; }

        /* ===== CARDS ===== */
        .card {
            background: var(--card-bg);
            border-radius: var(--radius);
            border: 1px solid var(--border);
            box-shadow: var(--shadow);
        }

        .card-header {
            padding: 18px 24px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .card-title { font-size: 16px; font-weight: 600; color: var(--text-primary); }
        .card-body { padding: 24px; }

        /* ===== STAT CARDS ===== */
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 20px; margin-bottom: 28px; }

        .stat-card {
            background: var(--card-bg);
            border-radius: var(--radius);
            padding: 22px 24px;
            border: 1px solid var(--border);
            box-shadow: var(--shadow);
            display: flex;
            align-items: center;
            gap: 18px;
            transition: var(--transition);
        }
        .stat-card:hover { box-shadow: var(--shadow-md); transform: translateY(-2px); }

        .stat-icon {
            width: 52px; height: 52px;
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 22px;
            flex-shrink: 0;
        }

        .stat-icon.purple { background: #ede9fe; color: #7c3aed; }
        .stat-icon.green  { background: #d1fae5; color: #059669; }
        .stat-icon.blue   { background: #dbeafe; color: #2563eb; }
        .stat-icon.orange { background: #ffedd5; color: #ea580c; }

        .stat-value { font-size: 28px; font-weight: 700; color: var(--text-primary); line-height: 1; }
        .stat-label { font-size: 13px; color: var(--text-secondary); margin-top: 4px; }

        /* ===== TABLES ===== */
        .table-wrapper { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; }
        thead th { padding: 12px 16px; text-align: left; font-size: 12px; font-weight: 600; color: var(--text-secondary); text-transform: uppercase; letter-spacing: .05em; background: var(--body-bg); border-bottom: 1px solid var(--border); }
        tbody td { padding: 14px 16px; font-size: 14px; color: var(--text-primary); border-bottom: 1px solid var(--border); vertical-align: middle; }
        tbody tr:last-child td { border-bottom: none; }
        tbody tr:hover { background: #f8fafc; }

        /* ===== BADGES ===== */
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }
        .badge-success { background: #d1fae5; color: #065f46; }
        .badge-danger  { background: #fee2e2; color: #991b1b; }
        .badge-warning { background: #fef3c7; color: #92400e; }
        .badge-info    { background: #dbeafe; color: #1e40af; }

        /* ===== BUTTONS ===== */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 9px 18px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            border: none;
            text-decoration: none;
            transition: var(--transition);
            line-height: 1;
        }

        .btn-primary { background: var(--primary); color: #fff; }
        .btn-primary:hover { background: var(--primary-dark); }
        .btn-success { background: var(--success); color: #fff; }
        .btn-success:hover { background: #059669; }
        .btn-danger  { background: var(--danger); color: #fff; }
        .btn-danger:hover  { background: #dc2626; }
        .btn-sm { padding: 6px 12px; font-size: 12px; }
        .btn-outline {
            background: transparent;
            border: 1px solid var(--border);
            color: var(--text-secondary);
        }
        .btn-outline:hover { background: var(--body-bg); color: var(--text-primary); }

        /* ===== FORMS ===== */
        .form-group { margin-bottom: 20px; }
        .form-label { display: block; margin-bottom: 6px; font-size: 13px; font-weight: 500; color: var(--text-primary); }
        .form-control {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid var(--border);
            border-radius: 8px;
            font-size: 14px;
            font-family: inherit;
            color: var(--text-primary);
            background: var(--card-bg);
            transition: var(--transition);
            outline: none;
        }
        .form-control:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(99,102,241,.15); }
        textarea.form-control { resize: vertical; min-height: 120px; }
        .form-row { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; }

        /* ===== ALERTS ===== */
        .alert { padding: 12px 18px; border-radius: 8px; margin-bottom: 20px; font-size: 14px; display: flex; align-items: center; gap: 10px; }
        .alert-success { background: #d1fae5; color: #065f46; border-left: 4px solid var(--success); }
        .alert-danger  { background: #fee2e2; color: #991b1b; border-left: 4px solid var(--danger); }

        /* ===== BREADCRUMB ===== */
        .breadcrumb { display: flex; align-items: center; gap: 8px; font-size: 13px; color: var(--text-secondary); margin-bottom: 20px; }
        .breadcrumb a { color: var(--primary); text-decoration: none; }
        .breadcrumb a:hover { text-decoration: underline; }
        .breadcrumb-sep { opacity: .4; }

        /* ===== PAGINATION ===== */
        .pagination { display: flex; gap: 6px; align-items: center; flex-wrap: wrap; }
        .pagination .page-link { display: flex; align-items: center; justify-content: center; width: 36px; height: 36px; border-radius: 8px; border: 1px solid var(--border); color: var(--text-secondary); text-decoration: none; font-size: 13px; transition: var(--transition); }
        .pagination .page-link:hover, .pagination .page-link.active { background: var(--primary); color: #fff; border-color: var(--primary); }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .main-wrapper { margin-left: 0; }
            .stats-grid { grid-template-columns: repeat(2, 1fr); }
        }
    </style>
    @stack('styles')
</head>
<body>

<!-- SIDEBAR -->
<aside class="sidebar" id="sidebar">
    <a href="{{ route('admin.dashboard') }}" class="sidebar-logo">
        <div class="sidebar-logo-icon">💼</div>
        <div class="sidebar-logo-text">
            MY-JOB-CV
            <span>Admin Panel</span>
        </div>
    </a>

    <nav class="sidebar-nav">
        <div class="nav-section-title">Tổng quan</div>
        <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <span class="nav-icon">📊</span> Dashboard
        </a>

        <div class="nav-section-title">Quản lý</div>
        <a href="{{ route('admin.companies.index') }}" class="nav-item {{ request()->routeIs('admin.companies.*') ? 'active' : '' }}">
            <span class="nav-icon">🏢</span> Công ty
        </a>
        <a href="{{ route('admin.jobs.index') }}" class="nav-item {{ request()->routeIs('admin.jobs.*') ? 'active' : '' }}">
            <span class="nav-icon">💼</span> Việc làm
        </a>
        <a href="{{ route('admin.categories.index') }}" class="nav-item {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
            <span class="nav-icon">🏷️</span> Danh mục
        </a>
        <a href="{{ route('admin.users.index') }}" class="nav-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
            <span class="nav-icon">👥</span> Người dùng
        </a>
        <a href="{{ route('admin.applications.index') }}" class="nav-item {{ request()->routeIs('admin.applications.*') ? 'active' : '' }}">
            <span class="nav-icon">📄</span> Đơn ứng tuyển
        </a>
        <a href="{{ route('admin.posts.index') }}" class="nav-item {{ request()->routeIs('admin.posts.*') ? 'active' : '' }}">
            <span class="nav-icon">📝</span> Bài viết
        </a>

        <div class="nav-section-title">Freelance</div>
        <a href="{{ route('admin.mini-tasks.index') }}" class="nav-item {{ request()->routeIs('admin.mini-tasks.*') ? 'active' : '' }}">
            <span class="nav-icon">💼</span> Mini Tasks
        </a>
        <a href="{{ route('admin.student-verifications.index') }}" class="nav-item {{ request()->routeIs('admin.student-verifications.*') ? 'active' : '' }}">
            <span class="nav-icon">🎓</span> Xác thực SV
            @php $pendingCount = \App\Models\UserVerification::where('status','pending')->count(); @endphp
            @if($pendingCount > 0)
                <span style="background:#ef4444; color:#fff; font-size:10px; font-weight:800; padding:2px 6px; border-radius:10px; margin-left:auto;">{{ $pendingCount }}</span>
            @endif
        </a>

        <div class="nav-section-title">Hệ thống</div>
        <a href="{{ url('/') }}" class="nav-item" target="_blank">
            <span class="nav-icon">🌐</span> Xem website
        </a>
        <a href="{{ route('logout') }}" class="nav-item"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <span class="nav-icon">🚪</span> Đăng xuất
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="GET" style="display:none;"></form>
    </nav>

    <div class="sidebar-footer">
        @auth
        <div class="sidebar-user">
            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=6366f1&color=fff" alt="Avatar">
            <div class="sidebar-user-info">
                <div class="name">{{ Auth::user()->name }}</div>
                <div class="role">Administrator</div>
            </div>
        </div>
        @endauth
    </div>
</aside>

<!-- MAIN CONTENT -->
<div class="main-wrapper">
    <!-- TOPBAR -->
    <header class="topbar">
        <div>
            <div class="topbar-title">@yield('page-title', 'Dashboard')</div>
            <div class="topbar-subtitle">@yield('page-subtitle', 'Chào mừng trở lại, ' . (Auth::user()->name ?? 'Admin'))</div>
        </div>
        <div class="topbar-right">
            <a href="{{ url('/') }}" class="topbar-btn" title="Xem website" target="_blank">🌐</a>
        </div>
    </header>

    <!-- PAGE CONTENT -->
    <main class="page-content">
        @if(session('success'))
            <div class="alert alert-success">✅ {{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">❌ {{ session('error') }}</div>
        @endif

        @yield('content')
    </main>
</div>

@stack('scripts')
</body>
</html>
