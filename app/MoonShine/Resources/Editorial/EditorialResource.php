<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Editorial;

use Illuminate\Database\Eloquent\Model;
use App\Models\Editorial;
use App\MoonShine\Resources\Editorial\Pages\EditorialIndexPage;
use App\MoonShine\Resources\Editorial\Pages\EditorialFormPage;
use App\MoonShine\Resources\Editorial\Pages\EditorialDetailPage;

use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\Contracts\Core\PageContract;

/**
 * @extends ModelResource<Editorial, EditorialIndexPage, EditorialFormPage, EditorialDetailPage>
 */
class EditorialResource extends ModelResource
{
    protected string $model = Editorial::class;

    protected string $title = 'Editorials';

    protected string $column = 'name';
    protected bool $withPolicy = true;

    /**
     * @return list<class-string<PageContract>>
     */
    protected function pages(): array
    {
        return [
            EditorialIndexPage::class,
            EditorialFormPage::class,
            EditorialDetailPage::class,
        ];
    }
public function export(): ?ExportHandler
    {
        return MixedExportHandler::make('Exportar');
    }
}
