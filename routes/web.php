<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ClientesController;
use App\Http\Controllers\SolicitudesMantenimientoController;
use App\Http\Controllers\TecnicosController;

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

Route::get('/', [SolicitudesMantenimientoController::class, 'listadoView']);

Route::get('/clientes', [ClientesController::class, 'index'])->name('clientes');
Route::get('/registrar/cliente', [ClientesController::class, 'registrarView'])->name('registrar-cliente');
Route::get('/editar/cliente/{correo?}', [ClientesController::class, 'editarView'])->name('editar-cliente');
Route::post('/cliente', [ClientesController::class, 'crear'])->name('cliente.post');
Route::post('/editar/cliente', [ClientesController::class, 'editar'])->name('cliente.put');

Route::get('/solicitudes', [SolicitudesMantenimientoController::class, 'listadoView'])->name('listado-solicitudes');
Route::get('/registrar/solicitud/cliente/{correo}', [SolicitudesMantenimientoController::class, 'registrarView'])->name('registrar-solicitud');
Route::get('/solicitudes/cliente/{correo}', [SolicitudesMantenimientoController::class, 'listadoClienteView'])->name('solicitudes-cliente');
Route::get('/editar/solicitud/{codigo?}', [SolicitudesMantenimientoController::class, 'editarView'])->name('editar-solicitud');
Route::get('/solicitud/detalles/{correo?}', [
	SolicitudesMantenimientoController::class, 'detalles'
])->name('detalles-solicitud');

Route::post('/solicitud', [SolicitudesMantenimientoController::class, 'crear'])->name('solicitud.post');
Route::post('/editar/solicitud', [SolicitudesMantenimientoController::class, 'editar'])->name('solicitud.put');
Route::post('/editar/solicitud/estado', [SolicitudesMantenimientoController::class, 'cambiarEstado'])->name('estado-solicitud.put');

Route::get('/tecnicos', [TecnicosController::class, 'listadoView'])->name('listado-tecnicos');
Route::get('/registrar/tecnico', [TecnicosController::class, 'registrarView'])->name('registrar-tecnico');
Route::get('/editar/tecnico/{correo?}', [TecnicosController::class, 'editarView'])->name('editar-tecnico');
Route::get('/solicitudes/tecnico/{correo?}', [TecnicosController::class, 'trabajoAsignado'])->name('solicitudes-tecnico');
Route::post('/tecnico', [TecnicosController::class, 'crear'])->name('tecnico.post');
Route::post('/editar/tecnico', [TecnicosController::class, 'editar'])->name('tecnico.put');

Auth::routes();
