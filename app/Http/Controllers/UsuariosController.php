<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuarios;

class UsuariosController extends Controller
{
  public function show() {
    $users = Usuarios::all();
    return view('usuarios', ['users' => $users]);
  }
}