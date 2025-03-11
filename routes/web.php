<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CrewListController;
use App\Http\Controllers\CrewDocumentsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::group(['middleware'=> 'auth'], function(){
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/documents/{id}', [App\Http\Controllers\HomeController::class, 'documents']);
    Route::post('/get/crew/list', [CrewListController::class, 'getCrewList']);
    Route::get('/get/crew/ranks', [CrewListController::class, 'getCrewRanks']);
    Route::post('/insert/crew/data', [CrewListController::class, 'submitCrewData']);
    Route::post('/remove/crew/data', [CrewListController::class, 'removeCrewData']);
    Route::post('/save/crew/data', [CrewListController::class, 'saveCrewData']);
    Route::post('/get/crew/docu/list', [CrewDocumentsController::class, 'getCrewDocuments']);
    Route::get('/get/crew/docu/codes', [CrewDocumentsController::class, 'getCrewDocumentsCode']);
    Route::post('/insert/crew/docu/data', [CrewDocumentsController::class, 'submitCrewDocument']);
    Route::post('/remove/crew/docu/data', [CrewDocumentsController::class, 'removeCrewDocu']);
    
});

