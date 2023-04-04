<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Clientes;

class ClientesController extends Controller
{
  public function registrarView()
  {
    return view('clientes.registrar');
  }

  public function crear(Request $req)
  {
    $req->validate([
      'nombre' => 'required',
      'apellido' => 'required',
      'correo_electronico' => 'required',
      'telefono' => 'required'
    ]);

    $cliente = $req->all();
    $check = Clientes::crear([
      'nombre' => $cliente['nombre'],
      'apellido' => $cliente['apellido'],
      'correo_electronico' => $cliente['correo_electronio'],
      'telefono' => $cliente['telefono'],
    ]);

    return view('clientes.registrar', [
      'type' => 'exito',
      'mensaje' => 'Se ha registrado el cliente',
    ]);
  }
}