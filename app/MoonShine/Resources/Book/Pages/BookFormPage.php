<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Book\Pages;

use App\Models\Author;
use App\Models\Category;
use App\Models\Editorial;
use MoonShine\Laravel\Pages\Crud\FormPage;
use MoonShine\UI\Fields\Image;
use MoonShine\UI\Fields\Number;
use MoonShine\UI\Fields\Select;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Textarea;

class BookFormPage extends FormPage
{
    protected function fields(): iterable
    {
        return [
            Text::make('Título', 'title')->required(),
            Text::make('ISBN', 'isbn')->required(),
            Textarea::make('Descripción', 'description'),

            Number::make('Precio', 'price')->min(0)->required(),
            Number::make('Stock', 'stock')->min(0)->required(),

            Select::make('Categoría', 'category_id')
                ->options(Category::pluck('name', 'id')->toArray())
                ->required(),

            Select::make('Autor', 'author_id')
                ->options(Author::pluck('name', 'id')->toArray())
                ->required(),

            Select::make('Editorial', 'editorial_id')
                ->options(Editorial::pluck('name', 'id')->toArray())
                ->required(),

            Select::make('Estado', 'status')
                ->options([
                    'available'   => 'Disponible',
                    'unavailable' => 'No disponible',
                ])
                ->default('available'),

            Image::make('Imagen', 'image')
                ->dir('books')
                ->allowedExtensions(['jpg', 'jpeg', 'png']),
        ];
    }

    protected function rules($item): array
    {
        return [
            'title'        => ['required', 'string', 'max:255'],
            'isbn'         => ['required', 'string', 'max:20'],
            'price'        => ['required', 'numeric', 'min:0'],
            'stock'        => ['required', 'integer', 'min:0'],
            'category_id'  => ['required', 'exists:categories,id'],
            'author_id'    => ['required', 'exists:authors,id'],
            'editorial_id' => ['required', 'exists:editorials,id'],
            'status'       => ['required', 'in:available,unavailable'],
            'image'        => ['sometimes', 'nullable', 'image', 'max:2048'],
        ];
    }
}