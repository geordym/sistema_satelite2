<?php

use App\Http\Controllers\CajaController;
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

Route::match(['get', 'head'], '/', function () {
    // Redirige a la ruta '/home'
    return redirect('/home');
});

Auth::routes();


Route::middleware('auth')->group(function () {

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::post('/logout', [App\Http\Controllers\UserController::class, 'logout'])->name('admin.logout');

    Route::get('/admin/dashboard', [App\Http\Controllers\UserController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/profile', [App\Http\Controllers\UserController::class, 'profile'])->name('admin.profile');
    Route::get('/admin/users', [App\Http\Controllers\UserController::class, 'users'])->name('admin.users');
    Route::post('/admin/users', [App\Http\Controllers\UserController::class, 'create'])->name('admin.users.create');

    Route::resource('/admin/entradas', App\Http\Controllers\EntradaController::class)->only([
        'index', 'create', 'store', 'show', 'edit', 'update', 'destroy'
    ])->names([
        'index' => 'admin.entradas.index',
        'create' => 'admin.entradas.create',
        'store' => 'admin.entradas.store',
        'show' => 'admin.entradas.show',
        'edit' => 'admin.entradas.edit',
        'update' => 'admin.entradas.update',
        'destroy' => 'admin.entradas.destroy',
    ]);

    Route::resource('/admin/procesos', App\Http\Controllers\ProcesoController::class)->only([
        'index', 'create', 'store', 'show', 'edit', 'update', 'destroy'
    ])->names([
        'index' => 'admin.procesos.index',
        'create' => 'admin.procesos.create',
        'store' => 'admin.procesos.store',
        'show' => 'admin.procesos.show',
        'edit' => 'admin.procesos.edit',
        'update' => 'admin.procesos.update',
        'destroy' => 'admin.procesos.destroy',
    ]);

Route::get('/admin/procesos/{entrada_id}/process', [App\Http\Controllers\ProcesoController::class, 'process'])
    ->name('admin.procesos.process');


    Route::resource('/admin/salidas', App\Http\Controllers\SalidaController::class)->only([
        'index', 'create', 'store', 'show', 'edit', 'update', 'destroy'
    ])->names([
        'index' => 'admin.salidas.index',
        'create' => 'admin.salidas.create',
        'store' => 'admin.salidas.store',
        'show' => 'admin.salidas.show',
        'edit' => 'admin.salidas.edit',
        'update' => 'admin.salidas.update',
        'destroy' => 'admin.salidas.destroy',
    ]);

    Route::post('/admin/pagos/payment-process', [App\Http\Controllers\PagoController::class, 'create_payment'])
    ->name('admin.pagos.payment_process');


    Route::get('/admin/pagos/payment-download/{id}', [App\Http\Controllers\PagoController::class, 'download_payment'])
    ->name('admin.pagos.download_payment');


    Route::resource('/admin/pagos', App\Http\Controllers\PagoController::class)->only([
        'index', 'create', 'store', 'show', 'edit', 'update', 'destroy'
    ])->names([
        'index' => 'admin.pagos.index',
        'create' => 'admin.pagos.create',
        'store' => 'admin.pagos.store',
        'show' => 'admin.pagos.show',
        'edit' => 'admin.pagos.edit',
        'update' => 'admin.pagos.update',
        'destroy' => 'admin.pagos.destroy',
    ]);









    /*CHANGE PASSWORD ROUTES */
    Route::get('/change-password', [App\Http\Controllers\ChangePasswordController::class, 'showChangePasswordForm'])->name('password.change');
    Route::post('/change-password', [App\Http\Controllers\ChangePasswordController::class, 'changePassword']);


});
