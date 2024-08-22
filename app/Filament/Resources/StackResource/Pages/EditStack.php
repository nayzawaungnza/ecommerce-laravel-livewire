<?php

namespace App\Filament\Resources\StackResource\Pages;

use App\Filament\Resources\StackResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditStack extends EditRecord
{
    protected static string $resource = StackResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }


    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Stack updated Successfully.';
    }
}
