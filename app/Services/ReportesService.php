<?php

namespace App\Services;

use Barryvdh\DomPDF\Facade\Pdf;

use App\Models\SolicitudesMantenimiento;

class ReportesService {
	public function entrada($info)
	{
    $ordenServicio = SolicitudesMantenimiento::count();
    $fechaSolicitud = date('Y-m-d H:i:s');

    $data = [
      'ordenServicio' => $ordenServicio,
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
    ];

		return Pdf::loadView('pdf.entrada', $data)
      ->download('solicitud de mantenimiento entrada.pdf');
	}
}