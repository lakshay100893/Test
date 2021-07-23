<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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
Auth::routes();

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->intended('/home')->with('success','You Are Already loggedin');
    }
    return view('welcome');
});


Route::middleware(['auth'])->group(function () {

    /* Dashboard Page  */
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    /* Side menu Hide And Show */
    Route::post('/headerFix', [App\Http\Controllers\HomeController::class, 'headerFix'])->name('headerFix');

    /* Profile Page Open  */
    Route::get('/profile', [App\Http\Controllers\Profile::class, 'show'])->name('profile');

    /* Profile Image Update */
    Route::post('/profile', [App\Http\Controllers\Profile::class, 'update'])->name('profile');

    /* User Profile View */
    Route::get('/profile/{id}', [App\Http\Controllers\Profile::class, 'show'])->name('Userprofile');

    /* User Listing Page  */
    Route::get('/Userlist', [App\Http\Controllers\User::class, 'index'])->name('Userlist');

    /* User Listing getting by Datatable */
    Route::get('/lsiting', [App\Http\Controllers\User::class, 'listing'])->name('lsiting');
    
    
    
    Route::get('/role', [App\Http\Controllers\RoleController::class, 'index'])->name('role');



});
