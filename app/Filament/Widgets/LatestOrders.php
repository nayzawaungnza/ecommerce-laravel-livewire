<?php

namespace App\Filament\Widgets;

use Filament\Tables;
use App\Models\Order;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use App\Filament\Resources\OrderResource;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestOrders extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';
    protected static ?int $sort = 2;
    public function table(Table $table): Table
    {
        return $table
            ->query(OrderResource::getEloquentQuery())
            ->defaultPaginationPageOption(5)->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('id')->label('Order ID')->searchable(),
                TextColumn::make('user.name')->label('Customer')->searchable()->sortable(),
                TextColumn::make('grand_total')->money('MMK')->label('Total Amount')->sortable()->searchable(),
                TextColumn::make('status')->label('Status')->searchable()
                    ->badge()
                    ->colors([
                        'new' => 'info',
                        'processing' => 'warning',
                        'shipped' => 'success',
                        'delivered' => 'success',
                        'canceled' => 'danger'
                    ])
                    ->icon(fn (string $state): string => match ($state) {
                        'new' => 'heroicon-m-sparkles',
                        'processing' => 'heroicon-m-arrow-path',
                        'shipped' => 'heroicon-m-truck',
                        'delivered' => 'heroicon-m-check-badge',
                        'canceled' => 'heroicon-m-x-circle'
                    })->sortable(),
                TextColumn::make('payment_method')
                    ->sortable()
                    ->searchable()
                    ->label('Payment Method'),
                TextColumn::make('payment_status')
                    ->sortable()->badge()
                    ->searchable()
                    ->label('Payment Status'),
                TextColumn::make('created_at')->label('Order Date')->dateTime()
            ])
            ->actions([
                Action::make('View Order')
                    ->url(fn (Order $record): string => OrderResource::getUrl('view', ['record' => $record]))
                    ->color('success')->icon('heroicon-o-eye'),
            ]);
    }
}
