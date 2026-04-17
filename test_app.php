<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

try {
    $user = App\Models\User::first();
    $job = App\Models\Job::find(32);
    if (!$user || !$job) die("Missing user or job");
    
    $app = App\Models\Application::create([
        'user_id' => $user->id,
        'job_id' => $job->id,
        'cv_path' => 'cvs/test.pdf',
        'status' => 'pending'
    ]);
    echo "SUCCESS: " . $app->id;
} catch (Exception $e) {
    file_put_contents('c:\laragon\www\KNLV\error_out.txt', "ERROR: " . $e->getMessage());
}
