<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Clientes;
use App\Models\SolicitudesMantenimiento;

class ClientesController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }

  public function index()
  {    
    $clientes = Clientes::orderBy('created_at', 'desc')->simplePaginate(25);
    $idsClientes = [];

    foreach($clientes as $cliente) {
      array_push($idsClientes, "".$cliente['id_cliente']);
    }

    $solicitudes = SolicitudesMantenimiento
      ::whereIn('id_cliente', $idsClientes)
      ->get();

    $solicitudesIndexadas = [];

    if (count($solicitudes) > 0) {

      foreach($solicitudes as $solicitud) {
        $idCliente = "".$solicitud['id_cliente'];
        if (array_key_exists($idCliente, $solicitudesIndexadas) === false) {
          $solicitudesIndexadas[$idCliente] = array();
        }

        array_push($solicitudesIndexadas[$idCliente], [
          'estado' => $solicitud['estado_solicitud'],
        ]);
      }
    }

    $resultado = [];

    foreach($clientes as $cliente) {
      $correo = $cliente->correo_electronico;
      $idCliente = "".$cliente['id_cliente'];

      if (array_key_exists($correo, $resultado) === false) {
        $resultado[$correo] = array([
          'nombre' => $cliente['nombre']." ".$cliente['apellido'],
          'correo' => $cliente['correo_electronico'],
          'telefono' => $cliente['telefono'],
        ]);
      }

      if (array_key_exists($idCliente, $solicitudesIndexadas) === false) {
        continue;
      }

      $solicitud = $solicitudesIndexadas[$idCliente];
      
      array_push($resultado[$correo], $solicitud);
    }

    return view('clientes.index', [
      'clientes' => $resultado,
      'links' => $clientes,
      'maxClientes' => Clientes::count(),
    ]);
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
      'correo_electronico' => 'required',
      'telefono' => 'required'
    ]);

    $cliente = $req->all();
    $yaExistente = Clientes::where('correo_electronico', $cliente['correo_electronico'])->first();

    if ($yaExistente !== null) {
      return redirect()->route('registrar-cliente')->with([
        'error' => true,
        'message' => 'Ya hay un cliente registrado con el correo electrónico "'.$cliente['correo_electronico'].'"',
      ]);
    }

    $check = Clientes::create([
      'nombre' => $cliente['nombre'],
      'apellido' => isset($cliente['apellido']) ? $cliente['apellido'] : '',
      'correo_electronico' => $cliente['correo_electronico'],
      'telefono' => $cliente['telefono'],
    ]);

    return redirect()->route('clientes');
  }

  public function editar(Request $req)
  {
    $req->validate([
      'nombre' => 'required',
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
        'error' => true,
        'message' => 'Ya hay un cliente registrado con el correo "'.$datos['correo_electronico'].'"',
      ]);
    }

    Clientes::find($cliente['id_cliente'])->update([
      'nombre' => $datos['nombre'],
      'apellido' => $datos['apellido'],
      'correo_electronico' => $datos['correo_electronico'],
      'telefono' => $datos['telefono'],
    ]);

    return redirect()->route('clientes');
  }
}