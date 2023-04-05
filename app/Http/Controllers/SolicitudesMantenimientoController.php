<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SolicitudesMantenimiento;
use App\Models\Clientes;
use App\Models\Equipos;

class SolicitudesMantenimientoController extends Controller
{
  public function registrarView(Request $request) {
    $correo = $request->route('correo');
    $checkCliente = Clientes::where('correo_electronico', $correo)->first();

    if (is_null($checkCliente)) {
      return abort(404);
    }

    return view('solicitudes.registrar', ['cliente' => $checkCliente]);
  }

  public function listadoView()
  {
    $solicitudes = SolicitudesMantenimiento::all();
    return view('solicitudes.listado', ['solicitudes' => $solicitudes]);
  }

  public function crear(Request $request) {
    $request->validate([
      'modelo' => 'required',
      'correo' => 'required',
    ]);

    $datos = $request->all();

    $cliente = Clientes::where('correo_electronico', $datos['correo'])->firstOrFail();

    $equipo = Equipos::create([
      'num_serie' => $datos['num_serie'],
      'marca' => $datos['marca'],
      'modelo' => $datos['modelo'],
      'fecha_compra' => $datos['fecha_compra'],
    ]);

    $fecha_solicitud = date('Y-m-d');
    $solicitud = SolicitudesMantenimiento::create([
      'id_equipo' => $equipo['id'],
      'id_cliente' => $cliente['id_cliente'],
      'fecha_solicitud' => $fecha_solicitud,
      'descripcion_problema' => $datos['descripcion_problema'],
      'estado_solicitud' => 'pendiente',
    ]);

    return redirect()->route('listado-solicitudes')->with([
      'type' => 'exito',
      'mensaje' => 'Se ha registrado la solicitud de mantenimiento',
    ]);
  }

  public function create(array $data) {
    return SolicitudesMantenimiento::create([
      'num_serie' => $data['num_serie'],
      'marca' => $data['marca'],
      'modelo' => $data['modelo'],
      'fecha_compra' => $data['fecha_compra'],
    ]);
  }
}