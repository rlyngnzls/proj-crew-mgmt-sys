<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CrewListController;
use App\Http\Controllers\CrewDocumentsController;
use App\Http\Controllers\DataSetupController;

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
    Route::get('/data/setup', [App\Http\Controllers\HomeController::class, 'maintenance']);
    Route::post('/get/crew/list', [CrewListController::class, 'getCrewList']);
    Route::get('/get/crew/ranks', [CrewListController::class, 'getCrewRanks']);
    Route::post('/insert/crew/data', [CrewListController::class, 'submitCrewData']);
    Route::post('/remove/crew/data', [CrewListController::class, 'removeCrewData']);
    Route::post('/save/crew/data', [CrewListController::class, 'saveCrewData']);
    Route::post('/get/crew/docu/list', [CrewDocumentsController::class, 'getCrewDocuments']);
    Route::get('/get/crew/docu/codes', [CrewDocumentsController::class, 'getCrewDocumentsCode']);
    Route::post('/insert/crew/docu/data', [CrewDocumentsController::class, 'submitCrewDocument']);
    Route::post('/remove/crew/docu/data', [CrewDocumentsController::class, 'removeCrewDocu']);
    Route::post('/edit/crew/docu/data', [CrewDocumentsController::class, 'saveCrewDocument']);

    // Data Setup
    Route::get('/get/setup/docu', [DataSetupController::class, 'getMainDocuments']);
    Route::post('/create/setup/docu/data', [DataSetupController::class, 'createMainDocu']);
    Route::post('/save/setup/docu/data', [DataSetupController::class, 'saveMainDocu']);
    Route::post('/remove/setup/docu/data', [DataSetupController::class, 'removeMainDocu']);

    Route::get('/get/setup/ranks', [DataSetupController::class, 'getMainRanks']);
    Route::post('/create/setup/ranks/data', [DataSetupController::class, 'createMainRanks']);
    Route::post('/save/setup/ranks/data', [DataSetupController::class, 'saveMainRanks']);
    Route::post('/remove/setup/ranks/data', [DataSetupController::class, 'removeMainRanks']);

    Route::get('/get/setup/users', [DataSetupController::class, 'getMainUsers']);
    Route::post('/create/setup/users/data', [DataSetupController::class, 'createMainUsers']);
    Route::post('/save/setup/users/data', [DataSetupController::class, 'saveMainUsers']);
    Route::post('/remove/setup/users/data', [DataSetupController::class, 'removeMainUsers']);

    
});

