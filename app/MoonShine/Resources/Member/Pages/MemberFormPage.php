<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Member\Pages;

use MoonShine\Laravel\Pages\Crud\FormPage;
use MoonShine\UI\Fields\Date;
use MoonShine\UI\Fields\Email;
use MoonShine\UI\Fields\Select;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Textarea;

class MemberFormPage extends FormPage
{
    protected function fields(): iterable
    {
        return [
            Text::make('Documento', 'document')->required(),
            Text::make('Nombre', 'name')->required(),
            Email::make('Correo', 'email')->required(),
            Text::make('Teléfono', 'phone'),
            Textarea::make('Dirección', 'address'),
            Date::make('Fecha de nacimiento', 'birth_date'),

            Select::make('Estado', 'status')
                ->options([
                    'active'   => 'Activo',
                    'inactive' => 'Inactivo',
                ])
                ->default('active'),
        ];
    }

    protected function rules($item): array
    {
        return [
            'document'   => ['required', 'string', 'max:30'],
            'name'       => ['required', 'string', 'max:255'],
            'email'      => ['required', 'email', 'max:255'],
            'phone'      => ['nullable', 'string', 'max:30'],
            'address'    => ['nullable', 'string'],
            'birth_date' => ['nullable', 'date'],
            'status'     => ['required', 'in:active,inactive'],
        ];
    }
}