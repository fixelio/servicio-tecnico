<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ClientesController;
use App\Http\Controllers\SolicitudMantenimientoController;
use App\Http\Controllers\EquiposController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [ClientesController::class, 'show']);

Route::get('/registrar/cliente', [ClientesController::class, 'registrarView'])->name('clientes');

Route::post('/cliente', [ClientesController::class, 'crear'])->name('clientes.post');

Route::get('/solicitud', [SolicitudMantenimientoController::class, 'showCrear'])->name('solicitud');
Route::post('/solicitud', [SolicitudMantenimientoController::class, 'crear'])->name('solicitud.post');

Route::get('/equipo', [EquiposController::class, 'showCrear'])->name('equipo');
Route::post('/equipo', [EquiposController::class, 'crear'])->name('equipo.post');