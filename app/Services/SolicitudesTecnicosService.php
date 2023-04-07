<?php

namespace App\Services;

use App\Models\SolicitudesTecnicos;

class SolicitudesTecnicosService {
	public function create($datos)
	{
		$resultado = SolicitudesTecnicos::create($datos);
		return $resultado;
	}
}