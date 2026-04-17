<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Không có quyền truy cập | MyJobCV</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 50%, #f0fdf4 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .card {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,.08);
            padding: 52px 48px;
            max-width: 520px;
            width: 100%;
            text-align: center;
        }

        .icon-wrap {
            width: 90px; height: 90px;
            background: linear-gradient(135deg, #fef2f2, #fee2e2);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 42px;
            margin: 0 auto 24px;
        }

        .error-code {
            font-size: 64px;
            font-weight: 900;
            background: linear-gradient(135deg, #ef4444, #dc2626);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            line-height: 1;
            margin-bottom: 8px;
        }

        h1 {
            font-size: 22px;
            font-weight: 800;
            color: #1e293b;
            margin-bottom: 12px;
        }

        p {
            font-size: 15px;
            color: #64748b;
            line-height: 1.7;
            margin-bottom: 28px;
        }

        .role-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #f1f5f9;
            border: 1.5px solid #e2e8f0;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
            color: #475569;
            margin-bottom: 28px;
        }

        .actions {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .btn {
            display: block;
            padding: 13px 24px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 700;
            text-decoration: none;
            transition: all .2s;
        }

        .btn-primary {
            background: #00b14f;
            color: #fff;
        }
        .btn-primary:hover { background: #00913f; transform: translateY(-1px); }

        .btn-outline {
            background: transparent;
            border: 1.5px solid #e2e8f0;
            color: #64748b;
        }
        .btn-outline:hover { border-color: #00b14f; color: #00b14f; }

        .logo {
            font-size: 18px;
            font-weight: 800;
            color: #00b14f;
            margin-bottom: 32px;
            display: block;
        }
    </style>
</head>
<body>
<div class="card">
    <a href="/" class="logo">🚀 MyJobCV</a>

    <div class="icon-wrap">🔒</div>
    <div class="error-code">403</div>
    <h1>Không có quyền truy cập</h1>

    @auth
        @if(auth()->user()->role == 0)
            {{-- Ứng viên --}}
            <div class="role-badge">👤 Đang đăng nhập: Ứng viên</div>
            <p>Trang này chỉ dành cho <strong>Admin</strong> hoặc <strong>Nhà tuyển dụng</strong>. Tài khoản ứng viên của bạn không có quyền truy cập.</p>
            <div class="actions">
                <a href="/" class="btn btn-primary">🏠 Về trang chủ</a>
                <a href="{{ route('account') }}" class="btn btn-outline">👤 Hồ sơ của tôi</a>
            </div>

        @elseif(auth()->user()->role == 2)
            {{-- Nhà tuyển dụng --}}
            <div class="role-badge">🏢 Đang đăng nhập: Nhà tuyển dụng</div>
            <p>Trang này chỉ dành cho <strong>Admin</strong>. Tài khoản nhà tuyển dụng không có quyền truy cập khu vực quản trị.</p>
            <div class="actions">
                <a href="{{ route('employer.dashboard') }}" class="btn btn-primary">📊 Dashboard của tôi</a>
                <a href="/" class="btn btn-outline">🏠 Về trang chủ</a>
            </div>

        @else
            {{-- Admin đi nhầm chỗ --}}
            <div class="role-badge">⚙️ Đang đăng nhập: Admin</div>
            <p>Bạn không có quyền truy cập trang này.</p>
            <div class="actions">
                <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">⚙️ Về Admin Panel</a>
                <a href="/" class="btn btn-outline">🏠 Về trang chủ</a>
            </div>
        @endif
    @else
        {{-- Chưa đăng nhập --}}
        <p>Bạn cần đăng nhập để truy cập trang này. Nếu bạn đã có tài khoản, hãy đăng nhập ngay bên dưới.</p>
        <div class="actions">
            <a href="{{ route('login') }}" class="btn btn-primary">🔐 Đăng nhập ngay</a>
            <a href="{{ route('register') }}" class="btn btn-outline">📝 Đăng ký tài khoản</a>
        </div>
    @endauth
</div>
</body>
</html>
