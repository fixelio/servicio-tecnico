<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\SolicitudesMantenimiento;
use App\Models\Clientes;
use App\Models\Equipos;

class SolicitudesMantenimientoController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }
  
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

  public function editarView(Request $request, $codigo = null)
  {
    $codigo = $request->route('codigo');
    $solicitud = null;

    if ($codigo !== null) {
      $solicitud = DB::table('solicitudes_mantenimiento')
        ->join('equipos', 'solicitudes_mantenimiento.id_equipo', '=', 'equipos.id_equipo')
        ->join('clientes', 'solicitudes_mantenimiento.id_cliente', '=', 'clientes.id_cliente')
        ->select('solicitudes_mantenimiento.*', 'equipos.*', 'clientes.*')
        ->where('solicitudes_mantenimiento.codigo_solicitud', '=', $codigo)
        ->first();
    }

    return view('solicitudes.editar', [
      'solicitud' => $solicitud,
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
      'observaciones' => $datos['observaciones'],
    ]);

    return redirect()->route('listado-solicitudes')->with([
      'type' => 'exito',
      'mensaje' => 'Se ha registrado la solicitud de mantenimiento',
    ]);
  }

  public function editar(Request $request)
  {
    $request->validate([
      'num_serie' => 'required',
      'marca' => 'required',
      'modelo' => 'required',
      'fecha_compra' => 'required',
      'codigo_buscar' => 'required',
    ]);

    $datos = $request->all();
    $solicitud = SolicitudesMantenimiento::where('codigo_solicitud', $datos['codigo_buscar'])->firstOrFail();

    if ($solicitud->codigo_solicitud !== $datos['codigo_buscar']) {
      return redirect('/editar/solicitud/'.$datos['codigo_buscar'])->with([
        'type' => 'error',
        'mensaje' => 'No puedes editar el código de la solicitud'
      ]);
    }

    $equipo = Equipos::where('id_equipo', $solicitud['id_equipo'])->firstOrFail();

    Equipos::find($equipo['id_equipo'])->update([
      'num_serie' => $datos['num_serie'],
      'marca' => $datos['marca'],
      'modelo' => $datos['modelo'],
      'fecha_compra' => $datos['fecha_compra'],
    ]);

    return redirect('/editar/solicitud')->with([
      'type' => 'exito',
      'mensaje' => 'Se ha editado la solicitud',
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