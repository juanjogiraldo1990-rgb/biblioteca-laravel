<?php

declare(strict_types=1);

namespace App\MoonShine\Handlers;

use Barryvdh\DomPDF\Facade\Pdf;
use MoonShine\Handlers\ExportHandler;

class PdfExportHandler extends ExportHandler
{
    public function handle(): mixed
    {
        // Obtenemos los datos y los campos que definiste con ->showOnExport()
        $data = $this->getData();
        $fields = $this->getFields();

        // Generamos el PDF a partir de una vista
        $pdf = Pdf::loadView('exports.pdf', [
            'data' => $data,
            'fields' => $fields,
        ]);

        // Descargamos el archivo
        return $pdf->download('reporte.pdf');
    }
}
