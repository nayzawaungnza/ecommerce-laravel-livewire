<?php

namespace App\Filament\Resources\DevelopmentProcessResource\Pages;

use App\Filament\Resources\DevelopmentProcessResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDevelopmentProcess extends EditRecord
{
    protected static string $resource = DevelopmentProcessResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string|null
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['user_id'] = auth()->user()->id;

        return $data;
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Step Updated';
    }
}
