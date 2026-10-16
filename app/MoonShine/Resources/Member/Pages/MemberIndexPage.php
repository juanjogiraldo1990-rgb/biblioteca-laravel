<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Member\Pages;

use App\Models\Member;
use MoonShine\Laravel\Pages\Crud\IndexPage;
use MoonShine\UI\Components\ActionButton;
use MoonShine\UI\Fields\Date;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Select;
use MoonShine\UI\Fields\Text;

class MemberIndexPage extends IndexPage
{
    protected bool $isLazy = true;

    protected function fields(): iterable
    {
        return [
            ID::make(),
            Text::make('Documento', 'document'),
            Text::make('Nombre', 'name'),
            Text::make('Correo', 'email'),
            Text::make('Teléfono', 'phone'),
            Date::make('Nacimiento', 'birth_date'),
            Select::make('Estado', 'status')
                ->options([
                    'active'   => 'Activo',
                    'inactive' => 'Inactivo',
                ]),
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
            'model'  => Member::class,
            'fields' => 'id,document,name,email,phone,birth_date,status',
            'title'  => 'Socios',
        ]);
    }
}