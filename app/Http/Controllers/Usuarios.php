<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Usuarios extends Controller
{
  public function show() {
    $users = Usuarios::all();
    return view('usuarios', ['users' => $users]);
  }
}