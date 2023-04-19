<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\SolicitudesMantenimiento;
use App\Models\Clientes;
use App\Models\Equipos;
use App\Models\HistorialMantenimiento;
use App\Models\Facturas;

use App\Services\TecnicosService;
use App\Services\ReportesService;
use App\Services\SolicitudesTecnicosService;

use Carbon\Carbon;

class SolicitudesMantenimientoController extends Controller
{
  private $tecnicosService;
  private $solicitudesTecnicosService;
  private $reportesService;

  public function __construct(
    TecnicosService $tecnicosService,
    SolicitudesTecnicosService $solicitudesTecnicosService,
    ReportesService $reportesService
  )
  {
    $this->middleware('auth');
    $this->tecnicosService = $tecnicosService;
    $this->solicitudesTecnicosService = $solicitudesTecnicosService;
    $this->reportesService = $reportesService;
  }
  
  public function registrarView(Request $request) {
    $correo = $request->route('correo');
    $checkCliente = Clientes::where('correo_electronico', $correo)->firstOrFail();
    $tecnicos = $this->tecnicosService->findAll();

    return view('solicitudes.registrar', [
      'cliente' => $checkCliente,
      'tecnicos' => $tecnicos,
    ]);
  }

  public function listadoView(Request $request)
  {
    $queryBuilder = DB::Table('solicitudes_mantenimiento')
      ->join('equipos', 'solicitudes_mantenimiento.id_equipo', '=', 'equipos.id_equipo')
      ->join('clientes', 'solicitudes_mantenimiento.id_cliente', '=', 'clientes.id_cliente')
      ->leftJoin('historial_mantenimiento', 'historial_mantenimiento.id_solicitud', '=', 'solicitudes_mantenimiento.id_solicitud')
      ->leftJoin('facturas', 'facturas.id_historial', '=', 'historial_mantenimiento.id_historial')
      ->orderBy('solicitudes_mantenimiento.created_at', 'desc')
      ->select('solicitudes_mantenimiento.*', 'equipos.*', 'clientes.*', 'facturas.*');

    $filtros = false;

    if (is_null($request->query('estado')) === false) {
      $estado = $request->query('estado');
      $queryBuilder->where('solicitudes_mantenimiento.estado_solicitud', '=', $estado);
      $filtros = true;
    }

    if (
      $request->query('fecha_desde') !== null
      && $request->query('fecha_hasta') !== null
    ) {
      $fecha_desde = $request->query('fecha_desde');
      $fecha_hasta = $request->query('fecha_hasta');
      $queryBuilder->whereBetween('solicitudes_mantenimiento.created_at', [
        $fecha_desde,
        $fecha_hasta,
      ]);
      $filtros = true;
    }

    $links = $queryBuilder->simplePaginate(25);

    $tecnicos = $this->tecnicosService->findAll();

    $estadoFiltro = null === $request->query('estado') ? null : $request->query('estado');
    $fechaFiltro = is_null($request->query('fecha_desde')) ?
      null : $request->query('fecha_desde')." - ".$request->query('fecha_hasta');

    return view('solicitudes.listado', [
      'links' => $links,
      'tecnicos' => $tecnicos,
      'maxSolicitudes' => SolicitudesMantenimiento::count(),
      'filtros' => $filtros,
      'estado_filtro' => $estadoFiltro,
      'fecha_filtro' => $fechaFiltro,
    ]);
  }

  public function listadoClienteView(Request $request)
  {
    $correo = $request->route('correo');

    $cliente = Clientes::where('correo_electronico', $correo)->firstOrFail();
    /*$solicitudes = SolicitudesMantenimiento::join('equipos', function($join) {
      $join->on('solicitudes_mantenimiento.id_equipo', '=', 'equipos.id_equipo');
      })
      ->join('clientes', function($join) use(&$cliente) {
        $join
          ->on('solicitudes_mantenimiento.id_cliente', '=', 'clientes.id_cliente')
          ->where('clientes.id_cliente', '=', $cliente['id_cliente']);
      })
      ->get();*/

    $solicitudes = DB::Table('clientes')
      ->join('solicitudes_mantenimiento', 'solicitudes_mantenimiento.id_cliente', '=', 'clientes.id_cliente')
      ->join('equipos', 'equipos.id_equipo', '=', 'solicitudes_mantenimiento.id_equipo')
      ->leftJoin('historial_mantenimiento', 'historial_mantenimiento.id_solicitud', '=', 'solicitudes_mantenimiento.id_solicitud')
      ->leftJoin('facturas', 'facturas.id_historial', '=', 'historial_mantenimiento.id_historial')
      ->leftJoin('tecnicos', 'tecnicos.id_tecnico', '=', 'historial_mantenimiento.id_tecnico')
      ->select(
        'solicitudes_mantenimiento.*',
        'equipos.*',
        'historial_mantenimiento.*',
        'tecnicos.nombre AS nombre_tecnico',
        'tecnicos.apellido AS apellido_tecnico',
        'facturas.*',
      )
      ->where('clientes.id_cliente', '=', $cliente['id_cliente'])
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
        ->where('solicitudes_mantenimiento.estado_solicitud', '!=', 'terminado')
        ->first();
    }

    return view('solicitudes.editar', [
      'solicitud' => $solicitud,
    ]);
  }

  public function crear(Request $request) {
    $request->validate([
      'articulo' => 'required',
      'modelo' => 'required',
      'correo' => 'required',
      'correo_tecnico' => 'required',
    ]);

    $datos = $request->all();

    $cliente = Clientes::where('correo_electronico', $datos['correo'])->firstOrFail();
    $tecnico = $this->tecnicosService->findOne($datos['correo_tecnico']);

    $equipo = Equipos::create([
      'articulo' => $datos['articulo'],
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
      'id_equipo' => $equipo['id_equipo'],
      'id_cliente' => $cliente['id_cliente'],
      'codigo_solicitud' => $codigo_solicitud,
      'fecha_solicitud' => $fecha_solicitud,
      'descripcion_problema' => $datos['descripcion_problema'],
      'estado_solicitud' => 'ingresado',
      'observaciones' => $datos['observaciones'],
    ]);

    $this->asignarTecnicoResponsable($solicitud['id_solicitud'], $tecnico['id_tecnico']);
    return $this->generarReporteEntrada($solicitud, $equipo, $tecnico);
  }

  public function editar(Request $request)
  {
    $request->validate([
      'articulo' => 'required',
      'num_serie' => 'required',
      'marca' => 'required',
      'modelo' => 'required',
      'fecha_compra' => 'required',
      'codigo_buscar' => 'required',
    ]);

    $datos = $request->all();
    $solicitud = SolicitudesMantenimiento
      ::where('codigo_solicitud', $datos['codigo_buscar'])
      ->where('estado_solicitud', '!=', 'terminado')
      ->firstOrFail();

    if ($solicitud->codigo_solicitud !== $datos['codigo_buscar']) {
      return redirect('/editar/solicitud/'.$datos['codigo_buscar'])->with([
        'type' => 'error',
        'mensaje' => 'No puedes editar el código de la solicitud'
      ]);
    }

    $equipo = Equipos::where('id_equipo', $solicitud['id_equipo'])->firstOrFail();

    Equipos::find($equipo['id_equipo'])->update([
      'articulo' => $datos['articulo'],
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

    if ($data['estado_solicitud'] === 'entregado') {
      $cliente = Clientes::where('id_cliente', $solicitud['id_cliente'])->firstOrFail();
      $equipo = Equipos::where('id_equipo', $solicitud['id_equipo'])->firstOrFail();

      $solicitudesMantenimiento = $this->solicitudesTecnicosService->findByIdSolicitud($solicitud['id_solicitud']);
      $idTecnico = $solicitudesMantenimiento['id_tecnico'];
      $tecnico = $this->tecnicosService->findById($idTecnico);

      $descripcionSolucion = is_null($data['descripcion_solucion']) ? '' : $data['descripcion_solucion'];
      $garantia = is_null($data['garantia']) ? '' : $data['garantia'];
      $historialOptions = ['id_tecnico' => $tecnico['id_tecnico'], 'descripcion_solucion' => $descripcionSolucion, 'garantia' => $garantia];
      $historial = $this->crearHistorial($solicitud, $historialOptions);

      $facturaOptions = [
        'id_historial' => $historial['id_historial'],
        'monto' => $data['monto'],
        'precio_material' => $data['precio_material'],
        'precio_obra' => $data['precio_obra'],
      ];

      $factura = $this->crearFactura($facturaOptions);

      //return $this->generarReporteSalida($solicitud, $historial, $factura, $tecnico);
      return redirect()->route('pagina-generar-reporte-salida', [
        'cliente' => $cliente['nombre']." ".$cliente['apellido'],
        'correo' => $cliente['correo_electronico'],
        'telefono' => $cliente['telefono'],
        'articulo' => $equipo['articulo'],
        'marca' => $equipo['marca'],
        'modelo' => $equipo['modelo'],
        'serie' => $equipo['num_serie'],
        'diagnostico' => $solicitud['descripcion_problema'],
        'reparacion' => $historial['descripcion_solucion'],
        'garantia' => $historial['garantia'],
        'precioMateriales' => $factura['precio_material'],
        'precioObra' => $factura['precio_obra'],
        'monto' => $factura['monto'],
        'tecnico' => $tecnico['nombre']." ".$tecnico['apellido'],
        'ordenServicio' => $solicitud['id_solicitud'],
      ]);
    }

    if ($data['estado_solicitud'] === 'en proceso') {
      $tecnicoResponsable = $this->tecnicosService->findOne($data['correo_tecnico']);
      $this->asignarTecnicoResponsable($solicitud['id_solicitud'], $tecnicoResponsable['id_tecnico']);
      $equipo = Equipos::where('id_equipo', $solicitud['id_equipo'])->firstOrFail();
      return $this->generarReporteEntrada($solicitud, $equipo, $tecnicoResponsable);
    }

    return redirect()->route('listado-solicitudes');
  }

  private function crearHistorial($solicitud, $options)
  {
    $fechaFin = date('Y-m-d');
    $datos = [
      'id_solicitud' => $solicitud->id_solicitud,
      'id_tecnico' => $options['id_tecnico'],
      'fecha_inicio' => $solicitud->created_at,
      'fecha_fin' => $fechaFin,
      'descripcion_solucion' => $options['descripcion_solucion'],
      'garantia' => $options['garantia'],
    ];

    return HistorialMantenimiento::create($datos);
  }

  private function crearFactura($options) {
    return Facturas::create($options);
  }

  private function asignarTecnicoResponsable($idSolicitud, $idTecnico)
  {
    return $this->solicitudesTecnicosService->create([
      'id_solicitud' => $idSolicitud,
      'id_tecnico' => $idTecnico,
    ]);
  }

  public function generarReporteEntrada($solicitud, $equipo, $tecnico)
  {
    $cliente = Clientes::where('id_cliente', $solicitud['id_cliente'])->firstOrFail();

    $pdf = $this->reportesService->entrada([
      'cliente' => $cliente['nombre']." ".$cliente['apellido'],
      'telefono' => $cliente['telefono'],
      'articulo' => $equipo['articulo'],
      'marca' => $equipo['marca'],
      'modelo' => $equipo['modelo'],
      'serie' => $equipo['num_serie'],
      'diagnostico' => $solicitud['descripcion_problema'],
      'notas' => $solicitud['observaciones'],
      'tecnico' => $tecnico['nombre']." ".$tecnico['apellido'],
      'ordenServicio' => $solicitud['id_solicitud'],
    ]);

    return $pdf;
  }

  public function generarReporteSalidaView(Request $request)
  {
    $data = $request->all();
    return view('solicitudes.reporte_salida')->with([
      'cliente' => $data['cliente'],
      'correo' => $data['correo'],
      'telefono' => $data['telefono'],
      'articulo' => $data['articulo'],
      'marca' => $data['marca'],
      'modelo' => $data['modelo'],
      'serie' => $data['serie'],
      'diagnostico' => $data['diagnostico'],
      'reparacion' => $data['reparacion'],
      'garantia' => $data['garantia'],
      'precioMateriales' => $data['precioMateriales'],
      'precioObra' => $data['precioObra'],
      'monto' => $data['monto'],
      'tecnico' => $data['tecnico'],
      'ordenServicio' => $data['ordenServicio'],
    ]);
  }

  public function generarReporteSalida(Request $request)
  {
    $request->validate([
      'cliente' => 'required',
      'telefono' => 'required',
      'articulo' => 'required',
      'marca' => 'required',
      'modelo' => 'required',
      'serie' => 'required',
      'diagnostico' => 'required',
      'reparacion' => 'required',
      'garantia' => 'required',
      'precioMateriales' => 'required',
      'precioObra' => 'required',
      'monto' => 'required',
      'tecnico' => 'required',
      'ordenServicio' => 'required',
    ]);

    $data = $request->all();

    $pdf = $this->reportesService->salida($data);

    return $pdf;
  }
}