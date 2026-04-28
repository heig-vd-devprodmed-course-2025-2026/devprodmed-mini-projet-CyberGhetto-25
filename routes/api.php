<?php

use App\Http\Controllers\Api\v1\ApiPostController;
use App\Http\Controllers\Api\v1\ApiEventController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('v1/posts', ApiPostController::class)
    ->middlewareFor(['index', 'show'], ['auth:sanctum', 'abilities:posts:read'])
    ->middlewareFor(['store'], ['auth:sanctum', 'abilities:posts:create'])
    ->middlewareFor(['update'], ['auth:sanctum', 'abilities:posts:update'])
    ->middlewareFor(['destroy'], ['auth:sanctum', 'abilities:posts:delete']);

Route::apiResource('v1/events', ApiEventController::class)
    ->middlewareFor(['index', 'show'], ['auth:sanctum', 'abilities:events:read'])
    ->middlewareFor(['store'], ['auth:sanctum', 'abilities:events:create'])
    ->middlewareFor(['update'], ['auth:sanctum', 'abilities:events:update'])
    ->middlewareFor(['destroy'], ['auth:sanctum', 'abilities:events:delete']);