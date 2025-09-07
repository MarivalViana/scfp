<?php

// routes/api.php
use App\Http\Controllers\ClassificacaoGastoController;
use App\Http\Controllers\GastoController;
use App\Http\Controllers\TipoGastoController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// Rotas de autenticação
Route::post('/login', [AuthController::class, 'login']);

// Grupo de rotas protegidas pelo Sanctum
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::apiResource('gasto', GastoController::class);
    Route::apiResource('tipo-gasto', TipoGastoController::class);
    Route::apiResource('classificacao-gasto', ClassificacaoGastoController::class);
});
