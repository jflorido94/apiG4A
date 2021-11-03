<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Routing\RouteGroup;
use Illuminate\Support\Facades\Route;

use App\Models\User;

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


// Route::prefix('users')->group(function () {
//     Route::get('/',         [UserController::class, 'index'])   ->name('users.index');
//     Route::get('/{user}',     [UserController::class, 'show'])    ->name('user.show');
// });

Route::apiResource('users', UserController::class);


