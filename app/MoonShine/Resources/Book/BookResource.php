<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Book;

use App\Models\Book;
use App\MoonShine\Resources\Book\Pages\BookDetailPage;
use App\MoonShine\Resources\Book\Pages\BookFormPage;
use App\MoonShine\Resources\Book\Pages\BookIndexPage;
use MoonShine\Laravel\Resources\ModelResource;

class BookResource extends ModelResource
{
    protected string $model = Book::class;
    protected string $title = 'Libros';
    protected string $column = 'title';
    
    // ESTO ES CLAVE: Le decimos a MoonShine que evalúe las políticas
    protected bool $withPolicy = true;
    
    // Le decimos explícitamente qué botones queremos en la tabla
    protected array $activeActions = ['create', 'view', 'edit', 'delete'];

    protected function pages(): array
    {
        return [
            BookIndexPage::class,
            BookFormPage::class,
            BookDetailPage::class,
        ];
    }
}