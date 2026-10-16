<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Category\Pages;

use App\Models\Category;
use MoonShine\Laravel\Pages\Crud\IndexPage;
use MoonShine\UI\Components\ActionButton;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Textarea;

class CategoryIndexPage extends IndexPage
{
    protected bool $isLazy = true;

    protected function fields(): iterable
    {
        return [
            ID::make(),
            Text::make('Nombre', 'name'),
            Textarea::make('Descripción', 'description'),
        ];
    }

    protected function topLayer(): array
    {
        if (! auth('moonshine')->user()?->isAdmin()) {
            return [];
        }

        return [
            ActionButton::make('Exportar Excel', $this->exportUrl('excel'))
                ->icon('document-arrow-down'),
            ActionButton::make('Exportar PDF', $this->exportUrl('pdf'))
                ->icon('document-text'),
        ];
    }

    private function exportUrl(string $format): string
    {
        return route("export.{$format}", [
            'model'  => Category::class,
            'fields' => 'id,name,description',
            'title'  => 'Categorías',
        ]);
    }
}