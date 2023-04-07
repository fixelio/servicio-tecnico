<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tecnicos extends Model
{
  use HasFactory;

  protected $table = 'tecnicos';
  protected $primaryKey = 'id_tecnico';

  protected $fillable = ['nombre', 'apellido', 'correo_electronico', 'telefono'];
}