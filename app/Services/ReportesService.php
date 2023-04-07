<?php

namespace App\Services;

use Barryvdh\DomPDF\Facade\Pdf;

class ReportesService {
	public function entrada()
	{
		$pdf = Pdf::loadView('pdf.dummy', ['data' => 'Hello World']);
		return $pdf->download('dummy.pdf');
	}
}