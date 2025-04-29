<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

// Define the missing logout route that Filament is looking for
Route::post('/admin/auth/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->name('filament.admin.auth.logout');
