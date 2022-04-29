<?php

use App\Http\Controllers\api\DropdownController;
use App\Http\Controllers\auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserMenuController;
use App\Http\Controllers\UserRoleController;
use Illuminate\Support\Facades\Auth;
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

Route::middleware(['auth'])->group(function ()
{
    Route::get('/', [DashboardController::class,'index']);

    Route::get('/master/roles/get-all-data', [RoleController::class,'getAllData']);
    Route::get('/master/roles/get-role-tree', [RoleController::class,'getRoleTree']);
    Route::resource('/master/roles', RoleController::class);

    Route::resource('/user/role', UserRoleController::class);

    Route::resource('/user/menus', UserMenuController::class);

    Route::get('/master/menus/get-menu-tree', [MenuController::class,'getMenuTree']);

    Route::get('/users/get-all-data',[UserController::class,'getAllData']);

    Route::get('/user/profile',[UserController::class,'myProfile']);
    Route::post('/user/profile',[UserController::class,'myProfileUpdate']);
    Route::post('/user/profile/change-password',[UserController::class,'changePassword']);

    Route::put('/master/users/update-profile/{user}', [UserController::class, 'updateProfile']);
    Route::resource('/master/users', UserController::class);

    Route::get('/utils/dropdown/get-role',[DropdownController::class, 'role']);

    Route::post('/logout', [AuthController::class,'logout']);
});

Route::middleware(['guest'])->group(function ()
{
    Route::get('/login', [AuthController::class,'index'])->name('login');
    Route::post('/login', [AuthController::class,'authenticate']);
});


