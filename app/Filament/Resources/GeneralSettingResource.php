<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GeneralSettingResource\Pages;
use App\Filament\Resources\GeneralSettingResource\RelationManagers;
use App\Models\GeneralSetting;
use App\Services\Components\FormComponents;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class GeneralSettingResource extends Resource
{
    protected static ?string $model = GeneralSetting::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog-8-tooth';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('General Settings')->schema([
                    FormComponents::siteNameInput(),
                    FormComponents::siteDescriptionTextarea(),
                ]),
                Section::make('Logo Settings')->schema([
                    FormComponents::logoImageUpload('logo'),
                    FormComponents::faviconUpload('logo'),
                    FormComponents::logoAltTextInput(),
                ]),
                // Section::make('Contact Settings')->schema([
                //     FormComponents::siteContactRepeater(),
                // ]),
                // Section::make('Footer Settings')->schema([
                //     FormComponents::siteFooterRepeater(),
                // ]),
                // Section::make('Social Settings')->schema([
                //     FormComponents::siteSocialRepeater(),
                // ]),
                // Section::make('Copyright Settings')->schema([
                //     FormComponents::siteCopyrightRepeater(),
                // ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListGeneralSettings::route('/'),
            'create' => Pages\CreateGeneralSetting::route('/create'),
            'edit' => Pages\EditGeneralSetting::route('/{record}/edit'),
        ];
    }
}
