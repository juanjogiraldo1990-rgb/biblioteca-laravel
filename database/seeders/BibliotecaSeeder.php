<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use App\Models\Editorial;
use App\Models\Loan;
use App\Models\Member;
use Illuminate\Database\Seeder;

class BibliotecaSeeder extends Seeder
{
    public function run(): void
    {
        // 1) CATEGORÍAS
        $cats = [
            ['name' => 'Novela',          'description' => 'Obras narrativas extensas de ficción'],
            ['name' => 'Ciencia ficción', 'description' => 'Relatos especulativos sobre tecnología y futuro'],
            ['name' => 'Historia',        'description' => 'Libros de análisis y relato histórico'],
            ['name' => 'Poesía',          'description' => 'Composiciones en verso'],
            ['name' => 'Infantil',        'description' => 'Literatura dirigida a niños y jóvenes'],
        ];
        foreach ($cats as $c) {
            Category::updateOrCreate(['name' => $c['name']], $c);
        }

        // 2) AUTORES
        $authors = [
            ['name' => 'Gabriel García Márquez', 'nationality' => 'Colombiana',     'birth_date' => '1927-03-06'],
            ['name' => 'Isabel Allende',         'nationality' => 'Chilena',        'birth_date' => '1942-08-02'],
            ['name' => 'Isaac Asimov',           'nationality' => 'Estadounidense', 'birth_date' => '1920-01-02'],
            ['name' => 'Jorge Luis Borges',      'nationality' => 'Argentina',      'birth_date' => '1899-08-24'],
            ['name' => 'Mario Vargas Llosa',     'nationality' => 'Peruana',        'birth_date' => '1936-03-28'],
            ['name' => 'Pablo Neruda',           'nationality' => 'Chilena',        'birth_date' => '1904-07-12'],
        ];
        foreach ($authors as $a) {
            Author::updateOrCreate(['name' => $a['name']], $a);
        }

        // 3) EDITORIALES
        $editorials = [
            ['name' => 'Sudamericana',         'phone' => '3001234567', 'email' => 'contacto@sudamericana.com', 'address' => 'Buenos Aires'],
            ['name' => 'Debolsillo',           'phone' => '3105678901', 'email' => 'info@debolsillo.com',       'address' => 'Barcelona'],
            ['name' => 'Alfaguara',            'phone' => '3209876543', 'email' => 'servicio@alfaguara.com',    'address' => 'Madrid'],
            ['name' => 'Planeta',              'phone' => '3154321987', 'email' => 'atencion@planeta.com',      'address' => 'Bogotá'],
            ['name' => 'Penguin Random House', 'phone' => '3187654321', 'email' => 'soporte@penguin.com',       'address' => 'Nueva York'],
        ];
        foreach ($editorials as $e) {
            Editorial::updateOrCreate(['name' => $e['name']], $e);
        }

        // 4) LIBROS (buscando IDs reales por nombre)
        $books = [
            ['title' => 'Cien años de soledad',              'isbn' => '978-0307474728', 'price' => 45000, 'stock' => 15, 'status' => 'available',   'cat' => 'Novela',          'aut' => 'Gabriel García Márquez', 'edi' => 'Sudamericana'],
            ['title' => 'La casa de los espíritus',          'isbn' => '978-1400033904', 'price' => 38000, 'stock' => 8,  'status' => 'available',   'cat' => 'Novela',          'aut' => 'Isabel Allende',         'edi' => 'Debolsillo'],
            ['title' => 'Fundación',                         'isbn' => '978-0553293357', 'price' => 52000, 'stock' => 12, 'status' => 'available',   'cat' => 'Ciencia ficción', 'aut' => 'Isaac Asimov',           'edi' => 'Debolsillo'],
            ['title' => 'Ficciones',                         'isbn' => '978-0802130303', 'price' => 42000, 'stock' => 6,  'status' => 'available',   'cat' => 'Novela',          'aut' => 'Jorge Luis Borges',      'edi' => 'Sudamericana'],
            ['title' => 'La ciudad y los perros',            'isbn' => '978-8437604574', 'price' => 39000, 'stock' => 10, 'status' => 'available',   'cat' => 'Novela',          'aut' => 'Mario Vargas Llosa',     'edi' => 'Alfaguara'],
            ['title' => 'Veinte poemas de amor',             'isbn' => '978-8497002233', 'price' => 28000, 'stock' => 4,  'status' => 'available',   'cat' => 'Poesía',          'aut' => 'Pablo Neruda',           'edi' => 'Planeta'],
            ['title' => 'Yo, Robot',                         'isbn' => '978-0553294385', 'price' => 48000, 'stock' => 0,  'status' => 'unavailable', 'cat' => 'Ciencia ficción', 'aut' => 'Isaac Asimov',           'edi' => 'Debolsillo'],
            ['title' => 'El amor en los tiempos del cólera', 'isbn' => '978-0307387264', 'price' => 44000, 'stock' => 9,  'status' => 'available',   'cat' => 'Novela',          'aut' => 'Gabriel García Márquez', 'edi' => 'Sudamericana'],
        ];
        foreach ($books as $b) {
            Book::updateOrCreate(
                ['isbn' => $b['isbn']],
                [
                    'title'        => $b['title'],
                    'price'        => $b['price'],
                    'stock'        => $b['stock'],
                    'status'       => $b['status'],
                    'category_id'  => Category::where('name', $b['cat'])->value('id'),
                    'author_id'    => Author::where('name', $b['aut'])->value('id'),
                    'editorial_id' => Editorial::where('name', $b['edi'])->value('id'),
                ]
            );
        }

        // 5) SOCIOS
        $members = [
            ['document' => '1020304050', 'name' => 'Juan Pérez',      'email' => 'juan.perez@test.com', 'phone' => '3001234567', 'status' => 'active'],
            ['document' => '1020304051', 'name' => 'María Rodríguez', 'email' => 'maria.r@test.com',    'phone' => '3105678901', 'status' => 'active'],
            ['document' => '1020304052', 'name' => 'Carlos Gómez',    'email' => 'carlos.g@test.com',   'phone' => '3209876543', 'status' => 'active'],
            ['document' => '1020304053', 'name' => 'Ana Martínez',    'email' => 'ana.m@test.com',      'phone' => '3154321987', 'status' => 'active'],
            ['document' => '1020304054', 'name' => 'Luis Fernández',  'email' => 'luis.f@test.com',     'phone' => '3187654321', 'status' => 'inactive'],
            ['document' => '1020304055', 'name' => 'Sofía Ramírez',   'email' => 'sofia.r@test.com',    'phone' => '3112233445', 'status' => 'active'],
        ];
        foreach ($members as $m) {
            Member::updateOrCreate(['document' => $m['document']], $m);
        }

        // 6) PRÉSTAMOS
        $loans = [
            ['book_isbn' => '978-0307474728', 'member_doc' => '1020304050', 'loan_date' => '2026-10-14', 'due_date' => '2026-10-28', 'return_date' => null,         'status' => 'active'],
            ['book_isbn' => '978-0553293357', 'member_doc' => '1020304051', 'loan_date' => '2026-10-10', 'due_date' => '2026-10-24', 'return_date' => null,         'status' => 'active'],
            ['book_isbn' => '978-0802130303', 'member_doc' => '1020304052', 'loan_date' => '2026-09-01', 'due_date' => '2026-09-15', 'return_date' => '2026-09-12', 'status' => 'returned'],
            ['book_isbn' => '978-1400033904', 'member_doc' => '1020304053', 'loan_date' => '2026-09-20', 'due_date' => '2026-10-04', 'return_date' => null,         'status' => 'overdue'],
            ['book_isbn' => '978-8497002233', 'member_doc' => '1020304055', 'loan_date' => '2026-10-12', 'due_date' => '2026-10-26', 'return_date' => null,         'status' => 'active'],
            ['book_isbn' => '978-8437604574', 'member_doc' => '1020304054', 'loan_date' => '2026-08-15', 'due_date' => '2026-08-29', 'return_date' => '2026-08-28', 'status' => 'returned'],
        ];
        foreach ($loans as $l) {
            Loan::updateOrCreate(
                [
                    'book_id'    => Book::where('isbn', $l['book_isbn'])->value('id'),
                    'member_id'  => Member::where('document', $l['member_doc'])->value('id'),
                    'loan_date'  => $l['loan_date'],
                ],
                [
                    'due_date'    => $l['due_date'],
                    'return_date' => $l['return_date'],
                    'status'      => $l['status'],
                ]
            );
        }
    }
}