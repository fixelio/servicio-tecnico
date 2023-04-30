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

  public function findBy($key, $value) {
    return Tecnicos::where($key, $value)->firstOrFail();
  }

  public function findAll()
  {
    $tecnicos = Tecnicos::all();
    return $tecnicos;
  }

  public function getPaginate() {
    return Tecnicos::orderBy('created_at', 'desc')->simplePaginate(25);
  }

  public function tableCount() {
    return Tecnicos::count();
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