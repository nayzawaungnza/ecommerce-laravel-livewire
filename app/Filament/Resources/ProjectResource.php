<?php

namespace App\Filament\Resources;

use App\Services\Components\FormComponents;
use App\Services\Components\TableComponents;
use Filament\Tables;
use App\Models\Project;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Section;
use App\Filament\Resources\ProjectResource\Pages;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-group';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Project Information')->schema([
                    FormComponents::titleTextInput(),
                    FormComponents::slugTextInput(),
                    FormComponents::subtitleTextInput()
                ])->columns(2)->collapsible(),
                Section::make('Content')->schema([
                    FormComponents::contentRichEditor(),
                    FormComponents::excerptTextarea(),
                ])->collapsible(),

                Section::make('Media')->schema([
                    FormComponents::imageFileUpload('projects/images'),
                    FormComponents::galleryFileUpload('projects/galleries/images'),
                    FormComponents::videoFileUpload('projects/videos'),
                ])->columns(3)->collapsible(),
                Section::make('challenges')->schema([
                    FormComponents::challengesRepeater(),
                ])->collapsible(),
                Section::make('Systems')->schema([
                    FormComponents::systemTitleTextInput(),
                    FormComponents::systemDescriptionTextarea(),
                    FormComponents::systemDesktopFileUpload(),
                    FormComponents::systemMobileFileupload(),

                ])->columns(2)->collapsible(),
                Section::make('Colors')->schema([
                    FormComponents::colorRepeater(),
                    FormComponents::colorschemeImageFileUpload('projects/colorscheme/images'),
                ])->columns(2)->collapsible(),
                Section::make('Typography')->label('Typography')->schema([
                    FormComponents::typographyImageFileUpload('projects/typography/images'),
                ])->collapsible(),
                Section::make('Call to Action')->schema([
                    FormComponents::callToActionRepeater(),
                ])->columns(1)->collapsible(),
                Section::make('Approach')->schema([
                    FormComponents::approachesRepeater(),
                ])->collapsible(),

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
            'index' => Pages\ListProjects::route('/'),
            'create' => Pages\CreateProject::route('/create'),
            'view' => Pages\ViewProject::route('/{record}'),
            'edit' => Pages\EditProject::route('/{record}/edit'),
        ];
    }
}
