<?php

use App\AlertType;
use App\Http\Middleware\FrameGuard;
use App\Utilities\AlertDataGenerator;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        channels: __DIR__.'/../routes/channels.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->append(FrameGuard::class);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (Exception $exception, Request $request) {
            logger()->error($exception);
            report($exception);

            if (!$request->hasSession()) {
                return;
            }

            if ($exception instanceof ValidationException) {
                AlertDataGenerator::generateAsFlashToSession(
                    AlertType::DANGER,
                    "Terjadi kesalahan dalam validasi data",
                    json_encode($exception->errors(), JSON_PRETTY_PRINT),
                    $request->session(),
                );
                return;
            }

            AlertDataGenerator::generateAsFlashToSession(
                AlertType::DANGER,
                "Terjadi kesalahan",
                $exception->getMessage(),
                $request->session(),
            );
        });
    })->create();
