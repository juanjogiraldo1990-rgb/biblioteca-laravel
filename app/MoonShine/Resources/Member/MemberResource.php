<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Member;

use Illuminate\Database\Eloquent\Model;
use App\Models\Member;
use App\MoonShine\Resources\Member\Pages\MemberIndexPage;
use App\MoonShine\Resources\Member\Pages\MemberFormPage;
use App\MoonShine\Resources\Member\Pages\MemberDetailPage;

use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\Contracts\Core\PageContract;

/**
 * @extends ModelResource<Member, MemberIndexPage, MemberFormPage, MemberDetailPage>
 */
class MemberResource extends ModelResource
{
    protected string $model = Member::class;

    protected string $title = 'Members';

    protected string $column = 'name';
    protected bool $withPolicy = true;

    /**
     * @return list<class-string<PageContract>>
     */
    protected function pages(): array
    {
        return [
            MemberIndexPage::class,
            MemberFormPage::class,
            MemberDetailPage::class,
        ];
    }
    
  public function export(): ?ExportHandler
    {
        return MixedExportHandler::make('Exportar');
    }
}
