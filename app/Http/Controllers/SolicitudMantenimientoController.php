<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SolicitudMantenimiento;

class SolicitudMantenimientoController extends Controller
{
  public function showCrear() {
    return view('solicitud-mantenimiento');
  }

  public function crear(Request $request) {
    $request->validate([
      'num_serie' => 'required',
      'marca' => 'required',
      'modelo' => 'required',
      'fecha_compra' => 'required',
    ]);

    $data = $request->all();
    $check = $this->create($data);

    return view('solicitud-mantenimiento');
  }

  public function create(array $data) {
    return SolicitudMantenimiento::create([
      'num_serie' => $data['num_serie'],
      'marca' => $data['marca'],
      'modelo' => $data['modelo'],
      'fecha_compra' => $data['fecha_compra'],
    ]);
  }
}