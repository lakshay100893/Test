<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Profile;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\Permission;
use App\Http\Controllers\User as ControllersUser;
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
        return redirect()->intended('/home')->with('success', 'You Are Already loggedin');
    }
    return view('welcome');
});


Route::middleware(['auth'])->group(function () {

    /* Dashboard Page  */
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    /* Side menu Hide And Show */
    Route::post('/headerFix', [HomeController::class, 'headerFix'])->name('headerFix');

    /* Profile Page Open  */
    Route::get('/profile', [Profile::class, 'show'])->name('profile');

    /* Profile Image Update */
    Route::post('/profile', [Profile::class, 'update'])->name('profile');

    /* User Profile View */
    Route::get('/profile/{id}', [Profile::class, 'show'])->middleware('can:User View')->name('Userprofile');

    /* User Listing Page And Getting by Ajax  */
    Route::get('/Userlist', [ControllersUser::class, 'index'])->middleware('can:User List')->name('Userlist');

    
    Route::group(['middleware' => ['can:User Edit']], function () {

        /* User Edit Page  */
        Route::get('/UserEdit/{id}', [ControllersUser::class, 'edit'])->name('UserEdit');

        /* User Edit Page Submit */
        Route::post('/UserEdit/{id}', [ControllersUser::class, 'Update'])->name('UserEdit');

    });


    Route::group(['middleware' => ['can:Add Role']], function () {

        /* Role Page listing And Listing Using Ajax */
        Route::get('/role', [RoleController::class, 'index'])->name('role');

        /* Role Add by Ajax */
        Route::post('/role', [RoleController::class, 'store'])->name('role');

        /* Role Edit */
        Route::PUT('/role', [RoleController::class, 'update'])->name('role');

        /* Get Assigned Permission To role  */
        Route::post('/getPermisssion', [RoleController::class, 'getPermssion'])->name('permission.get');

        /* Assign Permission To role  */
        Route::post('/setPermisssion', [RoleController::class, 'assignPermission'])->name('permission.set');

    });


    Route::group(['middleware' => ['can:Add Permission']], function () {

        /* Permission page With Listing */
        Route::get('/permission', [Permission::class, 'index'])->name('permission');

        /* Add Permission by Ajax */
        Route::post('/permission', [Permission::class, 'store'])->name('permission');
        
    });
    
});
