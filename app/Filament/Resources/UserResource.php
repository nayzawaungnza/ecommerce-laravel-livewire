<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\RelationManagers\OrdersRelationManager;
use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\DateTimePicker;
use App\Filament\Resources\UserResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\UserResource\RelationManagers;
use Filament\Resources\Pages\CreateRecord;
use Filament\Tables\Columns\TextColumn;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';

    //protected static ?string $recordTitleAttribute = 'name';

    protected static ?int $navigationSort = 1;


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')->required()->label('Name'),
                TextInput::make('email')->email()->required()->unique(ignoreRecord: true)->maxLength(255)->label('Email'),
                //DateTimePicker::make('email_verified_at')->default(now())->visible(true),
                TextInput::make('password')
                    ->required(fn ($livewire) => $livewire instanceof CreateRecord)
                    ->password()
                    ->revealable()
                    ->visibleOn('create')
                    ->label('Password')
                    ->confirmed()
                    ->placeholder('Enter User Password')
                    ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                    ->dehydrated(fn ($state) => filled($state)),
                TextInput::make('password_confirmation')
                    ->dehydrated(false)
                    ->password()->required(fn ($livewire) => $livewire instanceof CreateRecord)
                    ->revealable()
                    ->visibleOn('create')
                    ->placeholder('Enter Confirm Password')
                    ->label('Password Confirm'),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Name')->sortable()->searchable(),
                TextColumn::make('email')->label('Email')->sortable()->searchable(),
                TextColumn::make('email_verified_at')->label('Email Verified')->dateTime()->sortable(),
                TextColumn::make('created_at')->label('Created')->sortable(),

            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                //
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
            OrdersRelationManager::class,
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'email'];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
