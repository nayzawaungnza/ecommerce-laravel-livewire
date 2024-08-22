<?php

namespace App\Filament\Resources;

use App\Services\Components\TableComponents;
use Filament\Forms;
use Filament\Tables;
use App\Models\Service;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Section;
use Illuminate\Database\Eloquent\Builder;
use App\Services\Components\FormComponents;
use App\Filament\Resources\ServiceResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ServiceResource\RelationManagers;
use Filament\Actions\ActionGroup;
use Filament\Tables\TableComponent;

class ServiceResource extends Resource
{
    protected static ?string $model = Service::class;

    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Service Information')->schema([
                    FormComponents::titleTextInput(),
                    FormComponents::slugTextInput(),
                ])->columns(2),
                Section::make('Content')->schema([
                    FormComponents::contentRichEditor(),
                    FormComponents::excerptTextarea(),
                ]),
                Section::make('Image')->schema([
                    FormComponents::imageFileUpload('services/images'),
                    FormComponents::iconFileUpload('services/icons'),
                    FormComponents::galleryFileUpload('services/galleriesimages'),
                ])->columns(2),
                Section::make('Has Services Card?')->schema([
                    FormComponents::serviceCardRepeater(),
                ]),
                Section::make('Actions')->schema([
                    FormComponents::actionsRepeater(),
                ]),
                Section::make('Static Card')->schema([
                    FormComponents::staticCardRepeater(),
                ]),
                Section::make('Status & Visibility')->schema([
                    FormComponents::statusSelect(),

                ])->visibleOn(['view', 'edit']),
                Section::make('SEO')->schema([
                    FormComponents::ogTitleTextInput(),
                    FormComponents::ogDescriptionTextarea(),
                    FormComponents::ogImageFileUpload('services/seo/images'),
                    FormComponents::twitterCardSelect(),
                    FormComponents::twitterTitleTextInput(),
                    FormComponents::twitterDescriptionTextarea(),
                    FormComponents::twitterImageFileUpload('services/seo/images'),
                    FormComponents::schemaJsonTextarea(),

                ])

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TableComponents::titleColumn(),
                TableComponents::slugColumn(),
                TableComponents::imageColumn(),

                TableComponents::statusColumn(),

                TableComponents::createdByColumn(),

            ])
            ->filters([
                //
            ])
            ->recordUrl(null)
            ->defaultSort('created_at', 'desc')
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make()->color('success')->label('view')->size('md'),
                    Tables\Actions\EditAction::make()->color('info')->size('md'),
                    Tables\Actions\DeleteAction::make()->color('danger')->size('md'),
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
            'index' => Pages\ListServices::route('/'),
            'create' => Pages\CreateService::route('/create'),
            'view' => Pages\ViewService::route('/{record}'),
            'edit' => Pages\EditService::route('/{record}/edit'),
        ];
    }
}
