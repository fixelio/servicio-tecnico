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
    
  }
}