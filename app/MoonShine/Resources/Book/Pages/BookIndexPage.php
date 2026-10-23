<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Book\Pages;

use App\Models\Book;
use App\Models\Loan;
use MoonShine\Crud\JsonResponse;
use MoonShine\Laravel\Pages\Crud\IndexPage;
use MoonShine\Support\Attributes\AsyncMethod;
use MoonShine\Support\ListOf;
use MoonShine\UI\Components\ActionButton;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Image;
use MoonShine\UI\Fields\Number;
use MoonShine\UI\Fields\Select;
use MoonShine\UI\Fields\Text;

class BookIndexPage extends IndexPage
{
    protected bool $isLazy = true;

    protected function fields(): iterable
    {
        return [
            ID::make(),
            Image::make('Imagen', 'image'),
            Text::make('Título', 'title'),
            Text::make('ISBN', 'isbn'),
            
            // Quitamos textWrap(), dejamos solo el badge gris
            Text::make('Descripción', 'description')
                ->badge('gray'),
            
            Number::make('Precio', 'price'),
            Number::make('Stock', 'stock'),
            Select::make('Estado', 'status')
                ->options([
                    'available'   => 'Disponible',
                    'unavailable' => 'No disponible',
                ]),
        ];
    }

    protected function buttons(): ListOf
    {
        if (auth('moonshine')->user()?->isLector()) {
            return new ListOf(ActionButton::class, [
                ActionButton::make('Solicitar Préstamo')
                    ->canSee(fn($item) => $item->stock > 0)
                    ->method('solicitar')
                    ->icon('hand-raised'),
            ]);
        }

        return parent::buttons();
    }

    #[AsyncMethod]
    public function solicitar(JsonResponse $response): JsonResponse
    {
        $itemId = request()->get('resourceItem');
        $item = Book::find($itemId);

        if (!$item || $item->stock <= 0) {
            return $response->toast('Lo sentimos, no hay ejemplares disponibles.', 'error');
        }

        Loan::create([
            'book_id' => $item->id,
            'member_id' => 1,
            'user_id' => auth('moonshine')->user()->id,
            'loan_date' => now(),
            'due_date' => now()->addDays(15),
            'status' => 'pending',
        ]);

        return $response->toast('¡Solicitud enviada! El administrador revisará tu petición.');
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
            ActionButton::make('Carga Masiva', route('export.import-form'))
                ->icon('arrow-up-tray'),
        ];
    }

    private function exportUrl(string $format): string
    {
        return route("export.{$format}", [
            'model'  => Book::class,
            'fields' => 'id,title,isbn,price,stock,status',
            'title'  => 'Libros',
        ]);
    }
}