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



/*PLANES DE SERVICIO ROUTES */
Route::get('/admin/planes', [App\Http\Controllers\PlanController::class, 'index'])->name('admin.planes');
Route::post('/admin/planes', [App\Http\Controllers\PlanController::class, 'create'])->name('admin.planes.create');

/*TARIFAS ROUTES */
Route::get('/admin/tarifas', [App\Http\Controllers\TarifaController::class, 'index'])->name('admin.tarifas');
Route::post('/admin/tarifas', [App\Http\Controllers\TarifaController::class, 'create'])->name('admin.tarifas.create');

/*CLIENTS ROUTES */
Route::get('/admin/clients', [App\Http\Controllers\ClientController::class, 'index'])->name('admin.clients');
Route::post('/admin/clients', [App\Http\Controllers\ClientController::class, 'create'])->name('admin.clients.create');
