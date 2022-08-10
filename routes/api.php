<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\UserAuthController;

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

// Login Route
Route::post('login', [UserAuthController::class, 'login'])->name('login');


Route::group(
    [
        'prefix' => 'auth'
    ],
    function () {
        Route::group(
            [
                'middleware' => 'auth:api'
            ],
            function () {
                // Get user logged info
                Route::get(
                    '/user',
                    function (Request $request) {
                        return $request->user();
                    }
                );
                // Do Logout User
                Route::get('logout', [UserAuthController::class, 'logout']);
            }
        );
    }
);
