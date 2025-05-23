<?php

use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [ApiController::class, 'login']);
Route::post('/register', [ApiController::class, 'register']);


Route::middleware(['auth:sanctum'])->group(function () {
    
    Route::post('/logout', [ApiController::class, 'logout']);
    Route::post('/processApi', [ApiController::class, 'savePalceBet']);
    Route::post('/getHistory', [ApiController::class, 'getHistory']);
    Route::post('/getHistoryOld', [ApiController::class, 'getHistoryOld']);
    Route::post('/getHistoryByPeriodno', [ApiController::class, 'getHistoryFilter']);
    Route::get('/getBalance', [ApiController::class, 'getBalance']);
    Route::post('/deposit', [ApiController::class, 'deposit']);

    Route::get('/getConfigMinMax', [ApiController::class, 'getConfigMinMax']);

    Route::post('/deposit', [ApiController::class, 'deposit']);
});

Route::get('/company', [ApiController::class, 'getCompany']);
Route::post('/processSave', [ApiController::class, 'processSave']);
// Route::get('/listgame', [ApiController::class, 'listGame']);
Route::post('/processVoid', [ApiController::class, 'processVoid']);
Route::get('/listGame', [ApiController::class, 'listGame']);

