<?php

namespace App\Filament\Widgets;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use App\Models\Product;
use App\Models\OrderProduct;

class ProductFavorite extends BaseWidget
{
    protected static ?int $sort = 3;
    protected static ?string $heading = 'Produk Terlaris';
    public function table(Table $table): Table
    {
        $productQuery = Product::query()
            ->select('products.*') // Tetap mengambil semua kolom dari tabel products
            // UBAH DARI withCount MENJADI withSum UNTUK MENJUMLAHKAN 'quantity'
            ->withSum('transactionItems', 'quantity')
            // URUTKAN BERDASARKAN HASIL PENJUMLAHAN (transaction_items_sum_quantity)
            ->orderBy('transaction_items_sum_quantity', 'desc')
            ->take(10);

        return $table
            ->query($productQuery)
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label('Gambar')
                    ->circular(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Produk')
                    ->searchable(),
                // TAMPILKAN HASIL PENJUMLAHAN DARI withSum
                Tables\Columns\TextColumn::make('transaction_items_sum_quantity')
                    ->label('Jumlah Terjual') // Label diubah agar lebih jelas
                    ->alignCenter(),
            ])
            ->defaultPaginationPageOption(5);
    }
}