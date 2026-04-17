<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'employer'  => \App\Http\Middleware\EnsureIsEmployer::class,
            'admin'     => \App\Http\Middleware\EnsureIsAdmin::class,
            'candidate' => \App\Http\Middleware\EnsureIsCandidate::class,
        ]);

        // Redirect unauthenticated users to login
        $middleware->redirectGuestsTo(fn() => route('login'));
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (\Illuminate\Session\TokenMismatchException $e, \Illuminate\Http\Request $request) {
            return redirect()->back()->withInput($request->except('_token'))->with('error', 'Phiên làm việc đã hết hạn. Vui lòng tải lại trang và thao tác lại.');
        });
    })->create();
