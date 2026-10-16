<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Editorial\Pages;

use App\Models\Editorial;
use MoonShine\Laravel\Pages\Crud\IndexPage;
use MoonShine\UI\Components\ActionButton;
use MoonShine\UI\Fields\Email;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Text;

class EditorialIndexPage extends IndexPage
{
    protected bool $isLazy = true;

    protected function fields(): iterable
    {
        return [
            ID::make(),
            Text::make('Nombre', 'name'),
            Text::make('Teléfono', 'phone'),
            Email::make('Correo', 'email'),
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
            'model'  => Editorial::class,
            'fields' => 'id,name,phone,email',
            'title'  => 'Editoriales',
        ]);
    }
}