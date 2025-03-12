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

    Route::get('/crew/list', [ApiController::class, 'getCrewList']);
    Route::post('/insert/crew/data', [ApiController::class, 'submitCrewData']);
    Route::post('/save/crew/data', [ApiController::class, 'saveCrewData']);
    Route::post('/remove/crew/data', [ApiController::class, 'removeCrewData']);

    Route::post('/crew/docu/list', [ApiController::class, 'getCrewDocuments']);
    Route::post('/insert/crew/docu/data', [ApiController::class, 'submitCrewDocument']);
    Route::post('/remove/crew/docu/data', [ApiController::class, 'removeCrewDocu']);
    Route::post('/edit/crew/docu/data', [ApiController::class, 'saveCrewDocument']);

    Route::get('/setup/docu', [ApiController::class, 'getMainDocuments']);
    Route::post('/create/setup/docu/data', [ApiController::class, 'createMainDocu']);
    Route::post('/save/setup/docu/data', [ApiController::class, 'saveMainDocu']);
    Route::post('/remove/setup/docu/data', [ApiController::class, 'removeMainDocu']);

    Route::get('/setup/ranks', [ApiController::class, 'getMainRanks']);
    Route::post('/create/setup/ranks/data', [ApiController::class, 'createMainRanks']);
    Route::post('/save/setup/ranks/data', [ApiController::class, 'saveMainRanks']);
    Route::post('/remove/setup/ranks/data', [ApiController::class, 'removeMainRanks']);

    Route::get('/setup/users', [ApiController::class, 'getMainUsers']);
    Route::post('/create/setup/users/data', [ApiController::class, 'createMainUsers']);
    Route::post('/save/setup/users/data', [ApiController::class, 'saveMainUsers']);
    Route::post('/remove/setup/users/data', [ApiController::class, 'removeMainUsers']);

    
});