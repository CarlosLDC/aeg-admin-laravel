<?php

use Filament\Notifications\Notification;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->trustProxies(at: '*');
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (QueryException $exception, Request $request) {
            $sql = strtolower(trim((string) $exception->getSql()));
            $sqlState = (string) $exception->getCode();
            $driverCode = (int) ($exception->errorInfo[1] ?? 0);
            $message = strtolower($exception->getMessage());

            $isDeleteStatement = str_starts_with($sql, 'delete');

            $isRestrictOnDelete = in_array($sqlState, ['23000', '23503'], true)
                || in_array($driverCode, [1451, 19], true)
                || str_contains($message, 'foreign key constraint')
                || str_contains($message, 'constraint failed');

            if (! $isDeleteStatement || ! $isRestrictOnDelete) {
                return null;
            }

            $friendlyMessage = 'No se puede eliminar este registro porque tiene información relacionada.';

            Notification::make()
                ->danger()
                ->title($friendlyMessage)
                ->send();

            if ($request->expectsJson() || $request->hasHeader('X-Livewire')) {
                return response()->json([
                    'message' => $friendlyMessage,
                ], 409);
            }

            return back()->with('error', $friendlyMessage);
        });
    })->create();
