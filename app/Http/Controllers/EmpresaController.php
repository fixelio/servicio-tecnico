<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empresa;

class EmpresaController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }

  public function resumenView()
  {
    $data = Empresa::latest()->first();

    return view('empresa.resumen', [
      'email' => $data['email'],
      'telefono' => $data['telefono'],
      'footer' => $data['footer'],
    ]);
  }

  public function editar(Request $request)
  {
    $request->validate([
      'email' => 'required',
      'telefono' => 'required',
      'footer' => 'required',
    ]);

    $data = $request->all();

    $empresa = Empresa::latest()->first();
    Empresa::find($empresa['id_empresa'])->update([
      'email' => $data['email'],
      'telefono' => $data['telefono'],
      'footer' => $data['footer'],
    ]);
    
    return redirect('/empresa');
  }
}
