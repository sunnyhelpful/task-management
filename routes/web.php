<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\TaskController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('dashboard', [DashboardController::class,'index'])->name('dashboard');
Route::resource('tasks', TaskController::class)->only(['index']);
Route::post('update-task-order', [TaskController::class, 'orderStorable'])->name('tasks.orderStorable');

