<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\EmployerController;
use App\Http\Controllers\AiController;


// =====================
// PUBLIC ROUTES (Tất cả mọi người)
// =====================
Route::get('/debug-info', function() {
    $results = [];
    $results['PHP Version'] = PHP_VERSION;
    try {
        \DB::connection()->getPdo();
        $results['DB Connection'] = '✅ OK - ' . \DB::connection()->getDatabaseName();
    } catch (\Exception $e) {
        $results['DB Connection'] = '❌ FAIL: ' . $e->getMessage();
    }
    try {
        $schema = \DB::getSchemaBuilder();
        $userCols = $schema->getColumnListing('users');
        $appCols  = $schema->getColumnListing('applications');
        $mtCols   = $schema->getColumnListing('mini_task_applications');
        $results['users.is_approved']                  = in_array('is_approved', $userCols)  ? '✅ Có' : '❌ THIẾU';
        $results['applications.ai_summary']            = in_array('ai_summary', $appCols)    ? '✅ Có' : '❌ THIẾU';
        $results['mini_task_applications.ai_summary']  = in_array('ai_summary', $mtCols)     ? '✅ Có' : '❌ THIẾU';
        $results['users columns']  = implode(', ', $userCols);
    } catch (\Exception $e) {
        $results['Schema'] = '❌ ' . $e->getMessage();
    }
    $results['Storage writable'] = is_writable(storage_path()) ? '✅ OK' : '❌ Không có quyền ghi';
    $html = '<style>body{font-family:monospace;background:#0f172a;color:#e2e8f0;padding:20px;} h2{color:#818cf8;}</style>';
    $html .= '<h2>🔍 Debug Info</h2><p>➡️ <a href="/run-setup" style="color:#f59e0b;">Nhấn vào đây để TỰ ĐỘNG sửa tất cả lỗi DB</a> &nbsp;|&nbsp; <a href="/debug-gemini" style="color:#34d399;">🤖 Kiểm tra Gemini AI</a></p>';
    $html .= '<table style="border-collapse:collapse;width:100%;">';
    foreach ($results as $k => $v) {
        $color = str_contains($v, '✅') ? '#4ade80' : (str_contains($v, '❌') ? '#f87171' : '#e2e8f0');
        $html .= "<tr><td style='padding:10px;border-bottom:1px solid #1e293b;color:#94a3b8;min-width:260px;'>$k</td><td style='padding:10px;border-bottom:1px solid #1e293b;color:$color;'>$v</td></tr>";
    }
    $html .= '</table>';
    return $html;
});

// =====================
// DEBUG GEMINI AI STATUS
// =====================
Route::get('/debug-gemini', function () {
    $gemini  = new \App\Services\GeminiService();
    $results = $gemini->testConnection();
    $apiKey  = config('gemini.api_key');
    $maskedKey = $apiKey ? substr($apiKey, 0, 8) . '...' . substr($apiKey, -4) : '(chưa cấu hình)';

    $html = '<style>body{font-family:monospace;background:#0f172a;color:#e2e8f0;padding:30px;} h2{color:#818cf8;} li{padding:8px 0;font-size:15px;}</style>';
    $html .= '<h2>🤖 Gemini AI Status</h2>';
    $html .= "<p style='color:#94a3b8;'>API Key: <code style='color:#f59e0b;'>$maskedKey</code> &nbsp; Model: <code style='color:#f59e0b;'>" . config('gemini.model') . "</code></p>";
    $html .= '<table style="border-collapse:collapse;width:100%;max-width:700px;">';
    foreach ($results as $model => $status) {
        $color = str_contains($status, '✅') ? '#4ade80' : (str_contains($status, '⚠️') ? '#fbbf24' : '#f87171');
        $html .= "<tr><td style='padding:10px;border-bottom:1px solid #1e293b;color:#94a3b8;width:260px;'>$model</td>";
        $html .= "<td style='padding:10px;border-bottom:1px solid #1e293b;color:$color;'>$status</td></tr>";
    }
    $html .= '</table>';

    $hasWorking = collect($results)->contains(fn($s) => str_contains($s, '✅'));
    if ($hasWorking) {
        $html .= '<p style="color:#4ade80;margin-top:20px;">✅ Gemini AI đang hoạt động bình thường.</p>';
    } else {
        $html .= '<div style="margin-top:20px;padding:16px;background:#1e1b4b;border-radius:8px;border:1px solid #4338ca;">';
        $html .= '<p style="color:#fbbf24;font-weight:bold;margin-bottom:8px;">⚠️ Gemini AI không khả dụng. Nguyên nhân có thể:</p>';
        $html .= '<ul style="color:#e2e8f0;font-size:13px;">';
        $html .= '<li>1. Free tier quota đã hết → Vào <a href="https://ai.dev/rate-limit" style="color:#60a5fa;" target="_blank">ai.dev/rate-limit</a> kiểm tra</li>';
        $html .= '<li>2. Chưa bật Generative Language API → Vào <a href="https://console.cloud.google.com/apis/library/generativelanguage.googleapis.com" style="color:#60a5fa;" target="_blank">Google Cloud Console</a></li>';
        $html .= '<li>3. API key sai/bị thu hồi → Tạo key mới tại <a href="https://aistudio.google.com/apikey" style="color:#60a5fa;" target="_blank">aistudio.google.com/apikey</a></li>';
        $html .= '<li>4. Project chưa bật billing → Bật billing để dùng free tier $300 credit</li>';
        $html .= '</ul></div>';
    }

    $html .= '<br><a href="/debug-info" style="color:#94a3b8;">← Về Debug Info</a>';
    return $html;
});

// ROUTE FIX LỖI 404 KHI XEM ẢNH/CV TRÊN CPANEL (Bypass Symlink)
Route::get('/storage/{folder}/{filename}', function ($folder, $filename) {
    // Decode filename in case it has URL encoded characters
    $filename = urldecode($filename);
    $path = storage_path('app/public/' . $folder . '/' . $filename);
    if (!file_exists($path)) {
        abort(404, 'File không tồn tại trên server.');
    }
    
    // Fallback MIME type check without using finfo
    $extension = pathinfo($path, PATHINFO_EXTENSION);
    $mimeTypes = [
        'pdf' => 'application/pdf',
        'png' => 'image/png',
        'jpg' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'doc' => 'application/msword',
        'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
    ];
    $mime = $mimeTypes[strtolower($extension)] ?? 'application/octet-stream';
    
    return response()->stream(function () use ($path) {
        readfile($path);
    }, 200, [
        'Content-Type' => $mime,
        'Content-Disposition' => 'inline; filename="' . basename($path) . '"'
    ]);
})->where('filename', '.*');

Route::get('/run-setup', function() {
    $log = [];
    try {
        $schema = \DB::getSchemaBuilder();

        // 1. Thêm is_approved vào users
        if (!$schema->hasColumn('users', 'is_approved')) {
            \DB::statement('ALTER TABLE `users` ADD COLUMN `is_approved` tinyint(1) NOT NULL DEFAULT 1 AFTER `role`');
            $log[] = '✅ Đã thêm cột users.is_approved';
        } else {
            $log[] = '⏭️ users.is_approved đã tồn tại';
        }

        // 2. Thêm ai_summary vào applications
        if (!$schema->hasColumn('applications', 'ai_summary')) {
            \DB::statement('ALTER TABLE `applications` ADD COLUMN `ai_summary` text NULL');
            $log[] = '✅ Đã thêm cột applications.ai_summary';
        } else {
            $log[] = '⏭️ applications.ai_summary đã tồn tại';
        }

        // 3. Thêm ai_summary vào mini_task_applications
        if (!$schema->hasColumn('mini_task_applications', 'ai_summary')) {
            \DB::statement('ALTER TABLE `mini_task_applications` ADD COLUMN `ai_summary` text NULL');
            $log[] = '✅ Đã thêm cột mini_task_applications.ai_summary';
        } else {
            $log[] = '⏭️ mini_task_applications.ai_summary đã tồn tại';
        }

        // 4. Mở khóa toàn bộ ứng viên (role != 2)
        \DB::statement('UPDATE `users` SET `is_approved` = 1 WHERE `is_approved` = 0 AND `role` != 2');
        $log[] = '✅ Đã mở khóa tất cả tài khoản ứng viên';

        // 5. Tạo storage symlink (thay thế php artisan storage:link)
        $publicStorage = public_path('storage');
        $storageTarget = storage_path('app/public');
        if (!file_exists($publicStorage)) {
            if (function_exists('symlink') && symlink($storageTarget, $publicStorage)) {
                $log[] = '✅ Đã tạo storage symlink (public/storage → storage/app/public)';
            } else {
                // Fallback: copy thay vì symlink nếu hosting không cho phép
                $log[] = '⚠️ Không thể tạo symlink. Hãy tạo thủ công hoặc dùng cPanel File Manager tạo symlink từ public/storage → ../storage/app/public';
            }
        } else {
            $log[] = '⏭️ public/storage đã tồn tại';
        }

        // 6. Xóa cache bootstrap
        foreach (['config', 'routes', 'views'] as $cache) {
            try {
                \Artisan::call("$cache:clear");
                $log[] = "✅ Cleared $cache cache";
            } catch (\Exception $e) {
                $log[] = "⚠️ Không thể clear $cache: " . $e->getMessage();
            }
        }

    } catch (\Exception $e) {
        $log[] = '❌ LỖI: ' . $e->getMessage();
    }

    $html = '<style>body{font-family:monospace;background:#0f172a;color:#e2e8f0;padding:30px;} h2{color:#818cf8;} li{padding:8px 0;font-size:15px;}</style>';
    $html .= '<h2>🛠️ Kết quả Setup</h2><ul>';
    foreach ($log as $l) $html .= "<li>$l</li>";
    $html .= '</ul><br>';
    $html .= '<a href="/" style="color:#4ade80; margin-right:20px;">→ Về trang chủ</a>';
    $html .= '<a href="/debug-info" style="color:#f59e0b;">→ Xem lại Debug Info</a>';
    return $html;
});

Route::get('/', [HomeController::class, 'index']);
Route::get('/jobs', [HomeController::class, 'jobs'])->name('jobs.list');
Route::get('/job/{id}', [HomeController::class, 'show'])->name('job.show');
Route::get('/company/{id}', [HomeController::class, 'company'])->name('company.show');
Route::get('/user/{id}', [HomeController::class, 'userProfile'])->name('user.show');

Route::get('/post-detail/{slug}', [HomeController::class, 'postDetail'])->name('post.detail');
Route::get('/post',              [HomeController::class, 'posts'])->name('posts.list');

// Freelance public
Route::get('/freelance',        [App\Http\Controllers\FreelanceController::class, 'index'])->name('freelance.index');
Route::get('/freelance/{slug}', [App\Http\Controllers\FreelanceController::class, 'show'])->name('freelance.show');

// Auth routes (chỉ cho user chưa đăng nhập)
Route::middleware('guest')->group(function () {
    Route::get('/login',    fn() => view('login'))->name('login');
    Route::get('/register', fn() => view('register'))->name('register');
    Route::post('/register', [AuthController::class, 'registerPost'])->name('register.post');
    Route::post('/login',    [AuthController::class, 'loginPost'])->name('login.post');

    // Đăng ký nhà tuyển dụng (public)
    Route::get('/register/employer',  [AuthController::class, 'registerEmployer'])->name('register.employer');
    Route::post('/register/employer', [AuthController::class, 'registerEmployerPost'])->name('register.employer.post');
});

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');


// =====================
// ỨUNG VIÊN (role = 0)
// =====================
Route::middleware(['auth', 'candidate'])->group(function () {
    Route::get('/account', [AccountController::class, 'index'])->name('account');
    Route::post('/account/update', [AccountController::class, 'updateProfile'])->name('account.update');

    Route::get('/account/saved-jobs', [AccountController::class, 'savedJobs'])->name('account.saved_jobs');
    Route::redirect('/account/saved_job', '/account/saved-jobs');
    Route::redirect('/account/saved-job', '/account/saved-jobs');

    Route::post('/job/{id}/apply', [AccountController::class, 'applyForJob'])->name('job.apply');
    Route::get('/job/{id}/apply', fn($id) => redirect('/job/' . $id));
    Route::get('/account/applied-jobs', [AccountController::class, 'appliedJobs'])->name('account.applied_jobs');
});

// Freelance (candidate)
Route::middleware(['auth', 'candidate'])->group(function () {
    Route::post('/freelance/{id}/apply',                [App\Http\Controllers\AccountFreelanceController::class, 'apply'])->name('freelance.apply');
    Route::post('/freelance/application/{id}/progress', [App\Http\Controllers\AccountFreelanceController::class, 'updateProgress'])->name('freelance.progress');
    Route::get('/account/freelance',                    [App\Http\Controllers\AccountFreelanceController::class, 'myTasks'])->name('account.freelance');
    Route::get('/account/verify-student',               [App\Http\Controllers\AccountFreelanceController::class, 'verifyStudentForm'])->name('account.verify_student');
    Route::post('/account/verify-student',              [App\Http\Controllers\AccountFreelanceController::class, 'verifyStudentSubmit'])->name('account.verify_student.post');
});

// Lưu việc làm (cần đăng nhập, mọi role)
Route::middleware('auth')->post('/job/save/{id}', [AccountController::class, 'toggleSaveJob'])->name('job.save');

// =====================
// AI AJAX ENDPOINTS
// =====================
Route::middleware('auth')->group(function () {
    Route::get('/ai/status',                [AiController::class, 'status'])->name('ai.status');
    Route::post('/ai/suggest-cover-letter', [AiController::class, 'suggestCoverLetter'])->name('ai.suggest');
    Route::post('/ai/check-minitask',       [AiController::class, 'checkMiniTask'])->name('ai.check_minitask');
});


// =====================
// ADMIN (role = 1)
// =====================
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {

    Route::get('/', [App\Http\Admin\DashboardController::class, 'index'])->name('dashboard');

    // Việc làm
    Route::get('/jobs',              [App\Http\Admin\JobController::class, 'index'])->name('jobs.index');
    Route::get('/jobs/create',       [App\Http\Admin\JobController::class, 'create'])->name('jobs.create');
    Route::post('/jobs',             [App\Http\Admin\JobController::class, 'store'])->name('jobs.store');
    Route::get('/jobs/{id}/edit',    [App\Http\Admin\JobController::class, 'edit'])->name('jobs.edit');
    Route::put('/jobs/{id}',         [App\Http\Admin\JobController::class, 'update'])->name('jobs.update');
    Route::delete('/jobs/{id}',      [App\Http\Admin\JobController::class, 'destroy'])->name('jobs.destroy');
    Route::post('/jobs/{id}/toggle', [App\Http\Admin\JobController::class, 'toggleActive'])->name('jobs.toggle');

    // Công ty
    Route::resource('companies', App\Http\Admin\CompanyController::class);

    // Danh mục
    Route::get('/categories',           [App\Http\Admin\CategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/create',    [App\Http\Admin\CategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories',          [App\Http\Admin\CategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{id}/edit', [App\Http\Admin\CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/{id}',      [App\Http\Admin\CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{id}',   [App\Http\Admin\CategoryController::class, 'destroy'])->name('categories.destroy');

    // Người dùng
    Route::get('/users', [App\Http\Admin\UserController::class, 'index'])->name('users.index');
    Route::post('/users/{id}/toggle-approve', [App\Http\Admin\UserController::class, 'toggleApprove'])->name('users.toggle_approve');

    // Đơn ứng tuyển
    Route::get('/applications',       [App\Http\Admin\ApplicationController::class, 'index'])->name('applications.index');
    Route::post('/applications/{id}', [App\Http\Admin\ApplicationController::class, 'updateStatus'])->name('applications.update_status');

    // Bài viết
    Route::resource('posts', App\Http\Admin\PostController::class);
    Route::post('/posts/{id}/toggle', [App\Http\Admin\PostController::class, 'togglePublish'])->name('posts.toggle');

    // Mini Tasks
    Route::get('/mini-tasks',              [App\Http\Admin\MiniTaskAdminController::class, 'index'])->name('mini-tasks.index');
    Route::post('/mini-tasks/{id}/toggle', [App\Http\Admin\MiniTaskAdminController::class, 'toggleActive'])->name('mini-tasks.toggle');
    Route::delete('/mini-tasks/{id}',      [App\Http\Admin\MiniTaskAdminController::class, 'destroy'])->name('mini-tasks.destroy');

    // Xác thực sinh viên
    Route::get('/student-verifications',             [App\Http\Admin\StudentVerificationController::class, 'index'])->name('student-verifications.index');
    Route::post('/student-verifications/{id}/approve', [App\Http\Admin\StudentVerificationController::class, 'approve'])->name('student-verifications.approve');
    Route::post('/student-verifications/{id}/reject',  [App\Http\Admin\StudentVerificationController::class, 'reject'])->name('student-verifications.reject');
});


// =====================
// NHÀ TUYỂN DỤNG (role = 2)
// =====================
Route::prefix('employer')->name('employer.')->middleware(['auth', 'employer'])->group(function () {
    Route::get('/dashboard',                 [EmployerController::class, 'dashboard'])->name('dashboard');
    Route::get('/jobs/create',               [EmployerController::class, 'createJob'])->name('jobs.create');
    Route::post('/jobs',                     [EmployerController::class, 'storeJob'])->name('jobs.store');
    Route::get('/my-jobs',                   [EmployerController::class, 'myJobs'])->name('jobs.index');
    Route::post('/jobs/{id}/toggle',         [EmployerController::class, 'toggleJob'])->name('jobs.toggle');
    Route::get('/jobs/{id}/edit',            [EmployerController::class, 'editJob'])->name('jobs.edit');
    Route::put('/jobs/{id}',                 [EmployerController::class, 'updateJob'])->name('jobs.update');
    Route::get('/applications',              [EmployerController::class, 'applications'])->name('applications');
    Route::post('/applications/{id}/status', [EmployerController::class, 'updateApplicationStatus'])->name('applications.status');
    Route::get('/profile',                   [EmployerController::class, 'profile'])->name('profile');
    Route::post('/profile',                  [EmployerController::class, 'updateProfile'])->name('profile.update');

    // Mini Tasks
    Route::get('/mini-tasks',                         [App\Http\Controllers\EmployerMiniTaskController::class, 'index'])->name('mini-tasks.index');
    Route::get('/mini-tasks/create',                  [App\Http\Controllers\EmployerMiniTaskController::class, 'create'])->name('mini-tasks.create');
    Route::post('/mini-tasks',                        [App\Http\Controllers\EmployerMiniTaskController::class, 'store'])->name('mini-tasks.store');
    Route::get('/mini-tasks/{id}/edit',               [App\Http\Controllers\EmployerMiniTaskController::class, 'edit'])->name('mini-tasks.edit');
    Route::put('/mini-tasks/{id}',                    [App\Http\Controllers\EmployerMiniTaskController::class, 'update'])->name('mini-tasks.update');
    Route::delete('/mini-tasks/{id}',                 [App\Http\Controllers\EmployerMiniTaskController::class, 'destroy'])->name('mini-tasks.destroy');
    Route::get('/mini-tasks/{id}/applications',       [App\Http\Controllers\EmployerMiniTaskController::class, 'applications'])->name('mini-tasks.applications');
    Route::post('/mini-tasks/application/{id}/accept', [App\Http\Controllers\EmployerMiniTaskController::class, 'acceptApplication'])->name('mini-tasks.application.accept');
    Route::post('/mini-tasks/application/{id}/reject', [App\Http\Controllers\EmployerMiniTaskController::class, 'rejectApplication'])->name('mini-tasks.application.reject');
    Route::post('/mini-tasks/application/{id}/payment',[App\Http\Controllers\EmployerMiniTaskController::class, 'confirmPayment'])->name('mini-tasks.application.payment');
});
