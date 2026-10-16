<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Loan\Pages;

use App\Models\Book;
use App\Models\Member;
use MoonShine\Laravel\Pages\Crud\FormPage;
use MoonShine\UI\Fields\Date;
use MoonShine\UI\Fields\Select;

class LoanFormPage extends FormPage
{
    protected function fields(): iterable
    {
        return [
            Select::make('Libro', 'book_id')
                ->options(Book::pluck('title', 'id')->toArray())
                ->required(),

            Select::make('Socio', 'member_id')
                ->options(Member::pluck('name', 'id')->toArray())
                ->required(),

            Date::make('Fecha de préstamo', 'loan_date')
                ->default(now())
                ->required(),

            Date::make('Fecha límite', 'due_date')
                ->required(),

            Date::make('Fecha de devolución', 'return_date'),

            Select::make('Estado', 'status')
                ->options([
                    'active'   => 'Activo',
                    'returned' => 'Devuelto',
                    'overdue'  => 'Atrasado',
                ])
                ->default('active'),
        ];
    }

    protected function rules($item): array
    {
        return [
            'book_id'     => ['required', 'exists:books,id'],
            'member_id'   => ['required', 'exists:members,id'],
            'loan_date'   => ['required', 'date'],
            'due_date'    => ['required', 'date', 'after_or_equal:loan_date'],
            'return_date' => ['nullable', 'date', 'after_or_equal:loan_date'],
            'status'      => ['required', 'in:active,returned,overdue'],
        ];
    }
}