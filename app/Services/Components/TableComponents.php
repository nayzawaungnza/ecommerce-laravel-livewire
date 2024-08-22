<?php

namespace App\Services\Components;

use App\Services\Enums\Status;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;

class TableComponents
{
    public static function titleColumn()
    {
        return TextColumn::make('title')->label('Title')->searchable()->sortable();
    }
    public static function slugColumn()
    {
        return TextColumn::make('slug')->label('Slug')->searchable()->sortable();
    }
    public static function imageColumn()
    {
        return ImageColumn::make('image')->label('Image')->searchable()->sortable();
    }
    public static function createdByColumn()
    {
        return TextColumn::make('user.name')->label('Created By')->searchable()->sortable();
    }
    public static function excerptTextColumn()
    {
        return TextColumn::make('excerpt')->label('Excerpt')->limit(50);
    }

    public static function statusColumn()
    {
        return TextColumn::make('status')->label('Status')
            ->badge()->color(Status::class)->sortable();
    }
    public static function isActiveColumn()
    {
        return IconColumn::make('is_active')->label('Active')->boolean();
    }
}
