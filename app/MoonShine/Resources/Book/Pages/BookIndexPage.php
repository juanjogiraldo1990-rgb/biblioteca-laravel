<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Book\Pages;

use App\Models\Book;
use MoonShine\Laravel\Pages\Crud\IndexPage;
use MoonShine\UI\Components\ActionButton;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Image;
use MoonShine\UI\Fields\Number;
use MoonShine\UI\Fields\Select;
use MoonShine\UI\Fields\Text;

class BookIndexPage extends IndexPage
{
    protected bool $isLazy = true;

    protected function fields(): iterable
    {
        return [
            ID::make(),
            Image::make('Imagen', 'image'),
            Text::make('Título', 'title'),
            Text::make('ISBN', 'isbn'),
            Number::make('Precio', 'price'),
            Number::make('Stock', 'stock'),
            Select::make('Estado', 'status')
                ->options([
                    'available'   => 'Disponible',
                    'unavailable' => 'No disponible',
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

            ActionButton::make('Carga Masiva', route('export.import-form'))
                ->icon('arrow-up-tray'),
        ];
    }

    private function exportUrl(string $format): string
    {
        return route("export.{$format}", [
            'model'  => Book::class,
            'fields' => 'id,title,isbn,price,stock,status',
            'title'  => 'Libros',
        ]);
    }
}