<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Api\LogsApiController;
use App\Http\Controllers\Api\FacultyControllerAPI;
use App\Http\Controllers\Api\LabKeyControllerApi;
use App\Http\Middleware\PreventBackHistory;
use App\Http\Middleware\RedirectIfNotAdmin;
use App\Http\Middleware\ApiKeyMiddleware;

// Public routes
Route::get('/', [AdminController::class, 'welcome'])->name('admin.welcome');
Route::get('/redirect', [AdminController::class, 'loader'])->name('admin.loader');
Route::get('/login', [AdminController::class, 'login'])->name('login');
Route::post('/login', [AdminController::class, 'authenticate'])->name('admin.authenticate');
Route::post('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');

// Admin routes with middleware
Route::middleware(['auth:admin', RedirectIfNotAdmin::class, PreventBackHistory::class])->group(function () {
    Route::get('/admin/app', [AdminController::class, 'app'])->name('admin.app');
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/key-register', [AdminController::class, 'create'])->name('admin.create');
    Route::get('/admin/faculty/register', [AdminController::class, 'createFaculty'])->name('admin.createFaculty');
    Route::patch('/admin/faculty/{faculty_id}/toggle-status', [AdminController::class, 'toggleStatus'])->name('admin.toggleStatus');
    Route::post('/admin/faculty/store', [AdminController::class, 'store'])->name('admin.store');
    Route::get('/admin/labkeys', [AdminController::class, 'labKeys'])->name('admin.labkeys');
    Route::post('/admin/labkeys/store', [AdminController::class, 'storeLabKey'])->name('admin.labkeys.store');
    Route::get('/admin/list', [AdminController::class, 'list'])->name('admin.list');
    Route::get('/admin/log', [AdminController::class, 'log'])->name('admin.log');
});

// API routes with API key middleware
Route::middleware([ApiKeyMiddleware::class])->group(function () {
    Route::post('/logs/store', [LogsApiController::class, 'store'])
        ->name('logs.store')
        ->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class]);

    Route::get('api/faculty', [FacultyControllerAPI::class, 'index']);
    Route::get('api/faculty/{id}', [FacultyControllerAPI::class, 'show']);

    Route::get('api/key', [LabKeyControllerApi::class, 'index']);
    Route::get('api/key/{id}', [LabKeyControllerApi::class, 'show']);
});
