<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\DocumentController;
use App\Http\Controllers\Api\EmployeeController;
use App\Http\Controllers\Api\FinanceController;
use App\Http\Controllers\Api\InventoryController;
use App\Http\Controllers\Api\PayrollController;
use App\Http\Controllers\Api\ProjectController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function (): void {
    Route::post('auth/login', [AuthController::class, 'login']);
    Route::post('auth/refresh', [AuthController::class, 'refresh']);

    Route::middleware('auth.jwt')->group(function (): void {
        Route::get('auth/me', [AuthController::class, 'me']);
        Route::post('auth/logout', [AuthController::class, 'logout']);

        Route::get('dashboard/kpis', [DashboardController::class, 'kpis'])
            ->middleware('permission:dashboard.kpis.view');

        Route::apiResource('employees', EmployeeController::class)
            ->middleware('permission:hr.employees.view');

        Route::prefix('payroll')->controller(PayrollController::class)->group(function (): void {
            Route::get('runs', 'index')->middleware('permission:payroll.runs.view');
            Route::post('runs', 'store')->middleware('permission:payroll.runs.create');
            Route::post('runs/{payrollRun}/calculate', 'calculate')->middleware('permission:payroll.runs.calculate');
            Route::post('runs/{payrollRun}/approve', 'approve')->middleware('permission:payroll.runs.approve');
            Route::post('runs/{payrollRun}/close', 'close')->middleware('permission:payroll.runs.close');
        });

        Route::prefix('finance')->controller(FinanceController::class)->group(function (): void {
            Route::get('accounts', 'accounts')->middleware('permission:finance.accounts.view');
            Route::post('accounts', 'storeAccount')->middleware('permission:finance.accounts.create');
            Route::get('journal-entries', 'journalEntries')->middleware('permission:finance.journals.view');
        });

        Route::prefix('inventory')->controller(InventoryController::class)->group(function (): void {
            Route::get('items', 'items')->middleware('permission:inventory.items.view');
            Route::post('items', 'storeItem')->middleware('permission:inventory.items.create');
        });

        Route::apiResource('projects', ProjectController::class)
            ->middleware('permission:projects.projects.view');

        Route::apiResource('documents', DocumentController::class)
            ->only(['index', 'store', 'show'])
            ->middleware('permission:documents.documents.view');
    });
});
