<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Product;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\ProductResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ProductResource\RelationManagers;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?int $navigationSort = 4;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $recordTitleAttribute = 'name';
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()->schema([
                    Section::make('Product Information')->schema([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255)->live(onBlur: true)
                            ->afterStateUpdated(fn (String $operation, $state, Set $set) => $operation === 'create' ? $set('slug', Str::slug($state)) : null)->columnspan(1),
                        TextInput::make('slug')
                            ->required()->disabled()->dehydrated()->unique(Product::class, 'slug', ignoreRecord: true)
                            ->maxLength(255)->columnspan(1),
                        TextInput::make('sku')->required()->unique(ignoreRecord: true)->maxLength(255)->columnspan(1),
                        TextInput::make('quantity')
                            ->label('Quantity')->integer()
                            ->nullable(),

                        RichEditor::make('description')
                            ->required()->fileAttachmentsDisk('public')->fileAttachmentsDirectory('products/attachments')->columnSpanFull(),
                        Textarea::make('short_description')
                            ->label('Short Description')
                            ->required()->columnSpanFull(),
                    ])->columns(2),
                    Section::make('Image')->schema([
                        FileUpload::make('images')
                            ->label('Product Images')
                            ->image()
                            ->imageEditorAspectRatios([
                                '1:1',
                            ])
                            ->multiple()
                            ->directory('products')
                            ->maxFiles(5)
                            ->multiple(true)
                            ->reorderable(),
                    ]),
                ])->columnSpan(2),

                Group::make()->schema([
                    Section::make('Price')->schema([
                        TextInput::make('price')
                            ->required()
                            ->numeric()
                            ->prefix('MMK'),

                    ]),
                    Section::make('Association')->schema([
                        Select::make('category_id')->searchable()
                            ->required()->preload()->relationship('category', 'name'),
                        Select::make('brand_id')->searchable()
                            ->required()->preload()->relationship('brand', 'name')
                    ]),
                    Section::make('Weight & Dimensions')->schema([
                        TextInput::make('weight')
                            ->label('Weight (kg)')
                            ->numeric()
                            ->step('0.01')
                            ->nullable(),
                        TextInput::make('dimensions')
                            ->label('Dimensions (LxWxH)')
                            ->nullable(),
                    ]),

                    Section::make('Sizes & Colors')->schema([
                        Repeater::make('sizes')
                            ->schema([
                                TextInput::make('name')
                                    ->label('Size Name')
                                    ->required(),
                                TextInput::make('price')
                                    ->label('Size Price')
                                    ->numeric()
                                    ->required(),
                            ])
                            ->label('Sizes')
                            ->collapsed(),
                        Repeater::make('colors')
                            ->schema([
                                TextInput::make('name')
                                    ->label('Color Name')
                                    ->required(),
                                TextInput::make('code')
                                    ->label('Color Code')
                                    ->required(),
                            ])
                            ->label('Colors')
                            ->collapsed(),
                    ]),
                    Section::make('Status')->schema([
                        Toggle::make('in_stock')
                            ->default(true),
                        Toggle::make('is_active')
                            ->required()->default(true),
                        Toggle::make('is_featured'),
                        Toggle::make('on_sale'),
                    ])

                ])->columnSpan(1),





            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('slug')
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
                Tables\Columns\TextColumn::make('price')
                    ->money('MMK')
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_featured')
                    ->boolean(),
                Tables\Columns\IconColumn::make('in_stock')
                    ->boolean(),
                Tables\Columns\IconColumn::make('on_sale')
                    ->boolean(),
                Tables\Columns\TextColumn::make('category.name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('brand.name')
                    ->sortable(),
                Tables\Columns\ImageColumn::make('images')
                    ->label('Post Images')
                    ->getStateUsing(function ($record) {
                        $images = is_array($record->images) ? $record->images : json_decode($record->images, true);
                        return $images ? $images[0] : null; // Display the first image as a preview
                    })
                    ->extraAttributes(['class' => 'w-16 h-16']),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('Filter by Category')->relationship('category', 'name'),
                SelectFilter::make('Filter by Brand')->relationship('brand', 'name')
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
