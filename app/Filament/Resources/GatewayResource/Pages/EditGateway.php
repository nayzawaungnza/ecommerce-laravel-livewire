<?php

namespace App\Filament\Resources\GatewayResource\Pages;

use App\Filament\Resources\GatewayResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditGateway extends EditRecord
{
    protected static string $resource = GatewayResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()->color('danger')->icon('heroicon-o-trash')->size('md'),
        ];
    }
    protected function getRedirectUrl(): string|null
    {
        return $this->getResource()::getUrl('index');
    }



    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Gateway updated';
    }
}
