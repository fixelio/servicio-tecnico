<?php

namespace App\Services;

use App\Models\Tecnicos;

class TecnicosService {
  public function findOne($correo, $options = ['throwError' => true])
  {
    $resultado = Tecnicos::where('correo_electronico', $correo);

    if ($options['throwError'] === false) {
      return $resultado->first();
    }

    return $resultado->firstOrFail();
  }

  public function findById($id)
  {
    return Tecnicos::where('id_tecnico', $id)->firstOrFail();
  }

  public function findAll()
  {
    $tecnicos = Tecnicos::all();
    return $tecnicos;
  }

	public function create($datos)
	{
		$resultado = Tecnicos::create($datos);
		return $resultado;
	}

  public function update($id, $datos)
  {
    Tecnicos::find($id)->update($datos);
  }
}