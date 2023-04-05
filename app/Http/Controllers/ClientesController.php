<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Clientes;

class ClientesController extends Controller
{
  public function index()
  {
    $clientes = Clientes::all();
    return view('clientes.index', ['clientes' => $clientes]);
  }

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
    $check = Clientes::create([
      'nombre' => $cliente['nombre'],
      'apellido' => $cliente['apellido'],
      'correo_electronico' => $cliente['correo_electronico'],
      'telefono' => $cliente['telefono'],
    ]);

    return redirect()->route('registrar-cliente')->with([
      'type' => 'exito',
      'mensaje' => 'Se ha registrado el cliente',
    ]);
  }
}