<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipos extends Model
{
  use HasFactory;

  protected $table = 'equipos';
  protected $fillable = ['num_serie', 'marca', 'modelo', 'fecha_compra'];
}