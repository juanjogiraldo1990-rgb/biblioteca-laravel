<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Editorial\Pages;

use MoonShine\Laravel\Pages\Crud\FormPage;
use MoonShine\UI\Fields\Email;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Textarea;

class EditorialFormPage extends FormPage
{
    protected function fields(): iterable
    {
        return [
            Text::make('Nombre', 'name')->required(),
            Text::make('Teléfono', 'phone'),
            Email::make('Correo', 'email'),
            Textarea::make('Dirección', 'address'),
        ];
    }

    protected function rules($item): array
    {
        return [
            'name'    => ['required', 'string', 'max:255'],
            'phone'   => ['nullable', 'string', 'max:30'],
            'email'   => ['nullable', 'email', 'max:255'],
            'address' => ['nullable', 'string'],
        ];
    }
}