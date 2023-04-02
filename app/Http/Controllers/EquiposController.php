<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\QueryException;
use App\Models\Equipos;

class EquiposController extends Controller
{
  public function showCrear() {
    return view('equipo');
  }

  public function crear(Request $request) {
    $request->validate([
      'num_serie' => 'required',
      'marca' => 'required',
      'modelo' => 'required',
      'fecha_compra' => 'required',
    ]);

    $data = $request->all();

    try {
      $check = $this->create($data);
    }
    catch (QueryException $e) {
      return redirect()->back()->withInput()->withErrors(['mensaje' => 'Ha ocurrido un error al guardar el equipo.']);
    }

    return redirect()->withSuccess();
  }

  public function create(array $data) {
    return Equipos::create([
      'num_serie' => $data['num_serie'],
      'marca' => $data['marca'],
      'modelo' => $data['modelo'],
      'fecha_compra' => $data['fecha_compra'],
    ]);
  }
}