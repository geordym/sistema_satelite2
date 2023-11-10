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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::post('/logout', [App\Http\Controllers\UserController::class, 'logout'])->name('admin.logout');


Route::get('/admin/dashboard', [App\Http\Controllers\UserController::class, 'dashboard'])->name('admin.dashboard');
Route::get('/admin/profile', [App\Http\Controllers\UserController::class, 'profile'])->name('admin.profile');
Route::get('/admin/users', [App\Http\Controllers\UserController::class, 'users'])->name('admin.users');
Route::post('/admin/users', [App\Http\Controllers\UserController::class, 'create'])->name('admin.users.create');


/*CANALES ROUTES */
Route::get('/admin/canales/xml', [App\Http\Controllers\CanalController::class, 'generarXML'])->name('admin.canales.xml');
Route::delete('/admin/canales/delete/{id}', [App\Http\Controllers\CanalController::class, 'destroy'])->name('admin.canales.delete');
Route::get('/admin/canales', [App\Http\Controllers\CanalController::class, 'index'])->name('admin.canales');
Route::post('/admin/canales', [App\Http\Controllers\CanalController::class, 'create'])->name('admin.canales.create');
Route::get('/admin/canales/edit/{id}', [App\Http\Controllers\CanalController::class, 'edit'])->name('admin.canales.edit');
Route::put('/admin/canales/{id}', [App\Http\Controllers\CanalController::class, 'update'])->name('admin.canales.update');


Route::get('canales/canales.xml', [App\Http\Controllers\CanalController::class, 'retornarXML'])->name('admin.canales.retornar');




/*CLIENTS ROUTES */
Route::get('/admin/clients', [App\Http\Controllers\ClientController::class, 'index'])->name('admin.clients');
Route::post('/admin/clients', [App\Http\Controllers\ClientController::class, 'create'])->name('admin.clients.create');

/*CHANGE PASSWORD ROUTES */
Route::get('/change-password', [App\Http\Controllers\ChangePasswordController::class, 'showChangePasswordForm'])->name('password.change');
Route::post('/change-password', [App\Http\Controllers\ChangePasswordController::class, 'changePassword']);
