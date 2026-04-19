<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\Sales\SaleResource;
use App\Models\Sale;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class RecentSales extends TableWidget
{
    protected int|string|array $columnSpan = [
        'md' => 1,
        'lg' => 12,
    ];

    public function table(Table $table): Table
    {
        return $table
            ->heading('Ventas recientes')
            ->description('Últimas facturas registradas para seguimiento operativo.')
            ->query(
                fn (): Builder => Sale::query()
                    ->with('distributor.branch')
                    ->latest('sale_date')
            )
            ->columns([
                TextColumn::make('sale_date')
                    ->label('Fecha')
                    ->date('d/m/Y')
                    ->sortable(),
                TextColumn::make('invoice_number')
                    ->label('Factura')
                    ->searchable(),
                TextColumn::make('distributor.branch.trade_name')
                    ->label('Distribuidora')
                    ->searchable()
                    ->placeholder('-'),
                TextColumn::make('subtotal')
                    ->label('Subtotal')
                    ->money(),
                TextColumn::make('total_tax')
                    ->label('Impuestos')
                    ->money(),
                TextColumn::make('total')
                    ->label('Total')
                    ->money()
                    ->sortable(),
            ])
            ->paginated([5, 10, 25])
            ->recordActions([
                //
            ])
            ->recordUrl(fn (Sale $record): string => SaleResource::getUrl('edit', ['record' => $record]));
    }
}
