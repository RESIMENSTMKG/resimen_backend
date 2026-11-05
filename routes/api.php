<?php

use App\Http\Controllers\Api\ActivityController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CommitteeController;
use App\Http\Controllers\Api\MemberController;
use App\Http\Controllers\Api\OneGateLinkController;
use App\Models\Activity;
use App\Models\Committee;
use App\Models\Member;
use App\Models\OneGateLink;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

// Health & System Status
Route::get('/health', function () {
    try {
        DB::connection()->getPdo();
        $dbStatus = 'connected';
    } catch (\Throwable $e) {
        $dbStatus = 'disconnected: ' . $e->getMessage();
    }

    return response()->json([
        'status' => 'ok',
        'database' => $dbStatus,
        'timestamp' => now()->toIso8601String(),
    ]);
});

// Dashboard Stats
Route::get('/stats', function () {
    return response()->json([
        'success' => true,
        'data' => [
            'members_count' => Member::count(),
            'activities_count' => Activity::count(),
            'one_gate_links_count' => OneGateLink::count(),
            'committees_count' => Committee::count(),
        ],
    ]);
});

// Auth Endpoints
Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);
});

// Resources CRUD Endpoints
Route::apiResource('members', MemberController::class);
Route::apiResource('activities', ActivityController::class);
Route::apiResource('one-gate-links', OneGateLinkController::class);
Route::apiResource('committees', CommitteeController::class);
