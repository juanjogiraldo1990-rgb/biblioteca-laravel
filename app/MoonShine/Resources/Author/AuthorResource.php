<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Author;

use Illuminate\Database\Eloquent\Model;
use App\Models\Author;
use App\MoonShine\Resources\Author\Pages\AuthorIndexPage;
use App\MoonShine\Resources\Author\Pages\AuthorFormPage;
use App\MoonShine\Resources\Author\Pages\AuthorDetailPage;

use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\Contracts\Core\PageContract;

/**
 * @extends ModelResource<Author, AuthorIndexPage, AuthorFormPage, AuthorDetailPage>
 */
class AuthorResource extends ModelResource
{
    protected string $model = Author::class;

    protected string $title = 'Authors';

    protected string $column = 'name';
    protected bool $withPolicy = true;

    /**
     * @return list<class-string<PageContract>>
     */
    protected function pages(): array
    {
        return [
            AuthorIndexPage::class,
            AuthorFormPage::class,
            AuthorDetailPage::class,
        ];
    }
    
public function export(): ?ExportHandler
    {
        return MixedExportHandler::make('Exportar');
    }
}
