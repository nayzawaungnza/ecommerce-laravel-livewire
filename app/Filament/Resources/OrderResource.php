<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Order;
use App\Models\Product;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Number;
use Filament\Resources\Resource;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\ToggleButtons;
use App\Filament\Resources\OrderResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Filament\Resources\OrderResource\RelationManagers\AddressRelationManager;
use Filament\Forms\Components\Hidden;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 5;
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()->schema([
                    Section::make('Order Information')->schema([
                        Select::make('user_id')->required()->label('Customer')->relationship('user', 'name')->searchable()->preload(),
                        Select::make('payment_method')->required()->label('Payment Method')->options([
                            'stripe' => 'Stripe', 'cod' => 'Cash on Delivery'
                        ])->placeholder('please select payment method'),
                        Select::make('payment_status')->required()->label('Payment Status')
                            ->options([
                                'pending' => 'Pending',
                                'paid' => 'Paid',
                                'failed' => 'Failed'
                            ])->placeholder('please select payment status')->default('pending'),
                        ToggleButtons::make('status')->required()->inline()->default('new')
                            ->options([
                                'new' => 'New',
                                'processing' => 'Processing',
                                'shipped' => 'Shipped',
                                'delivered' => 'Delivered',
                                'canceled' => 'Canceled'
                            ])
                            ->colors([
                                'new' => 'info',
                                'processing' => 'warning',
                                'shipped' => 'success',
                                'delivered' => 'success',
                                'canceled' => 'danger'
                            ])
                            ->icons([
                                'new' => 'heroicon-m-sparkles',
                                'processing' => 'heroicon-m-arrow-path',
                                'shipped' => 'heroicon-m-truck',
                                'delivered' => 'heroicon-m-check-badge',
                                'canceled' => 'heroicon-m-x-circle'
                            ]),
                        Select::make('currency')->options([
                            'mmk' => 'MMK',
                            'usd' => 'USD',
                            'eur' => 'EUR',
                            'gbp' => 'GBP'
                        ])->default('mmk')->required()->placeholder('please select currency'),
                        Select::make('shipping_method')->options([
                            'royalexpress' => 'Royal Express',
                            'ninjavan' => 'Ninja Van',
                            'dhl' => 'DHL',
                            'beeexpress' => 'Bee Express'
                        ])->default('royalexpress')->placeholder('please select shipping method'),
                        Textarea::make('note')->label('Note')->columnSpanFull(),


                    ])->columns(2),
                    Section::make('Order Items')->schema([
                        Repeater::make('items')->relationship()->schema([ //order (items) model relationship
                            Select::make('product_id')
                                ->relationship('product', 'name') //orderitems {product} model relationship
                                ->searchable()->preload()->required()->distinct()
                                ->disableOptionsWhenSelectedInSiblingRepeaterItems()
                                ->reactive()
                                ->afterStateUpdated(fn ($state, Set $set) => $set('unit_amount', Product::find($state)?->price ?? 0))
                                ->afterStateUpdated(fn ($state, Set $set) => $set('total_amount', Product::find($state)?->price ?? 0))
                                ->columnSpan(4),
                            TextInput::make('quantity')->numeric()->label('Quantity')->required()->default(1)->minValue(1)
                                ->reactive()->afterStateUpdated(fn ($state, Set $set, Get $get) => $set('total_amount', $state * $get('unit_amount')))
                                ->columnSpan(2),
                            TextInput::make('unit_amount')->required()->disabled()->dehydrated()->columnSpan(3),
                            TextInput::make('total_amount')->required()->label('Total Amount')->numeric()->dehydrated()->columnSpan(3),
                        ])->columns(12),
                        Placeholder::make('grand_total_placeholder')->label('Grand Total')
                            ->content(function (Get $get, Set $set) {
                                $total = 0;
                                if (!$repeaters = $get('items')) {
                                    return $total;
                                }
                                foreach ($repeaters as $key => $repeater) {
                                    $total += $get("items.{$key}.total_amount");
                                }
                                $set('grand_total', $total);
                                return Number::currency($total, 'MMK');
                            }),
                        Hidden::make('grand_total')->default(0),


                    ])

                ])->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->sortable()
                    ->searchable()
                    ->label('Customer'),
                TextColumn::make('grand_total')
                    ->sortable()
                    ->numeric()
                    ->searchable()
                    ->label('Total')
                    ->money('MMK'),
                TextColumn::make('payment_method')
                    ->sortable()
                    ->searchable()
                    ->label('Payment Method'),
                TextColumn::make('payment_status')
                    ->sortable()
                    ->searchable()
                    ->label('Payment Status'),
                TextColumn::make('currency')->sortable()->searchable(),
                TextColumn::make('shipping_method')->sortable()->searchable(),

                SelectColumn::make('status')
                    ->options([
                        'new' => 'New',
                        'processing' => 'Processing',
                        'shipped' => 'Shipped',
                        'delivered' => 'Delivered',
                        'canceled' => 'Canceled'
                    ])->searchable()->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\ViewAction::make()->label('open')->color('success'),
                    Tables\Actions\DeleteAction::make()->label('delete')->color('danger'),
                ])
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            AddressRelationManager::class,
        ];
    }
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
    public static function getNavigationBadgeColor(): string|array|null
    {
        return static::getModel()::count() > 10 ? 'success' : 'danger';
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'view' => Pages\ViewOrder::route('/{record}'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
