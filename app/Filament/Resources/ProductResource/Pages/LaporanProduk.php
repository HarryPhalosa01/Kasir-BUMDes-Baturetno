<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use App\Models\Category;
use App\Models\Product;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Resources\Pages\Page;;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;

class LaporanProduk extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string $resource = ProductResource::class;

    protected static string $view = 'filament.resources.product-resource.pages.laporan-produk';

    protected static ?string $title = 'Laporan Produk';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->statePath('data')
            ->schema([
                Select::make('category_id')
                    ->label('Filter Berdasarkan Kategori')
                    ->options(Category::all()->pluck('name', 'id'))
                    ->placeholder('Semua Kategori'),
            ]);
    }

    public function printPdf()
    {
        $data = $this->form->getState();
        $categoryId = $data['category_id'] ?? null;

        $productsQuery = Product::query()
            ->when($categoryId, function ($query) use ($categoryId) {
                $query->where('category_id', $categoryId);
            });

        $products = $productsQuery->get();
        $categoryName = $categoryId ? Category::find($categoryId)->name : 'Semua Kategori';

        $pdf = Pdf::loadView('pdf.reports.produk', [
            'products' => $products,
            'categoryName' => $categoryName,
        ]);

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'laporan-produk-' . date('Y-m-d') . '.pdf');
    }
}