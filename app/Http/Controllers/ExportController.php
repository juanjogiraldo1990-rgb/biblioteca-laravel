<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    /**
     * Exporta cualquier modelo a Excel. Solo Admin.
     */
    public function excel(Request $request)
    {
        // 🔒 Solo el Admin puede exportar
        if (! auth('moonshine')->user()?->isAdmin()) {
            abort(403, 'Acceso denegado. Solo el Admin puede exportar.');
        }

        $model  = $request->query('model');
        $fields = explode(',', $request->query('fields', 'id'));

        if (! class_exists($model)) {
            abort(404, 'Modelo no encontrado');
        }

        $items = $model::all();

        $rows = [];
        foreach ($items as $item) {
            $row = [];
            foreach ($fields as $f) {
                $row[] = data_get($item, $f);
            }
            $rows[] = $row;
        }

        $headings = array_map(fn ($f) => ucfirst($f), $fields);

        $export = new class($rows, $headings) implements FromArray, WithHeadings {
            public function __construct(
                protected array $rows,
                protected array $headings
            ) {}

            public function array(): array
            {
                return $this->rows;
            }

            public function headings(): array
            {
                return $this->headings;
            }
        };

        $filename = 'reporte-' . now()->format('Y-m-d') . '.xlsx';

        return Excel::download($export, $filename);
    }

    /**
     * Exporta cualquier modelo a PDF. Solo Admin.
     */
    public function pdf(Request $request)
    {
        // 🔒 Solo el Admin puede exportar
        if (! auth('moonshine')->user()?->isAdmin()) {
            abort(403, 'Acceso denegado. Solo el Admin puede exportar.');
        }

        $model  = $request->query('model');
        $fields = explode(',', $request->query('fields', 'id'));
        $title  = $request->query('title', 'Reporte');

        if (! class_exists($model)) {
            abort(404, 'Modelo no encontrado');
        }

        $items = $model::all();

        $headings = array_map(fn ($f) => ucfirst($f), $fields);

        $pdf = Pdf::loadView('exports.pdf', [
            'data'     => $items,
            'fields'   => $fields,
            'headings' => $headings,
            'title'    => $title,
        ]);

        $filename = 'reporte-' . now()->format('Y-m-d') . '.pdf';

        return $pdf->download($filename);
    }
}