<?php

namespace App\Filament\Resources\ServiceResource\Pages;

use App\Filament\Resources\ServiceResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditService extends EditRecord
{
    protected static string $resource = ServiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Create Service')->icon('heroicon-o-plus')->size('md'),
            Actions\ViewAction::make()->color('success')->label('view')->size('md')->icon('heroicon-o-eye'),
            Actions\DeleteAction::make()->color('danger')->label('delete')->size('md')->icon('heroicon-o-trash'),
        ];
    }



    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Service updated Successfully.';
    }
}
