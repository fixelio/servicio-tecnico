<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistorialMantenimiento extends Model
{
  use HasFactory;

  protected $table = 'historial_mantenimiento';
  protected $primaryKey = 'id_historial';

  protected $fillable = ['id_solicitud', 'id_tecnico', 'fecha_inicio', 'fecha_fin', 'descripcion_solucion'];
}