<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ClientesController;
use App\Http\Controllers\SolicitudesMantenimientoController;
use App\Http\Controllers\EquiposController;
use App\Http\Controllers\OrdenesController;
use App\Http\Controllers\HomeController;

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

Route::get('/', [ClientesController::class, 'index']);

Route::get('/clientes', [ClientesController::class, 'index'])->name('clientes');
Route::get('/registrar/cliente', [ClientesController::class, 'registrarView'])->name('registrar-cliente');
Route::post('/cliente', [ClientesController::class, 'crear'])->name('cliente.post');

Route::get('/solicitudes', [SolicitudesMantenimientoController::class, 'listadoView'])->name('listado-solicitudes');
Route::get('/registrar/solicitud/cliente/{correo}', [SolicitudesMantenimientoController::class, 'registrarView'])->name('registrar-solicitud');
Route::get('/solicitudes/cliente/{correo}', [SolicitudesMantenimientoController::class, 'listadoClienteView'])->name('solicitudes-cliente');
Route::post('/solicitud', [SolicitudesMantenimientoController::class, 'crear'])->name('solicitud.post');
Route::post('/solicitud/${codigo}/estado/${estado}', [SolicitudesMantenimientoController::class, 'cambiarEstado'])->name('estado-solicitud.update');


Auth::routes();
