<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BanReasonController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ConditionController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//---- Login---
Route::post('login', [AuthController::class, 'login']);
Route::post('signup', [AuthController::class, 'signup']);

Route::group([
    'middleware' => 'auth:api'
], function () {
    Route::get('logout', [AuthController::class, 'logout']);
    Route::get('me', [AuthController::class, 'user']);
    // Route::post('me', [AuthController::class, 'user']);
    // Route::delete('me', [AuthController::class, 'user']);
});


//---- Usuarios ---
Route::prefix('users')->group(function () {
    Route::get('/', [UserController::class, 'index']);
    Route::get('/{user}', [UserController::class, 'show']);
    // --- Self only
    Route::post('/{user}', [UserController::class, 'update'])->middleware('auth:api');
    Route::delete('/{user}', [UserController::class, 'destroy'])->middleware('auth:api');
});

//--- Condiciones de productos ---
Route::prefix('conditions')->group(function () {
    Route::get('/', [ConditionController::class, 'index']);
    // --- Admin only
    Route::post('/', [ConditionController::class, 'store'])->middleware('auth:api');
    Route::get('/{condition}', [ConditionController::class, 'show'])->middleware('auth:api');
    Route::post('/{condition}', [ConditionController::class, 'update'])->middleware('auth:api');
    Route::delete('/{condition}', [ConditionController::class, 'destroy'])->middleware('auth:api');
});

//--- Etiquetas de productos ---
Route::prefix('tags')->group(function () {
    Route::get('/', [TagController::class, 'index']);
    // --- Admin only
    Route::post('/', [TagController::class, 'store'])->middleware('auth:api');
    Route::get('/{tag}', [TagController::class, 'show'])->middleware('auth:api');
    Route::post('/{tag}', [TagController::class, 'update'])->middleware('auth:api');
    Route::delete('/{tag}', [TagController::class, 'destroy'])->middleware('auth:api');
});

//--- Estado de la transaccion ---
Route::prefix('states')->group(function () {
    Route::get('/', [StateController::class, 'index']);
    // --- Admin only
    Route::post('/', [StateController::class, 'store'])->middleware('auth:api');
    Route::get('/{state}', [StateController::class, 'show'])->middleware('auth:api');
    Route::post('/{state}', [StateController::class, 'update'])->middleware('auth:api');
    Route::delete('/{state}', [StateController::class, 'destroy'])->middleware('auth:api');
});

//---- Productos ---
Route::prefix('products')->group(function () {
    Route::get('/', [ProductController::class, 'index']);
    Route::get('/{product}', [ProductController::class, 'show']);
    // ---- Auth only
    Route::post('/', [ProductController::class, 'store'])->middleware('auth:api');
    // ---- Self only
    Route::post('/{product}', [ProductController::class, 'update'])->middleware('auth:api');
    Route::delete('/{product}', [ProductController::class, 'destroy'])->middleware('auth:api');
});


//--- Transacciones ---
Route::prefix('transactions')->group(function () {
    // --- Admin only
    Route::get('/', [TransactionController::class, 'index'])->middleware('auth:api');
    // --- Auth only
    Route::post('/', [TransactionController::class, 'store'])->middleware('auth:api');
    // --- Self only
    Route::get('/{transaction}', [TransactionController::class, 'show'])->middleware('auth:api');
    Route::post('/{transaction}', [TransactionController::class, 'update'])->middleware('auth:api');
    Route::delete('/{transaction}', [TransactionController::class, 'destroy'])->middleware('auth:api');
});




//--- Review ---
Route::prefix('reviews')->group(function () {
    // Route::get('/', [ReviewController::class, 'index']);
    // --- Auth only
    Route::post('/', [ReviewController::class, 'store'])->middleware('auth:api');
    Route::get('/{review}', [ReviewController::class, 'show'])->middleware('auth:api');
    Route::post('/{review}', [ReviewController::class, 'update'])->middleware('auth:api');
});


//--- Motivos de baneo ---
Route::prefix('ban-reasons')->group(function () {
    Route::get('/', [BanReasonController::class, 'index']);
    //--- Admin only ----
    Route::post('/', [BanReasonController::class, 'store'])->middleware('auth:api');
    Route::post('/{banReason}', [BanReasonController::class, 'update'])->middleware('auth:api');
    Route::delete('/{banReason}', [BanReasonController::class, 'destroy'])->middleware('auth:api');
});


//--- Reportes ---
Route::prefix('reports')->group(function () {
    // --- Mods only
    Route::get('/', [ReportController::class, 'index'])->middleware('auth:api');
    // --- Auth only
    Route::post('/', [ReportController::class, 'store'])->middleware('auth:api');
    // --- Mods y self
    Route::get('/{report}', [ReportController::class, 'show'])->middleware('auth:api');
    Route::post('/{report}', [ReportController::class, 'update'])->middleware('auth:api');
    Route::delete('/{report}', [ReportController::class, 'destroy'])->middleware('auth:api');
});


//--- Chats ---
Route::prefix('chats')->group(function () {
    // --- Auth only
    Route::get('/', [ChatController::class, 'index'])->middleware('auth:api'); // las del usuario registrado
    Route::post('/', [ChatController::class, 'store'])->middleware('auth:api'); // debe hacerse al mandar el primer mensaje

    Route::get('/{chat}', [ChatController::class, 'show'])->middleware('auth:api');
    // Route::delete('/{chat}', [ChatController::class, 'destroy']);
});


//--- Mensajes ---
Route::prefix('messages')->group(function () {
    // Route::get('/', [MessageController::class, 'index']);
    // --- Auth only
    Route::post('/', [MessageController::class, 'store'])->middleware('auth:api');
    // --- Self only
    Route::delete('/{message}', [MessageController::class, 'destroy'])->middleware('auth:api');
});
