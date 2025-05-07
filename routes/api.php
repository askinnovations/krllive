<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\Api\TaskmanagementController;


Route::get('/test-api', function () {
    return response()->json(['message' => 'API is working!'], 200);
});

Route::get('/task-management', [TaskmanagementController::class, 'index']);
Route::post('/task-management/store', [TaskmanagementController::class, 'store']);
Route::get('/task-management/show/{id}', [TaskmanagementController::class, 'show']);
Route::post('/task-management/update/{id}', [TaskmanagementController::class, 'update']);
Route::get('/task-management/delete/{id}', [TaskmanagementController::class, 'destroy']);



