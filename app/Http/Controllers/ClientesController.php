<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Clientes;

class ClientesController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }

  public function index()
  {
    $clientes = DB::table('clientes')
      ->leftJoin('solicitudes_mantenimiento', 'clientes.id_cliente', '=', 'solicitudes_mantenimiento.id_cliente')
      ->get();
      
    return view('clientes.index', ['clientes' => $clientes]);
  }

  public function registrarView()
  {
    return view('clientes.registrar');
  }

  public function editarView(Request $request, $correo = null)
  {
    $correo = $request->route('correo');
    $cliente = null;

    if ($correo !== null) {
      $cliente = Clientes::where('correo_electronico', $correo)->firstOrFail();
    }

    return view('clientes.editar', ['cliente' => $cliente]);
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

  public function editar(Request $req)
  {
    $req->validate([
      'nombre' => 'required',
      'apellido' => 'required',
      'correo_electronico' => 'required',
      'telefono' => 'required',
      'correo_buscar' => 'required',
    ]);

    $datos = $req->all();
    $cliente = Clientes::where('correo_electronico', $datos['correo_buscar'])->firstOrFail();

    // Debe chequear si el correo ya está en uso si se está modificando el correo de este cliente
    $debeChequear = $datos['correo_electronico'] !== $datos['correo_buscar'];
    $check = Clientes::where('correo_electronico', $datos['correo_electronico'])->first();

    if ($debeChequear && is_null($check) === false) {
      return redirect('/editar/cliente/'.$datos['correo_buscar'])->with([
        'type' => 'error',
        'mensaje' => 'Ya hay un cliente registrado con el correo '.$datos['correo_electronico'],
      ]);
    }

    Clientes::find($cliente['id_cliente'])->update([
      'nombre' => $datos['nombre'],
      'apellido' => $datos['apellido'],
      'correo_electronico' => $datos['correo_electronico'],
      'telefono' => $datos['telefono'],
    ]);

    return redirect('/editar/cliente')->with([
      'type' => 'exito',
      'mensaje' => 'Se ha editado el cliente',
    ]);
  }
}