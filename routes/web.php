<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ReclamationController; // Added this line

Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');
});




// Public Registration Disabled (Admin Only)
Route::get('/register', function () {
    return redirect()->route('login')->with('error', 'Public registration is disabled. Please contact an administrator.');
})->name('register');
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Password Reset Routes
Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
Route::get('/reset-password/{token}', [AuthController::class, 'showResetPassword'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

// Authenticated Routes
Route::middleware(['auth'])->group(function () {
    // Force Password Reset Routes
    Route::get('/force-password-reset', [\App\Http\Controllers\Auth\ForcePasswordResetController::class, 'show'])->name('password.force_reset');
    Route::post('/force-password-reset', [\App\Http\Controllers\Auth\ForcePasswordResetController::class, 'store'])->name('password.force_reset.store');

    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::put('/password', [App\Http\Controllers\ProfileController::class, 'password'])->name('password.update');

    // Archive Document Routes
    Route::get('documents/archived', [App\Http\Controllers\ArchivedDocumentController::class, 'index'])->name('documents.archived');
    Route::post('documents/archived/{id}/restore', [App\Http\Controllers\ArchivedDocumentController::class, 'restore'])->name('documents.archived.restore');
    Route::delete('documents/archived/{id}/force', [App\Http\Controllers\ArchivedDocumentController::class, 'forceDelete'])->name('documents.archived.forceDelete');
    Route::get('documents/archived/{id}/download', [App\Http\Controllers\ArchivedDocumentController::class, 'download'])->name('documents.archived.download');

    // Document Routes
    Route::get('documents/{document}/download', [App\Http\Controllers\DocumentController::class, 'download'])->name('documents.download');
    Route::resource('documents', App\Http\Controllers\DocumentController::class);

    // Auth-protected reclaimed routes
    Route::resource('reclamations', ReclamationController::class)->only(['index', 'create', 'store', 'show']);

    // Admin Routes
    Route::middleware([\App\Http\Middleware\IsAdmin::class])->prefix('admin')->name('admin.')->group(function () {
        // Users Management
        Route::get('/users', [\App\Http\Controllers\Admin\AdminUsersController::class, 'index'])->name('users.index');
        Route::get('/users/create', [\App\Http\Controllers\Admin\AdminUsersController::class, 'create'])->name('users.create');
        Route::post('/users', [\App\Http\Controllers\Admin\AdminUsersController::class, 'store'])->name('users.store');
        Route::get('/users/{user}/edit', [\App\Http\Controllers\Admin\AdminUsersController::class, 'edit'])->name('users.edit');
        Route::put('/users/{user}', [\App\Http\Controllers\Admin\AdminUsersController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [\App\Http\Controllers\Admin\AdminUsersController::class, 'destroy'])->name('users.destroy');

        // Reclamations Management
        Route::get('/reclamations', [\App\Http\Controllers\Admin\AdminReclamationController::class, 'index'])->name('reclamations.index');
        Route::get('/reclamations/{reclamation}', [\App\Http\Controllers\Admin\AdminReclamationController::class, 'show'])->name('reclamations.show');
        Route::put('/reclamations/{reclamation}', [\App\Http\Controllers\Admin\AdminReclamationController::class, 'update'])->name('reclamations.update');
    });
});
Route::get('/test-email', function () {
    $targetEmail = 'YOUR_REAL_GMAIL@gmail.com'; // Change this to your real inbox for testing

    try {
        \Illuminate\Support\Facades\Log::info("Starting HARDCODED diagnostic SMTP test email to: " . $targetEmail);

        \Illuminate\Support\Facades\Mail::raw('SMTP TEST: If you see this in your real inbox, Gmail SMTP is working perfectly.', function ($message) use ($targetEmail) {
            $message->to($targetEmail)
                ->subject('DocuManage REAL SMTP Test');
        });

        \Illuminate\Support\Facades\Log::info("SMTP Test Success logged.");
        return "SMTP Test Success! Please check the inbox at: " . $targetEmail;

    } catch (\Exception $e) {
        \Illuminate\Support\Facades\Log::error("SMTP HARDCODED Test Failed!");
        \Illuminate\Support\Facades\Log::error("Exception Class: " . get_class($e));
        \Illuminate\Support\Facades\Log::error("Error Message: " . $e->getMessage());
        \Illuminate\Support\Facades\Log::error("Full Trace: " . $e->getTraceAsString());

        return "SMTP Test Failed. <br><br><b>Reason:</b> " . $e->getMessage() . "<br><br>Check <b>storage/logs/laravel.log</b> for the full technical trace.";
    }
});
