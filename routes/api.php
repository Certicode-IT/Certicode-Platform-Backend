<?php

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Job\JobController;

Route::post('/register',[AuthController::class, 'register']);
Route::post('/login',[AuthController::class, 'login']);

Route::post('/logout',[AuthController::class, 'logout']);
Route::get('/me',[AuthController::class, 'me']);

Route::apiResource('jobs',JobController::class);
Route::get('/visibleJobs',[JobController::class,'visibleJobs']);
Route::get('/jobs/{id}/recommended-courses',[JobController::class,'recommendedCourses']);

