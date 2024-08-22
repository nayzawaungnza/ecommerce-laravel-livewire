<?php

namespace App\Filament\Resources;

use App\Services\Components\FormComponents;
use App\Services\Components\TableComponents;
use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Set;
use Filament\Forms\Form;
use App\Models\StaticPage;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use Filament\Actions\ActionGroup;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\StaticPageResource\Pages;
use App\Filament\Resources\StaticPageResource\RelationManagers;

class StaticPageResource extends Resource
{
    protected static ?string $model = StaticPage::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    protected static ?string $navigationGroup = 'Content';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Title')->schema([
                    TextInput::make('title')->label('Title')
                        ->placeholder('Enter Title')->required()
                        ->afterStateUpdated(fn (String $operation, $state, Set $set) => $operation === 'create' ? $set('slug', Str::slug($state)) : null)
                        ->live(onBlur: true),
                    TextInput::make('slug')->required()->unique(ignoreRecord: true)->disabled()->dehydrated(),
                ])->columns(2),
                Section::make('Content')->schema([
                    RichEditor::make('content')->label('Content')->required()
                        ->fileAttachmentsDirectory('pages/attachments')
                        ->fileAttachmentsDisk('public')
                        ->fileAttachmentsVisibility('public')
                        ->columnSpanFull(),
                    FormComponents::excerptTextarea(),
                    FileUpload::make('image')
                        ->label('Image')
                        ->image()
                        ->imageEditor()
                        ->imageEditorAspectRatios([
                            '16:9',
                        ])
                        ->moveFiles()
                        ->fetchFileInformation(false)
                        ->directory('pages/images')
                        ->deletable(true)
                ])->columns(1),
                Section::make('Publish')->schema([
                    Toggle::make('is_active')->label('Status')->default(true),
                    FormComponents::statusSelect(),
                ])->visibleOn(['edit',  'view'])->columns(2),
                Section::make('SEO')->schema([
                    FormComponents::ogTitleTextInput(),
                    FormComponents::ogDescriptionTextarea(),
                    FormComponents::ogImageFileUpload('pages/seo/images'),
                    FormComponents::twitterCardSelect(),
                    FormComponents::twitterTitleTextInput(),
                    FormComponents::twitterDescriptionTextarea(),
                    FormComponents::twitterImageFileUpload('pages/seo/images'),
                    FormComponents::schemaJsonTextarea(),
                ])->columns(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TableComponents::titleColumn(),
                TableComponents::slugColumn(),
                TableComponents::imageColumn(),
                //TableComponents::isActiveColumn(),
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
                    Tables\Actions\EditAction::make()->color('info')->size('md'),
                    Tables\Actions\ViewAction::make()->label('view')->color('success')->size('md'),
                    Tables\Actions\DeleteAction::make()->label('delete')->color('danger')->size('md'),
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
            'index' => Pages\ListStaticPages::route('/'),
            'create' => Pages\CreateStaticPage::route('/create'),
            'edit' => Pages\EditStaticPage::route('/{record}/edit'),
        ];
    }
}
