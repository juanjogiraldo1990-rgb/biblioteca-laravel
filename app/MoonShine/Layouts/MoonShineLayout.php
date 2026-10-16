<?php

declare(strict_types=1);

namespace App\MoonShine\Layouts;

use MoonShine\Laravel\Layouts\AppLayout;
use MoonShine\ColorManager\Palettes\RosePalette;
use MoonShine\ColorManager\ColorManager;
use MoonShine\Contracts\ColorManager\ColorManagerContract;
use MoonShine\Contracts\ColorManager\PaletteContract;
use App\MoonShine\Resources\Category\CategoryResource;
use MoonShine\MenuManager\MenuItem;
use App\MoonShine\Resources\Author\AuthorResource;
use App\MoonShine\Resources\Editorial\EditorialResource;
use App\MoonShine\Resources\Book\BookResource;
use App\MoonShine\Resources\Member\MemberResource;
use App\MoonShine\Resources\Loan\LoanResource;

final class MoonShineLayout extends AppLayout
{
    /**
     * @var null|class-string<PaletteContract>
     */
    protected ?string $palette = RosePalette::class;

    protected function assets(): array
    {
        return [
            ...parent::assets(),
        ];
    }

    protected function menu(): array
    {
        return [
            ...parent::menu(),
            MenuItem::make(CategoryResource::class, 'Categories'),
            MenuItem::make(AuthorResource::class, 'Authors'),
            MenuItem::make(EditorialResource::class, 'Editorials'),
            MenuItem::make(BookResource::class, 'Books'),
            MenuItem::make(MemberResource::class, 'Members'),
            MenuItem::make(LoanResource::class, 'Loans'),
        ];
    }

    /**
     * @param ColorManager $colorManager
     */
    protected function colors(ColorManagerContract $colorManager): void
    {
        parent::colors($colorManager);

        // $colorManager->primary('#00000');
    }
}
