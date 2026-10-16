<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Book;

use Illuminate\Database\Eloquent\Model;
use App\Models\Book;
use App\MoonShine\Resources\Book\Pages\BookIndexPage;
use App\MoonShine\Resources\Book\Pages\BookFormPage;
use App\MoonShine\Resources\Book\Pages\BookDetailPage;

use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\Contracts\Core\PageContract;

/**
 * @extends ModelResource<Book, BookIndexPage, BookFormPage, BookDetailPage>
 */
class BookResource extends ModelResource
{
    protected string $model = Book::class;
    protected string $title = 'Books';
    protected string $column = 'title';
    protected bool $withPolicy = true;

    /**
     * @return list<class-string<PageContract>>
     */
    protected function pages(): array
    {
        return [
            BookIndexPage::class,
            BookFormPage::class,
            BookDetailPage::class,
        ];
    }

public function export(): ?ExportHandler
{
    return MixedExportHandler::make('Exportar');
}
}