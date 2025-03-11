<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\CrewListController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/login', function (Request $request) {
    if (Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
        $user = Auth::user();
        $token = $user->createToken('MyApp')->accessToken;
        return response()->json(['token' => $token], 200);
    } else {
        return response()->json(['error' => 'Unauthorized'], 401);
    }
});

Route::middleware('auth:api')->group(function () {
    Route::get('/user', [ApiController::class, 'user']);
    Route::get('/example', [ApiController::class, 'example']);

    
});