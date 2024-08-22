<?php

namespace App\Filament\Resources\DevelopmentProcessResource\Pages;

use App\Filament\Resources\DevelopmentProcessResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateDevelopmentProcess extends CreateRecord
{
    protected static string $resource = DevelopmentProcessResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->user()->id;

        return $data;
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Step Created';
    }
}
