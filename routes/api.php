<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiController; 
Route::get('/test-api', function () {
    return response()->json(['message' => 'API is working!'], 200);
});

// ✅ Sahi tarika se APIController ka route likhein
Route::post('register', [ApiController::class, 'register']); 
Route::post('verify-otp', [ApiController::class, 'verifyOtp']); 
Route::post('login', [ApiController::class, 'loginWithMobile']); 


Route::middleware(['auth:sanctum'])->group(function (){
    Route::post('logout', [ApiController::class, 'logout']);
    Route::get('profile', [ApiController::class, 'profile']);
    Route::post('update-profile', [ApiController::class, 'updateProfile']);
    Route::get('/all-complaints', [ApiController::class, 'getAllComplaints']); 
    Route::get('/my-complaints', [ApiController::class, 'getMyComplaints']); 
    Route::post('/store-complaint', [ApiController::class, 'storeComplaint']); 
    Route::get('/complaints/{id}', [ApiController::class, 'showComplaint']); 
    Route::get('/complaints/search', [ApiController::class, 'searchComplaintByPan']);

});

