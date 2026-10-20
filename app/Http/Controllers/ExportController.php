<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    /**
     * Exporta cualquier modelo a Excel. Solo Admin.
     */
    public function excel(Request $request)
    {
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

    /**
     * Muestra el formulario para subir el Excel (Modal).
     */
    public function importForm()
    {
        if (! auth('moonshine')->user()?->isAdmin()) {
            abort(403, 'Solo el Admin puede hacer cargas masivas.');
        }

        return view('exports.import-books');
    }

    /**
     * Procesa el archivo Excel y guarda los libros.
     */
    public function import(Request $request)
    {
        if (! auth('moonshine')->user()?->isAdmin()) {
            abort(403, 'Solo el Admin puede hacer cargas masivas.');
        }

        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:5120',
        ]);

        try {
            $file = $request->file('file');
            
            $data = Excel::toArray(new class implements ToArray {
                public function array(array $array): void {}
            }, $file);

            $rows = $data[0];
            $headers = array_shift($rows);

            $map = [
                'id' => null, 'title' => null, 'isbn' => null, 'description' => null, 
                'price' => null, 'stock' => null, 'status' => null,
                'category_id' => null, 'author_id' => null, 'editorial_id' => null
            ];

            foreach ($headers as $index => $header) {
                $header = strtolower(trim($header));
                if (array_key_exists($header, $map)) {
                    $map[$header] = $index;
                }
            }

            DB::beginTransaction();
            $inserted = 0;

            foreach ($rows as $row) {
                if (empty($row[$map['title']] ?? null)) continue;

                $bookId   = $map['id'] !== null ? ($row[$map['id']] ?? null) : null;
                $bookIsbn = $row[$map['isbn']] ?? null;

                $bookData = [
                    'title'        => $row[$map['title']],
                    'isbn'         => $bookIsbn ?? uniqid('isbn_'),
                    'description'  => $map['description'] !== null ? ($row[$map['description']] ?? null) : null,
                    'price'        => $map['price'] !== null ? ($row[$map['price']] ?? 0) : 0,
                    'stock'        => $map['stock'] !== null ? ($row[$map['stock']] ?? 0) : 0,
                    'status'       => $map['status'] !== null ? ($row[$map['status']] ?? 'available') : 'available',
                    'category_id'  => $map['category_id'] !== null ? ($row[$map['category_id']] ?? 1) : 1,
                    'author_id'    => $map['author_id'] !== null ? ($row[$map['author_id']] ?? 1) : 1,
                    'editorial_id' => $map['editorial_id'] !== null ? ($row[$map['editorial_id']] ?? 1) : 1,
                ];

                if ($bookId) {
                    Book::where('id', $bookId)->update($bookData);
                } else {
                    Book::updateOrCreate(['isbn' => $bookData['isbn']], $bookData);
                }
                
                $inserted++;
            }

            DB::commit();

            return back()->with('success', "¡Éxito! Se importaron o actualizaron $inserted libros correctamente.");

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error al procesar el Excel: ' . $e->getMessage());
        }
    }
}