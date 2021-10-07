<?php

use App\Http\Controllers\PatientController;
use Illuminate\Support\Facades\Route;

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

Route::get('/',[PatientController::class,'index'])->name('/');


Route::get('/create',[PatientController::class,'create'])->name('save');

Route::post('/create',[PatientController::class,'save'])->name('save');
Route::get('/department',[PatientController::class,'deapartment'])->name('department');