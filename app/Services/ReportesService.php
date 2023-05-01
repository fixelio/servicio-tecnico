<?php

namespace App\Services;

use Barryvdh\DomPDF\Facade\Pdf;

use App\Models\SolicitudesMantenimiento;
use App\Models\Empresa;

class ReportesService {
	public function entrada($info)
	{
    $fechaSolicitud = date('Y/m/d H:i:s');
    $empresa = Empresa::latest()->first();

    $data = [
      'ordenServicio' => $info['ordenServicio'],
      'fechaSolicitud' => $fechaSolicitud,
      'cliente' => $info['cliente'],
      'articulo' => $info['articulo'],
      'marca' => $info['marca'],
      'telefono' => $info['telefono'],
      'modelo' => $info['modelo'],
      'serie' => $info['serie'],
      'diagnostico' => $info['diagnostico'],
      'notas' => $info['notas'],
      'tecnico' => $info['tecnico'],
      'empresa' => $empresa,
    ];

		return Pdf::loadView('pdf.entrada', $data)
      ->download('solicitud de mantenimiento entrada '.$info['cliente'].'.pdf');
	}

  public function salida($info)
  {
    $fechaSolicitud = date('Y/m/d H:i:s');
    $empresa = Empresa::latest()->first();

    $data = [
      'ordenServicio' => $info['ordenServicio'],
      'fechaSolicitud' => $fechaSolicitud,
      'cliente' => $info['cliente'],
      'telefono' => $info['telefono'],
      'articulo' => $info['articulo'],
      'marca' => $info['marca'],
      'modelo' => $info['modelo'],
      'serie' => $info['serie'],
      'diagnostico' => $info['diagnostico'],
      'reparacion' => $info['reparacion'],
      'garantia' => $info['garantia'],
      'monto' => $info['monto'],
      'tecnico' => $info['tecnico'],
      'empresa' => $empresa,
    ];

    return Pdf::loadView('pdf.salida', $data)
      ->download('solicitud de mantenimiento salida '.$info['cliente'].'.pdf');
  }
}