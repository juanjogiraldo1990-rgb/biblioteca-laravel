<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Author\Pages;

use App\Models\Author;
use MoonShine\Laravel\Pages\Crud\IndexPage;
use MoonShine\UI\Components\ActionButton;
use MoonShine\UI\Fields\Date;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Text;

class AuthorIndexPage extends IndexPage
{
    protected bool $isLazy = true;

    protected function fields(): iterable
    {
        return [
            ID::make(),
            Text::make('Nombre', 'name'),
            Text::make('Nacionalidad', 'nationality'),
            Date::make('Nacimiento', 'birth_date'),
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
            'model'  => Author::class,
            'fields' => 'id,name,nationality,birth_date',
            'title'  => 'Autores',
        ]);
    }
}