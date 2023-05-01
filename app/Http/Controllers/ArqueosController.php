<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\SolicitudesMantenimiento;
use App\Models\Tecnicos;

class ArqueosController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }

  public function listadoView(Request $request)
  {
    $ordenes = DB::Table('solicitudes_mantenimiento')
      ->join('historial_mantenimiento', 'historial_mantenimiento.id_solicitud', '=', 'solicitudes_mantenimiento.id_solicitud')
      ->join('facturas', 'facturas.id_historial', '=', 'historial_mantenimiento.id_historial');

    if ($request->query('tecnico') !== null && $request->query('tecnico') !== 'all') {
      $tecnico = Tecnicos::where('id_tecnico', $request->query('tecnico'))->firstOrFail();
      $ordenes->join('solicitudes_tecnicos', 'solicitudes_tecnicos.id_solicitud', '=', 'solicitudes_mantenimiento.id_solicitud')
      ->where('solicitudes_tecnicos.id_tecnico', $tecnico['id_tecnico']);
    }

    if ($request->query('desde') !== null && $request->query('hasta') !== null) {
      $ordenes->join('equipos', 'equipos.id_equipo', '=', 'solicitudes_mantenimiento.id_equipo')
        ->whereBetween('equipos.fecha_compra', [
          $request->query('desde'),
          $request->query('hasta')
        ])
        ->select('solicitudes_mantenimiento.*', 'historial_mantenimiento.*', 'facturas.*');
    }

    $resultado = $ordenes
      ->where('solicitudes_mantenimiento.estado_solicitud', 'entregado')
      ->get();

    $preciosMateriales = 0;
    $preciosReparacion = 0;
    foreach($resultado as $orden) {
      $preciosMateriales += $orden->precio_material;
      $preciosReparacion += $orden->precio_obra;
    }

    return view('arqueo.listado', [
      'raw' =>$resultado,
      'ordenes' => count($resultado),
      'precioMateriales' => $preciosMateriales,
      'precioReparacion' => $preciosReparacion,
      'total' => $preciosMateriales + $preciosReparacion,
      'desde' => $request->query('desde') !== null ? $request->query('desde') : '',
      'hasta' => $request->query('hasta') !== null ? $request->query('hasta') : '',
      'tecnicos' => Tecnicos::all(),
      'id_tecnico' => $request->query('tecnico'),
    ]);
  }
}