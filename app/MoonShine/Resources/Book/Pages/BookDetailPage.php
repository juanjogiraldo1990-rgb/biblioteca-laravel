<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Book\Pages;

use MoonShine\Laravel\Pages\Crud\DetailPage;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Image;
use MoonShine\UI\Fields\Number;
use MoonShine\UI\Fields\Select;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Textarea;

class BookDetailPage extends DetailPage
{
    protected function fields(): iterable
    {
        return [
            ID::make(),
            Image::make('Imagen', 'image'),
            Text::make('Título', 'title'),
            Text::make('ISBN', 'isbn'),
            
            // Descripción grande y completa
            Textarea::make('Descripción', 'description')
                ->class('whitespace-normal leading-relaxed text-lg'),
            
            Number::make('Precio', 'price'),
            Number::make('Stock', 'stock'),
            Select::make('Estado', 'status')
                ->options([
                    'available'   => 'Disponible',
                    'unavailable' => 'No disponible',
                ]),
        ];
    }
}