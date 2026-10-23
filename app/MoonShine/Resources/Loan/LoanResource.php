<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Loan;

use App\Models\Loan;
use App\MoonShine\Resources\Loan\Pages\LoanDetailPage;
use App\MoonShine\Resources\Loan\Pages\LoanFormPage;
use App\MoonShine\Resources\Loan\Pages\LoanIndexPage;
use MoonShine\Laravel\Resources\ModelResource;

/**
 * @extends ModelResource<Loan, LoanIndexPage, LoanFormPage, LoanDetailPage>
 */
class LoanResource extends ModelResource
{
    protected string $model = Loan::class;

    protected string $title = 'Préstamos';

    protected string $column = 'id';
    protected bool $withPolicy = true;

    /**
     * @return list<class-string<PageContract>>
     */
    protected function pages(): array
    {
        return [
            LoanIndexPage::class,
            LoanFormPage::class,
            LoanDetailPage::class,
        ];
    }

    /**
     * Filtra los préstamos si el usuario es Lector.
     */
    protected function query(): \Illuminate\Database\Eloquent\Builder
    {
        $query = parent::query();

        if (auth('moonshine')->user()?->isLector()) {
            return $query->where('user_id', auth('moonshine')->user()->id);
        }

        return $query;
    }
}