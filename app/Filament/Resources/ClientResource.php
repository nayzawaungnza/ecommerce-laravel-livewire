<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Client;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Section;
use Illuminate\Database\Eloquent\Builder;
use App\Services\Components\FormComponents;
use App\Services\Components\TableComponents;
use App\Filament\Resources\ClientResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ClientResource\RelationManagers;

class ClientResource extends Resource
{
    protected static ?string $model = Client::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Client Information')->schema([
                    FormComponents::titleTextInput(),
                    FormComponents::slugTextInput(),
                ])->columns(2),
                Section::make('Client Content')->schema([
                    FormComponents::contentRichEditor(),
                    FormComponents::excerptTextarea(),
                ]),
                Section::make('Client Media')->schema([
                    FormComponents::imageFileUpload('clients/images'),
                ]),
                Section::make('Client Website')->schema([
                    FormComponents::websiteTextInput(),
                ]),
                Section::make('Client Settings')->schema([
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
            'index' => Pages\ListClients::route('/'),
            'create' => Pages\CreateClient::route('/create'),
            'edit' => Pages\EditClient::route('/{record}/edit'),
        ];
    }
}
