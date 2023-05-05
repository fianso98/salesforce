<?php

use App\Http\Controllers\SalesforceController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('candidates', [SalesforceController::class , 'index']);
Route::get('candidates/add', [SalesforceController::class , 'addCandidate']);
Route::post('candidates/insert', [SalesforceController::class , 'insertCandidate'])->name('insert');
Route::get('candidates/update/{id}', [SalesforceController::class , 'updateCandidate']);
Route::get('candidates/{id}', [SalesforceController::class , 'queryCandidate']);
Route::get('/', function () {
    return view('welcome');
});
