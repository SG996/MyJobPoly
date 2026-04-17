<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

try {
    $u = App\Models\User::find(29);
    Auth::login($u);

    // Create a Request
    $request = \Illuminate\Http\Request::create('/account/update', 'POST', [
        'name' => 'Name',
        'title' => 'Title',
        'phone' => '0123',
        'gender' => 'nam',
        'dob' => '2000-01-01',
        'address' => 'abc',
        'bio' => 'abc',
        'bank_account' => '123',
        'bank_account_name' => 'NGUYEN VAN A',
        'bank_name' => 'Vietcombank'
    ]);
    
    $controller = new \App\Http\Controllers\AccountController();
    $response = $controller->updateProfile($request);
    echo "SUCCESS: " . get_class($response) . "\n";
} catch (\Throwable $e) {
    echo "ERROR: " . get_class($e) . " " . $e->getMessage() . " at " . $e->getFile() . ":" . $e->getLine() . "\n";
}
