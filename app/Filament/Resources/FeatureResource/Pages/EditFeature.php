<?php

namespace App\Filament\Resources\FeatureResource\Pages;

use App\Filament\Resources\FeatureResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFeature extends EditRecord
{
    protected static string $resource = FeatureResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make()->color('success')->label('view')->size('md')->icon('heroicon-o-eye'),
            Actions\DeleteAction::make()->color('danger')->label('delete')->size('md')->icon('heroicon-o-trash'),
        ];
    }



    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Feature Updated Success';
    }
}
