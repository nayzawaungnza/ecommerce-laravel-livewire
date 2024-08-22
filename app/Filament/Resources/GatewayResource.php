<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Gateway;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Section;
use Illuminate\Database\Eloquent\Builder;
use App\Services\Components\FormComponents;
use App\Services\Components\TableComponents;
use App\Filament\Resources\GatewayResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\GatewayResource\RelationManagers;

class GatewayResource extends Resource
{
    protected static ?string $model = Gateway::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Gateway Information')->schema([
                    FormComponents::titleTextInput(),
                ])->columns(2),
                Section::make('Gateway Content')->schema([
                    FormComponents::contentRichEditor(),
                ]),
                Section::make('Gateway Media')->schema([
                    FormComponents::imageFileUpload('gateways/images'),
                ]),

                Section::make('Gateway Settings')->schema([
                    FormComponents::statusSelect(),
                ])->visibleOn(['edit', 'view']),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TableComponents::titleColumn(),
                TableComponents::slugColumn(),
                TableComponents::createdByColumn(),
                TableComponents::statusColumn(),
            ])
            ->filters([
                //
            ])
            ->recordUrl(null)
            ->defaultSort('created_at', 'desc')
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make()->label('View')->icon('heroicon-o-eye')->size('md'),
                    Tables\Actions\EditAction::make()->label('Edit')->icon('heroicon-o-pencil')->size('md'),
                    Tables\Actions\DeleteAction::make()->label('Delete')->icon('heroicon-o-trash')->size('md'),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGateways::route('/'),
            'create' => Pages\CreateGateway::route('/create'),
            'edit' => Pages\EditGateway::route('/{record}/edit'),
        ];
    }
}
