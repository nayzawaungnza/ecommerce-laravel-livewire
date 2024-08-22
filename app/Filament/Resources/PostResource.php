<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Post;
use Filament\Tables;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\PostResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PostResource\RelationManagers;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-document';

    protected static ?string $navigationGroup = 'Content';

    protected static ?int $navigationSort = 2;

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
                        ->fileAttachmentsDirectory('posts/attachments')
                        ->fileAttachmentsDisk('public')
                        ->fileAttachmentsVisibility('public')
                        ->columnSpanFull(),
                    FileUpload::make('image')
                        ->label('Image')
                        ->image()
                        ->imageEditor()
                        ->imageEditorAspectRatios([
                            '4:3',
                        ])
                        ->moveFiles()
                        ->fetchFileInformation(false)
                        ->directory('posts/images')
                        ->deletable(true)
                ])->columns(1),
                Section::make('Publish')->schema([
                    Toggle::make('is_active')->label('Status')->default(true),
                ])->visibleOn(['edit',  'view'])->columns(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->label('Title')->searchable()->sortable(),
                TextColumn::make('slug')->label('Slug')->searchable()->sortable(),
                ImageColumn::make('image')->label('Image')->searchable()->sortable(),
                IconColumn::make('is_active')->label('Status')->boolean(),
                TextColumn::make('user.name')->label('Created By')->searchable()->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordUrl(null)
            ->defaultSort('created_at', 'desc')
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
