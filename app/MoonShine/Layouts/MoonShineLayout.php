<?php

declare(strict_types=1);

namespace App\MoonShine\Layouts;

use MoonShine\Laravel\Layouts\AppLayout;
use MoonShine\ColorManager\Palettes\RosePalette;
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

    protected function menu(): array
    {
        return [
            ...parent::menu(),
            MenuItem::make(CategoryResource::class, 'Categorías'),
            MenuItem::make(AuthorResource::class, 'Autores'),
            MenuItem::make(EditorialResource::class, 'Editoriales'),
            MenuItem::make(BookResource::class, 'Libros'),
            MenuItem::make(MemberResource::class, 'Miembros'),
            MenuItem::make(LoanResource::class, 'Préstamos'),
        ];
    }

    /**
     * Le decimos a MoonShine que no renderice ningún pie de página.
     */
    protected function footer(): ?string
    {
        return null;
    }
}