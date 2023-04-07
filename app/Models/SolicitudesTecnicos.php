<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SolicitudesTecnicos extends Model
{
    use HasFactory;

    protected $table = 'solicitudes_tecnicos';
    protected $fillable = ['id_solicitud', 'id_tecnico'];
}
