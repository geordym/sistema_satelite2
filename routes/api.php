<?php

use App\Http\Controllers\ProcesoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/pagos/info-download/{id}', [App\Http\Controllers\PagoController::class, 'getPaymentData']);

Route::post('/admin/procesos/create/rapido', [ProcesoController::class, 'store_json'])->name('admin.procesos.store_json');





