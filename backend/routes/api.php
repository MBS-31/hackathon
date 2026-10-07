<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HealthController;

/*
|=============================================================================
| CRM API Routes — v1
|=============================================================================
|
| All routes here are prefixed with /api by the bootstrap/app.php configuration.
|
| Route groups by domain module:
|   - Health / System
|   - Auth
|   - Users
|   - Roles & Permissions
|   - Leads
|   - Contacts
|   - Accounts
|   - Opportunities
|   - Tasks
|   - Activities
|   - Communications
|   - Documents
|   - Notifications
|   - Audit
|
*/

// ============================================================================
// Health & System
// ============================================================================
Route::get('/health', [HealthController::class, 'check'])->name('api.health');
Route::get('/health/db', [HealthController::class, 'database'])->name('api.health.db');

// ============================================================================
// API v1 — Public
// ============================================================================
Route::prefix('v1')->name('v1.')->group(function () {

    // -------------------------------------------------------------------------
    // Auth — unauthenticated endpoints
    // -------------------------------------------------------------------------
    Route::prefix('auth')->name('auth.')->group(function () {
        Route::post('/login',           [\App\Modules\Auth\Controllers\AuthController::class, 'login'])->name('login');
        Route::post('/register',        [\App\Modules\Auth\Controllers\AuthController::class, 'register'])->name('register');
        Route::post('/forgot-password', [\App\Modules\Auth\Controllers\AuthController::class, 'forgotPassword'])->name('forgot-password');
        Route::post('/reset-password',  [\App\Modules\Auth\Controllers\AuthController::class, 'resetPassword'])->name('reset-password');
    });

    // =========================================================================
    // Protected routes — requires valid JWT
    // =========================================================================
    Route::middleware(['auth.jwt'])->group(function () {

        // ---------------------------------------------------------------------
        // Auth — authenticated actions
        // ---------------------------------------------------------------------
        Route::prefix('auth')->name('auth.')->group(function () {
            Route::post('/logout',         [\App\Modules\Auth\Controllers\AuthController::class, 'logout'])->name('logout');
            Route::post('/refresh',        [\App\Modules\Auth\Controllers\AuthController::class, 'refresh'])->name('refresh');
            Route::get('/me',              [\App\Modules\Auth\Controllers\AuthController::class, 'me'])->name('me');
            Route::put('/change-password', [\App\Modules\Auth\Controllers\AuthController::class, 'changePassword'])->name('change-password');
        });

        // ---------------------------------------------------------------------
        // Users
        // ---------------------------------------------------------------------
        Route::middleware(['permission:users.view'])->group(function () {
            Route::apiResource('users', \App\Modules\Users\Controllers\UserController::class);
            Route::patch('/users/{user}/restore', [\App\Modules\Users\Controllers\UserController::class, 'restore'])->name('users.restore');
            Route::patch('/users/{user}/status',  [\App\Modules\Users\Controllers\UserController::class, 'updateStatus'])->name('users.status');
        });

        // ---------------------------------------------------------------------
        // Roles & Permissions
        // ---------------------------------------------------------------------
        Route::middleware(['permission:roles.view'])->group(function () {
            Route::apiResource('roles',       \App\Modules\Roles\Controllers\RoleController::class);
            Route::apiResource('permissions', \App\Modules\Permissions\Controllers\PermissionController::class)->only(['index', 'show']);
            Route::post('/roles/{role}/permissions', [\App\Modules\Roles\Controllers\RoleController::class, 'syncPermissions'])->name('roles.permissions.sync');
            Route::post('/users/{user}/roles',       [\App\Modules\Users\Controllers\UserController::class, 'syncRoles'])->name('users.roles.sync');
        });

        // ---------------------------------------------------------------------
        // Leads  (stub — business logic added in later sets)
        // ---------------------------------------------------------------------
        Route::middleware(['permission:leads.view'])->group(function () {
            Route::apiResource('leads', \App\Modules\Leads\Controllers\LeadController::class);
        });

        // ---------------------------------------------------------------------
        // Contacts
        // ---------------------------------------------------------------------
        Route::middleware(['permission:contacts.view'])->group(function () {
            Route::apiResource('contacts', \App\Modules\Contacts\Controllers\ContactController::class);
        });

        // ---------------------------------------------------------------------
        // Accounts
        // ---------------------------------------------------------------------
        Route::middleware(['permission:accounts.view'])->group(function () {
            Route::apiResource('accounts', \App\Modules\Accounts\Controllers\AccountController::class);
        });

        // ---------------------------------------------------------------------
        // Opportunities
        // ---------------------------------------------------------------------
        Route::middleware(['permission:opportunities.view'])->group(function () {
            Route::apiResource('opportunities', \App\Modules\Opportunities\Controllers\OpportunityController::class);
        });

        // ---------------------------------------------------------------------
        // Tasks
        // ---------------------------------------------------------------------
        Route::middleware(['permission:tasks.view'])->group(function () {
            Route::apiResource('tasks', \App\Modules\Tasks\Controllers\TaskController::class);
        });

        // ---------------------------------------------------------------------
        // Activities
        // ---------------------------------------------------------------------
        Route::middleware(['permission:activities.view'])->group(function () {
            Route::apiResource('activities', \App\Modules\Activities\Controllers\ActivityController::class);
        });

        // ---------------------------------------------------------------------
        // Communications
        // ---------------------------------------------------------------------
        Route::middleware(['permission:communications.view'])->group(function () {
            Route::apiResource('communications', \App\Modules\Communications\Controllers\CommunicationController::class);
        });

        // ---------------------------------------------------------------------
        // Documents
        // ---------------------------------------------------------------------
        Route::middleware(['permission:documents.view'])->group(function () {
            Route::apiResource('documents', \App\Modules\Documents\Controllers\DocumentController::class);
        });

        // ---------------------------------------------------------------------
        // Notifications
        // ---------------------------------------------------------------------
        Route::prefix('notifications')->name('notifications.')->group(function () {
            Route::get('/',          [\App\Modules\Notifications\Controllers\NotificationController::class, 'index'])->name('index');
            Route::patch('/{id}/read', [\App\Modules\Notifications\Controllers\NotificationController::class, 'markRead'])->name('read');
            Route::post('/read-all', [\App\Modules\Notifications\Controllers\NotificationController::class, 'readAll'])->name('read-all');
        });

        // ---------------------------------------------------------------------
        // Audit Logs (admin only)
        // ---------------------------------------------------------------------
        Route::middleware(['permission:audit.view'])->group(function () {
            Route::get('/audit-logs', [\App\Modules\Audit\Controllers\AuditController::class, 'index'])->name('audit.index');
            Route::get('/audit-logs/{id}', [\App\Modules\Audit\Controllers\AuditController::class, 'show'])->name('audit.show');
        });

    }); // end auth.jwt guard

}); // end v1 prefix
