<?php

use App\Http\Controllers\AgencieController;
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
        return redirect()->intended('home')->with('success', 'You Are Already loggedin');
    }
    return view('welcome');
});


Route::middleware(['auth'])->group(function () {

    /* Dashboard Page  */
    Route::get('home', [HomeController::class, 'index'])->name('home');

    /* Side menu Hide And Show */
    Route::post('headerFix', [HomeController::class, 'headerFix'])->name('headerFix');

    Route::group(['prefix' => 'profile'], function () {
        
        Route::group(['as' => 'profile'], function () {
            /* Profile Page Open  */
            Route::get('/', [Profile::class, 'show']);

            /* Profile Image Update */
            Route::post('/', [Profile::class, 'update']);
        });
        /* User Profile View */
        Route::get('{id}', [Profile::class, 'show'])->middleware('can:User View')->name('Userprofile');
    });
    /* User Listing Page And Getting by Ajax  */
    Route::get('Userlist', [ControllersUser::class, 'index'])->middleware('can:User List')->name('Userlist');


    Route::group(['middleware' => ['can:User Edit'], 'prefix' => 'UserEdit', 'as' => 'UserEdit'], function () {

        /* User Edit Page  */
        Route::get('{id}', [ControllersUser::class, 'edit']);

        /* User Edit Page Submit */
        Route::post('{id}', [ControllersUser::class, 'Update']);
    });


    Route::group(['middleware' => ['can:Add Role']], function () {

        /* Role Page listing And Listing Using Ajax */
        Route::get('role', [RoleController::class, 'index'])->name('role');

        /* Role Add by Ajax */
        Route::post('role', [RoleController::class, 'store'])->name('role');

        /* Role Edit */
        Route::post('roleEdit', [RoleController::class, 'update'])->name('roleEdit');

        /* Get Assigned Permission To role  */
        Route::post('getPermisssion', [RoleController::class, 'getPermssion'])->name('permission.get');

        /* Assign Permission To role  */
        Route::post('setPermisssion', [RoleController::class, 'assignPermission'])->name('permission.set');
    });


    Route::group(['middleware' => ['can:Add Permission']], function () {

        Route::group(['as' => 'permission'], function () {

            /* Permission page With Listing */
            Route::get('permission', [Permission::class, 'index']);

            /* Add Permission by Ajax */
            Route::post('permission', [Permission::class, 'store']);
        });

        /* Edit Permission by Ajax */
        Route::post('permissionEdit', [Permission::class, 'update'])->name('permissionEdit');
    });

    /* Permission page With Listing */
    Route::get('agencie', [AgencieController::class, 'index'])->name('agencie');

    Route::group(['as' => 'addagencie'], function () {

        /* ADD Form Open Agencie   */
        Route::get('addagencie', [AgencieController::class, 'create']);

        /* ADD Form Submit Agencie   */
        Route::post('addagencie', [AgencieController::class, 'store']);
    });

    Route::group(['prefix' => 'editagencie', 'as' => 'editagencie'], function () {

        Route::get('{agencie}', [AgencieController::class, 'edit']);

        Route::post('{agencie}', [AgencieController::class, 'update']);

        Route::delete('{agencie}', [AgencieController::class, 'imageDelete']);
    });
});
