<?php

use Illuminate\Support\Facades\Route;


Route::apiResource('tasks', App\Http\Controllers\API\TaskController::class);

Route::patch('tasks/{id}/complete', [App\Http\Controllers\API\TaskController::class, 'complete'])
    ->name('tasks.complete');
