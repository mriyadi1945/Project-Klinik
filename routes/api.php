<?php

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\AntreanController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group([
        'prefix' => ''
    ],function () {
        if (Request::isMethod('get')) {
            //Auth
            Route::get('auth', [AuthController::class, 'getToken']);
            //Antrian
            Route::get('antrean/status/{kode_poli}/{tanggalperiksa}', [AntreanController::class, 'statusAntrean']);
            Route::get('antrean/sisapeserta/{nomorkartu_jkn}/{kode_poli}/{tanggalperiksa}', [AntreanController::class, 'sisaAntrean']);
        }
        if (Request::isMethod('post')) {
            //Antrian
            Route::post('create', [AntreanController::class, 'create']);
            Route::post('antrean', [AntreanController::class, 'getAntrean']);
        }
        if (Request::isMethod('put')) {
            Route::put('antrean/batal', [AntreanController::class, 'batal']);
        }
});
