<?php

use App\Http\Controllers\ActividadController;
use App\Http\Controllers\CajaController;
use App\Http\Controllers\OperadorController;
use App\Http\Controllers\ProcesoController;
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

Route::get('/', function () {
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
        'index',
        'create',
        'store',
        'show',
        'edit',
        'update',
        'destroy'
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
        'index',
        'create',
        'store',
        'show',
        'edit',
        'update',
        'destroy'
    ])->names([
        'index' => 'admin.procesos.index',
        'create' => 'admin.procesos.create',
        'store' => 'admin.procesos.store',
        'show' => 'admin.procesos.show',
        'edit' => 'admin.procesos.edit',
        'update' => 'admin.procesos.update',
        'destroy' => 'admin.procesos.destroy',
    ]);

    Route::get('/admin/procesos/create/rapido', [ProcesoController::class, 'create_rapido'])->name('admin.procesos.create_rapido');
    Route::get('/admin/procesos/view/visualizar-creados-recientemente', [ProcesoController::class, 'visualizar_creados_recientemente'])->name('admin.procesos.visualizar_creados_recientemente');



    Route::get('/admin/procesos/{entrada_id}/process', [App\Http\Controllers\ProcesoController::class, 'process'])
        ->name('admin.procesos.process');


    Route::resource('/admin/salidas', App\Http\Controllers\SalidaController::class)->only([
        'index',
        'create',
        'store',
        'show',
        'edit',
        'update',
        'destroy'
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
        'index',
        'create',
        'store',
        'show',
        'edit',
        'update',
        'destroy'
    ])->names([
        'index' => 'admin.pagos.index',
        'create' => 'admin.pagos.create',
        'store' => 'admin.pagos.store',
        'show' => 'admin.pagos.show',
        'edit' => 'admin.pagos.edit',
        'update' => 'admin.pagos.update',
        'destroy' => 'admin.pagos.destroy',
    ]);



    Route::get('/admin/actividades', [ActividadController::class, 'index'])->name('admin.actividades.index');
    Route::get('/admin/actividades/create', [ActividadController::class, 'create'])->name('admin.actividades.create');
    Route::post('/admin/actividades', [ActividadController::class, 'store'])->name('admin.actividades.store');
    Route::get('/admin/actividades/{actividad}', [ActividadController::class, 'show'])->name('admin.actividades.show');
    Route::get('/admin/actividades/{actividad}/edit', [ActividadController::class, 'edit'])->name('admin.actividades.edit');
    Route::put('/admin/actividades/{actividad}', [ActividadController::class, 'update'])->name('admin.actividades.update');
    Route::delete('/admin/actividades/{actividad}', [ActividadController::class, 'destroy'])->name('admin.actividades.destroy');


    Route::get('/admin/operadores', [OperadorController::class, 'index'])->name('admin.operadores.index');
    Route::get('/admin/operadores/create', [OperadorController::class, 'create'])->name('admin.operadores.create');
    Route::post('/admin/operadores', [OperadorController::class, 'store'])->name('admin.operadores.store');
    Route::get('/admin/operadores/{operador}', [OperadorController::class, 'show'])->name('admin.operadores.show');
    Route::get('/admin/operadores/{operador}/edit', [OperadorController::class, 'edit'])->name('admin.operadores.edit');
    Route::put('/admin/operadores/{operador}', [OperadorController::class, 'update'])->name('admin.operadores.update');
    Route::delete('/admin/operadores/{operador}', [OperadorController::class, 'destroy'])->name('admin.operadores.destroy');






    /*CHANGE PASSWORD ROUTES */
    Route::get('/change-password', [App\Http\Controllers\ChangePasswordController::class, 'showChangePasswordForm'])->name('password.change');
    Route::post('/change-password', [App\Http\Controllers\ChangePasswordController::class, 'changePassword']);
});
