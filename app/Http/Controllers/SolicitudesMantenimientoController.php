<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\SolicitudesMantenimiento;
use App\Models\Clientes;
use App\Models\Equipos;

class SolicitudesMantenimientoController extends Controller
{
  public function registrarView(Request $request) {
    $correo = $request->route('correo');
    $checkCliente = Clientes::where('correo_electronico', $correo)->firstOrFail();

    return view('solicitudes.registrar', ['cliente' => $checkCliente]);
  }

  public function listadoView()
  {
    $solicitudes = DB::table('solicitudes_mantenimiento')
      ->join('equipos', 'solicitudes_mantenimiento.id_equipo', '=', 'equipos.id_equipo')
      ->join('clientes', 'solicitudes_mantenimiento.id_cliente', '=', 'clientes.id_cliente')
      ->select('solicitudes_mantenimiento.*', 'equipos.*', 'clientes.*')
      ->where('solicitudes_mantenimiento.estado_solicitud', '!=', 'terminado')
      ->get();

    return view('solicitudes.listado', ['solicitudes' => $solicitudes]);
  }

  public function listadoClienteView(Request $request)
  {
    $correo = $request->route('correo');

    $cliente = Clientes::where('correo_electronico', $correo)->firstOrFail();
    $solicitudes = SolicitudesMantenimiento::join('equipos', function($join) {
      $join->on('solicitudes_mantenimiento.id_equipo', '=', 'equipos.id_equipo');
      })
      ->join('clientes', function($join) use(&$cliente) {
        $join
          ->on('solicitudes_mantenimiento.id_cliente', '=', 'clientes.id_cliente')
          ->where('clientes.id_cliente', '=', $cliente['id_cliente']);
      })
      ->get();

    return view('solicitudes.cliente', [
      'solicitudes' => $solicitudes,
      'cliente' => $cliente
    ]);
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
    $cantidad = SolicitudesMantenimiento::whereDate('created_at', '=', $fecha_solicitud)->count();

    $codigo = str_pad("".$cantidad, 3, "0", STR_PAD_LEFT);

    $codigo_solicitud = date('Y')."-".$codigo.date('m').date('d');
    $solicitud = SolicitudesMantenimiento::create([
      'id_equipo' => $equipo['id'],
      'id_cliente' => $cliente['id_cliente'],
      'codigo_solicitud' => $codigo_solicitud,
      'fecha_solicitud' => $fecha_solicitud,
      'descripcion_problema' => $datos['descripcion_problema'],
      'estado_solicitud' => 'pendiente',
    ]);

    return redirect()->route('listado-solicitudes')->with([
      'type' => 'exito',
      'mensaje' => 'Se ha registrado la solicitud de mantenimiento',
    ]);
  }

  public function cambiarEstado(Request $request) {
    $request->validate([
      'codigo_solicitud' => 'required',
      'estado_solicitud' => 'required',
    ]);

    $data = $request->all();

    $solicitud = SolicitudesMantenimiento::where('codigo_solicitud', $data['codigo_solicitud'])->firstOrFail();
    SolicitudesMantenimiento::find($solicitud['id_solicitud'])->update([
      'estado_solicitud' => $data['estado_solicitud']
    ]);

    return redirect()->route('listado-solicitudes')->with([
      'type' => 'exito',
      'mensaje' => 'Se ha modificado el estado de la solicitud',
    ]);
  }
}