<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ShoppingListController;
use App\Http\Controllers\CompletedShoppingListController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\HomeController as AdminHomeController;
use App\Http\Controllers\Admin\UserController as AdminUserController;



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

Route::get('/',[AuthController::class,'index'])->name('front.index');
Route::post('/login',[AuthController::class,'login']);

Route::prefix('/user')->group(function(){
    Route::get('/register',[UserController::class,'index']);
    Route::post('/register',[UserController::class,'register']);
});

Route::middleware(['auth'])->group(function () {
    Route::prefix('/shopping_list')->group(function () {
        Route::get('/list',[ShoppingListController::class,'list'])->name('front.list');
        Route::post('/register',[ShoppingListController::class,'register']);
        Route::delete('/delete/{shopping_list_id}',[ShoppingListController::class,'delete'])->whereNumber('shopping_list_id')->name('delete');
        Route::post('/complete/{shopping_list_id}',[ShoppingListController::class,'complete'])->whereNumber('shopping_list_id')->name('complete');
    });
    Route::get('/completed_shopping_list/list', [CompletedShoppingListController::class, 'list']);

    Route::get('/logout',[AuthController::class,'logout']);
});

Route::prefix('/admin')->group(function(){
    Route::get('',[AdminAuthController::class, 'index'])->name('Admin.index');
    Route::post('/login',[AdminAuthController::class,'login']);
    Route::middleware(['auth:admin'])->group(function(){
        Route::get('/top',[AdminHomeController::class,'top'])->name('admin.top');
        Route::get('/user/list',[AdminUserController::class,'list'])->name('admin.user.list');
        Route::get('/logout',[AdminAuthController::class,'logout']);
    });
    Route::get('/logout',[AdminAuthController::class,'logout']);
    Route::get('/admin/logout',[AdminAuthController::class,'logout']);
});