<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Loan\Pages;

use MoonShine\Laravel\Pages\Crud\IndexPage;
use MoonShine\UI\Fields\Date;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Select;
use MoonShine\UI\Fields\Text;

class LoanIndexPage extends IndexPage
{
    protected bool $isLazy = true;

    protected function fields(): iterable
    {
        return [
            ID::make(),
            Text::make('Libro', 'book_id', fn($item) => $item->book?->title ?? 'N/A'),
            Text::make('Solicitado por', 'user_id', fn($item) => $item->user?->name ?? 'N/A'),
            Date::make('Préstamo', 'loan_date'),
            Date::make('Límite', 'due_date'),
            Date::make('Devolución', 'return_date'),
            Select::make('Estado', 'status')
                ->options([
                    'pending'  => 'Pendiente',
                    'active'   => 'Activo (Aprobado)',
                    'returned' => 'Devuelto',
                    'overdue'  => 'Atrasado',
                ]),
        ];
    }
}