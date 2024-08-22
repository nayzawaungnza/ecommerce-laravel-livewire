<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\Technology;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Section;
use Illuminate\Database\Eloquent\Builder;
use App\Services\Components\FormComponents;
use App\Services\Components\TableComponents;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\TechnologyResource\Pages;
use App\Filament\Resources\TechnologyResource\RelationManagers;

class TechnologyResource extends Resource
{
    protected static ?string $model = Technology::class;

    protected static ?string $navigationIcon = 'heroicon-o-sparkles';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Technology Information')->schema([
                    FormComponents::titleTextInput(),
                    FormComponents::slugTextInput(),
                ])->columns(2),
                Section::make('Technology Content')->schema([
                    FormComponents::contentRichEditor(),
                    FormComponents::excerptTextarea(),
                ]),
                Section::make('Technology Media')->schema([
                    FormComponents::imageFileUpload('technologies/images'),
                ]),
                Section::make('SEO')->schema([
                    FormComponents::ogTitleTextInput(),
                    FormComponents::ogDescriptionTextarea(),
                    FormComponents::ogImageFileUpload('technologies/images/seo'),
                    FormComponents::twitterCardSelect(),
                    FormComponents::twitterTitleTextInput(),
                    FormComponents::twitterDescriptionTextarea(),
                    FormComponents::twitterImageFileUpload('technologies/images/seo'),
                    FormComponents::schemaJsonTextarea(),
                ]),
                Section::make('Technology Settings')->schema([
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
            'index' => Pages\ListTechnologies::route('/'),
            'create' => Pages\CreateTechnology::route('/create'),
            'edit' => Pages\EditTechnology::route('/{record}/edit'),
        ];
    }
}
