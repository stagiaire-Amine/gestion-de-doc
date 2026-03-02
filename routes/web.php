<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\ArchivedDocumentController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ClientDocumentController;
use App\Http\Controllers\ReclamationController;
use App\Http\Controllers\Auth\ForcePasswordResetController;
use App\Http\Controllers\Admin\AdminUsersController;
use App\Http\Controllers\Admin\RoleManagementController;
use App\Http\Controllers\Admin\AdminReclamationController;

// --- PUBLIC ROUTES ---
Route::get('/', function () {
    return auth()->check() ? redirect()->route('dashboard') : redirect()->route('login');
});

Route::get('/register', function () {
    return redirect()->route('login')->with('error', 'Public registration is disabled.');
})->name('register');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::match(['get', 'post'], '/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
Route::get('/reset-password/{token}', [AuthController::class, 'showResetPassword'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

// --- AUTHENTICATED ROUTES ---
Route::middleware(['auth'])->group(function () {

    // Global Dashboard & Profile
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/password', [ProfileController::class, 'password'])->name('password.update');

    // Force Password Reset
    Route::get('/force-password-reset', [ForcePasswordResetController::class, 'show'])->name('password.force_reset');
    Route::post('/force-password-reset', [ForcePasswordResetController::class, 'store'])->name('password.force_reset.store');

    // Support (Always accessible if logged in)
    Route::resource('reclamations', ReclamationController::class)->only(['index', 'create', 'store', 'show']);

    // --- PROTECTED FEATURE ROUTES ---

    // 📄 DOCUMENTS
    // 1. Creation/Modification (MUST BE BEFORE VIEW/{ID})
    Route::middleware(['perm:documents.create'])->group(function () {
        Route::get('documents/create', [DocumentController::class, 'create'])->name('documents.create');
        Route::post('documents', [DocumentController::class, 'store'])->name('documents.store');
        Route::post('clients/{client}/docs', [ClientDocumentController::class, 'store'])->name('documents.store_for_client');
    });

    Route::middleware(['perm:documents.update'])->group(function () {
        Route::get('documents/{document}/edit', [DocumentController::class, 'edit'])->name('documents.edit');
        Route::put('documents/{document}', [DocumentController::class, 'update'])->name('documents.update');
    });

    // 2. Viewing (Static routes first)
    Route::get('documents', [DocumentController::class, 'index'])->name('documents.index');
    Route::get('documents/archived', [ArchivedDocumentController::class, 'index'])->name('documents.archived');
    Route::get('documents/{document}', [DocumentController::class, 'show'])->name('documents.show');
    Route::get('documents/{document}/download', [DocumentController::class, 'download'])->name('documents.download');
    Route::get('documents/archived/{id}/download', [ArchivedDocumentController::class, 'download'])->name('documents.archived.download');

    // 3. Deletion/Maintenance
    Route::middleware(['perm:documents.delete'])->group(function () {
        Route::delete('documents/{document}', [DocumentController::class, 'destroy'])->name('documents.destroy');
        Route::post('documents/archived/{id}/restore', [ArchivedDocumentController::class, 'restore'])->name('documents.archived.restore');
        Route::delete('documents/archived/{id}/force', [ArchivedDocumentController::class, 'forceDelete'])->name('documents.archived.forceDelete');
        Route::delete('docs/{document}', [ClientDocumentController::class, 'destroy'])->name('documents.destroy_client_doc');
    });

    // 📁 CLIENTS
    // 1. Creation (Static routes first)
    Route::middleware(['perm:clients.create'])->group(function () {
        Route::get('clients/create', [ClientController::class, 'create'])->name('clients.create');
        Route::post('clients', [ClientController::class, 'store'])->name('clients.store');
    });

    // 2. Viewing
    Route::get('clients', [ClientController::class, 'index'])->name('clients.index');
    Route::get('clients/{client}', [ClientController::class, 'show'])->name('clients.show');

    // --- SYSTEM ADMINISTRATION ---
    Route::middleware([\App\Http\Middleware\IsAdmin::class])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/admin', function () {
            return redirect()->route('admin.users.index');
        });

        Route::get('/users', [AdminUsersController::class, 'index'])->name('users.index');
        Route::get('/users/create', [AdminUsersController::class, 'create'])->name('users.create');
        Route::post('/users', [AdminUsersController::class, 'store'])->name('users.store');
        Route::get('/users/{user}/edit', [AdminUsersController::class, 'edit'])->name('users.edit');
        Route::put('/users/{user}', [AdminUsersController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [AdminUsersController::class, 'destroy'])->name('users.destroy');

        Route::get('/user-roles', [RoleManagementController::class, 'index'])->name('users.roles.index');
        Route::get('/users/{user}/roles', [RoleManagementController::class, 'edit'])->name('users.roles.edit');
        Route::put('/users/{user}/roles', [RoleManagementController::class, 'update'])->name('users.roles.update');

        Route::get('/reclamations', [AdminReclamationController::class, 'index'])->name('reclamations.index');
        Route::get('/reclamations/{reclamation}', [AdminReclamationController::class, 'show'])->name('reclamations.show');
        Route::put('/reclamations/{reclamation}', [AdminReclamationController::class, 'update'])->name('reclamations.update');
    });

    // Admin redirect
    Route::get('/admin', function () {
        return redirect()->route('admin.users.index');
    });
});
