<?php

namespace App\Filament\Resources\ProjectResource\Pages;

use App\Filament\Resources\ProjectResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProject extends EditRecord
{
    protected static string $resource = ProjectResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Create')->icon('heroicon-o-plus')->size('md'),
            Actions\ViewAction::make()->label('View')->icon('heroicon-o-eye')->size('md'),
            Actions\DeleteAction::make()->label('Delete')->icon('heroicon-o-trash')->size('md'),
        ];
    }


    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Project updated Successfully.';
    }
}
