<?php

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
Auth::routes(['verify' => true]);

Route::get('/', 'HomeController@index')->name('home');

// Accepting SPA Routes
Route::any('admin/{slug?}', 'DashboardController@index')->middleware(['auth', 'verified']);


//
//// Admin Routes
////Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'verified']], function () {
//
//    // Accepting SPA Routes
//    Route::any('{slug?}', 'DashboardController@index');
//
//    // User's Routes
//    Route::get('get/users', 'UserController@index')->name('get_users');
//    Route::get('user/create', 'UserController@create')->name('user_create');
//    Route::post('user/store', 'UserController@store')->name('user_store');
//    Route::get('user/edit/{id}', 'UserController@edit')->name('user_edit');
//    Route::put('user/update/{id}', 'UserController@update')->name('user_update');
//    Route::delete('user/destroy/{id}', 'UserController@destroy')->name('user_destroy');
//
//
//    // RoleResource's Routes
//    Route::get('get/roles', 'RoleController@index')->name('get_roles');
//    Route::post('role/store', 'RoleController@store')->name('role_store');
//    Route::put('role/update/{id}', 'RoleController@update')->name('role_update');
//    Route::delete('role/destroy/{id}', 'RoleController@destroy')->name('role_destroy');
//
//
//    // PermissionResource's Routes
//    Route::get('get/permissions', 'PermissionController@index')->name('get_permissions');
//    Route::post('permission/store', 'PermissionController@store')->name('permission_store');
//    Route::put('permission/update/{id}', 'PermissionController@update')->name('permission_update');
//    Route::delete('permission/destroy/{id}', 'PermissionController@destroy')->name('permission_destroy');
//});
