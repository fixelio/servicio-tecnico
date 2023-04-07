<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SolicitudesMantenimiento extends Model
{
  use HasFactory;

  protected $table = 'solicitudes_mantenimiento';
  protected $primaryKey = 'id_solicitud';
  protected $fillable = ['id_equipo', 'id_cliente', 'codigo_solicitud', 'fecha_solicitud', 'descripcion_problema', 'estado_solicitud', 'observaciones'];
}