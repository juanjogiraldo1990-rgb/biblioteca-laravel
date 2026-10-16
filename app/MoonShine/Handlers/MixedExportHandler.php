<?php

declare(strict_types=1);

namespace App\MoonShine\Handlers;

use Barryvdh\DomPDF\Facade\Pdf;
use MoonShine\Handlers\ExportHandler;
use MoonShine\UI\Components\ActionButton;
use MoonShine\UI\Components\Dropdown;

class MixedExportHandler extends ExportHandler
{
    public function getButton(): ActionButton
    {
        return ActionButton::make('Exportar')
            ->dropdown(
                Dropdown::make()
                    ->items([
                        ActionButton::make('Excel (.xlsx)')
                            ->method('exportExcel', $this),
                        ActionButton::make('PDF (.pdf)')
                            ->method('exportPdf', $this),
                    ])
            );
    }

    public function exportExcel(): mixed
    {
        return parent::handle();
    }

    public function exportPdf(): mixed
    {
        $data = $this->getData();
        $fields = $this->getFields();

        $pdf = Pdf::loadView('exports.pdf', [
            'data'   => $data,
            'fields' => $fields,
        ]);

        return $pdf->download('reporte-' . now()->format('Y-m-d') . '.pdf');
    }
}
