<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Category\Pages;

use MoonShine\Laravel\Pages\Crud\FormPage;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Textarea;

class CategoryFormPage extends FormPage
{
    protected function fields(): iterable
    {
        return [
            Text::make('Nombre', 'name')->required(),
            Textarea::make('Descripción', 'description'),
        ];
    }

    protected function rules($item): array
    {
        return [
            'name'        => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ];
    }
}