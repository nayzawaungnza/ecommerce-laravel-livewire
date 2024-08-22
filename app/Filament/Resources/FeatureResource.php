<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Feature;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Section;
use Illuminate\Database\Eloquent\Builder;
use App\Services\Components\FormComponents;
use App\Services\Components\TableComponents;
use App\Filament\Resources\FeatureResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\FeatureResource\RelationManagers;

class FeatureResource extends Resource
{
    protected static ?string $model = Feature::class;

    protected static ?string $navigationIcon = 'heroicon-o-squares-plus';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Feature Information')->schema([
                    FormComponents::titleTextInput(),
                    FormComponents::slugTextInput(),
                ])->columns(2),
                Section::make('Feature Content')->schema([
                    FormComponents::contentRichEditor(),
                    FormComponents::excerptTextarea(),
                ]),
                Section::make('Feature Media')->schema([
                    FormComponents::imageFileUpload('features/images'),
                    FormComponents::iconFileUpload('features/icons'),
                ])->columns(2),
                Section::make('SEO')->schema([
                    FormComponents::ogTitleTextInput(),
                    FormComponents::ogDescriptionTextarea(),
                    FormComponents::ogImageFileUpload('features/images/seo'),
                    FormComponents::twitterCardSelect(),
                    FormComponents::twitterTitleTextInput(),
                    FormComponents::twitterDescriptionTextarea(),
                    FormComponents::twitterImageFileUpload('features/images/seo'),
                    FormComponents::schemaJsonTextarea(),
                ]),
                Section::make('Feature Settings')->schema([
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
            'index' => Pages\ListFeatures::route('/'),
            'create' => Pages\CreateFeature::route('/create'),
            'view' => Pages\ViewFeature::route('/{record}'),
            'edit' => Pages\EditFeature::route('/{record}/edit'),
        ];
    }
}
