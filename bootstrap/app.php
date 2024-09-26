<?php

use Illuminate\Foundation\Application;
use App\Http\Middleware\v1\AdminMiddleware;
use App\Http\Middleware\v1\StaffMiddleware;
use App\Http\Middleware\v1\MemberMiddleware;
use App\Http\Middleware\v1\LibrarianMiddleware;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->appendToGroup('admin', [AdminMiddleware::class]);
        $middleware->appendToGroup('librarian', [LibrarianMiddleware::class]);
        $middleware->appendToGroup('member', [MemberMiddleware::class]);
        $middleware->appendToGroup('staff', [StaffMiddleware::class]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
