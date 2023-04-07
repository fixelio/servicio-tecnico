<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Models\SolicitudesTecnicos;

class SolicitudesTecnicosService {
  
  public function findJoin($idTecnico)
  {
    return DB::Table('solicitudes_tecnicos')
      ->join('solicitudes_mantenimiento', 'solicitudes_mantenimiento.id_solicitud', '=', 'solicitudes_tecnicos.id_solicitud')
      ->join('equipos', 'equipos.id_equipo', '=', 'solicitudes_mantenimiento.id_equipo')
      ->select('solicitudes_mantenimiento.*', 'equipos.*')
      ->where('solicitudes_tecnicos.id_tecnico', $idTecnico)
      ->orderBy('solicitudes_tecnicos.created_at', 'desc')
      ->get();
  }

	public function create($datos)
	{
		$resultado = SolicitudesTecnicos::create($datos);
		return $resultado;
	}

}