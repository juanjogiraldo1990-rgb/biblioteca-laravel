<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Loan\Pages;

use App\Models\Loan;
use MoonShine\Laravel\Pages\Crud\IndexPage;
use MoonShine\UI\Components\ActionButton;
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
            Text::make('Libro', 'book_id'),
            Text::make('Socio', 'member_id'),
            Date::make('Préstamo', 'loan_date'),
            Date::make('Límite', 'due_date'),
            Date::make('Devolución', 'return_date'),
            Select::make('Estado', 'status')
                ->options([
                    'active'   => 'Activo',
                    'returned' => 'Devuelto',
                    'overdue'  => 'Atrasado',
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
            'model'  => Loan::class,
            'fields' => 'id,book_id,member_id,loan_date,due_date,return_date,status',
            'title'  => 'Préstamos',
        ]);
    }
}