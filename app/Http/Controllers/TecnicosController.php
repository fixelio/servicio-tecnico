<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Services\TecnicosService;
use App\Services\SolicitudesTecnicosService;

class TecnicosController extends Controller
{
  private $tecnicosService;

  public function __construct(
    TecnicosService $service,
    SolicitudesTecnicosService $solicitudesTecnicos
  )
  {
    $this->middleware('auth');
    $this->tecnicosService = $service;
    $this->solicitudesTecnicos = $solicitudesTecnicos;
  }

  public function registrarView()
  {
    return view('tecnicos.registrar');
  }

  public function crear(Request $request)
  {
    $request->validate([
      'nombre' => 'required',
      'apellido' => 'required',
      'correo_electronico' => 'required',
    ]);

    $datos = $request->all();
    $this->tecnicosService->create($datos);
    return redirect()->route('listado-tecnicos');
  }

  public function listadoView()
  {
    $tecnicos = $this->tecnicosService->findAll();
    return view('tecnicos.listado', [
      'tecnicos' => $tecnicos,
      'links' => $this->tecnicosService->getPaginate(),
      'maxTecnicos' => $this->tecnicosService->tableCount(),
    ]);
  }

  public function editarView(Request $request, $correo = null)
  {
    $correo = $request->route('correo');
    $tecnico = null;

    if (is_null($correo) === false) {
      $tecnico = $this->tecnicosService->findOne($correo);
    }

    return view('tecnicos.editar', ['tecnico' => $tecnico]);
  }

  public function editar(Request $request)
  {
    $request->validate([
      'nombre' => 'required',
      'apellido' => 'required',
      'correo_electronico' => 'required',
      'correo_buscar' => 'required',
    ]);

    $datos = $request->all();
    $tecnico = $this->tecnicosService->findOne($datos['correo_buscar']);

    $debeChequear = $datos['correo_electronico'] !== $datos['correo_buscar'];
    $check = $this->tecnicosService->findOne($datos['correo_electronico'], [
      'throwError' => false,
    ]);

    if ($debeChequear && is_null($check) === false) {
      return redirect('/editar/tecnico/'.$datos['correo_buscar'])->with([
        'type' => 'error',
        'mensaje' => 'Ya hay un técnico registrado con el correo '.$datos['correo_electronico'],
      ]);
    }

    $this->tecnicosService->update($tecnico['id_tecnico'], $datos);

    return redirect()->route('listado-tecnicos');
  }

  public function trabajoAsignado (Request $request, $correo = null)
  {
    $correo = $request->route('correo');
    $tecnico = null;
    $trabajos = [];

    if ($correo !== null) {
      $tecnico = $this->tecnicosService->findOne($correo);
    }

    if ($tecnico !== null) {
      $trabajos = $this->solicitudesTecnicos->findJoin($tecnico['id_tecnico']);
    }

    return view('tecnicos.trabajos', [
      'tecnico' => $tecnico,
      'trabajos' => $trabajos,
    ]);
  }
}
