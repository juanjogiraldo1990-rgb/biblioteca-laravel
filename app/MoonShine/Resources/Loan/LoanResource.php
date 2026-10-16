<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Loan;

use Illuminate\Database\Eloquent\Model;
use App\Models\Loan;
use App\MoonShine\Resources\Loan\Pages\LoanIndexPage;
use App\MoonShine\Resources\Loan\Pages\LoanFormPage;
use App\MoonShine\Resources\Loan\Pages\LoanDetailPage;

use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\Contracts\Core\PageContract;

/**
 * @extends ModelResource<Loan, LoanIndexPage, LoanFormPage, LoanDetailPage>
 */
class LoanResource extends ModelResource

{
    protected string $model = Loan::class;

    protected string $title = 'Loans';

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


public function export(): ?ExportHandler
    {
        return MixedExportHandler::make('Exportar');
    }
}
