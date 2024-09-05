<?php
use App\Http\Controllers\RequestController;
use App\Http\Controllers\AssignmentController;

Route::post('/requests', [RequestController::class, 'createRequest']);
Route::post('/requests/{id}/assign', [AssignmentController::class, 'assign']);
Route::get('/assignments', [AssignmentController::class, 'list']);
