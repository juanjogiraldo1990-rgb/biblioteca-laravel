<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Author\Pages;

use MoonShine\Laravel\Pages\Crud\FormPage;
use MoonShine\UI\Fields\Date;
use MoonShine\UI\Fields\Text;

class AuthorFormPage extends FormPage
{
    protected function fields(): iterable
    {
        return [
            Text::make('Nombre', 'name')->required(),
            Text::make('Nacionalidad', 'nationality'),
            Date::make('Fecha de nacimiento', 'birth_date'),
        ];
    }

    protected function rules($item): array
    {
        return [
            'name'        => ['required', 'string', 'max:255'],
            'nationality' => ['nullable', 'string', 'max:100'],
            'birth_date'  => ['nullable', 'date'],
        ];
    }
}