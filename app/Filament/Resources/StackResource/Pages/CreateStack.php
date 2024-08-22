<?php

namespace App\Filament\Resources\StackResource\Pages;

use App\Filament\Resources\StackResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateStack extends CreateRecord
{
    protected static string $resource = StackResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->user()->id;
        //dd($data);
        return $data;
    }


    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Stack created Successfully.';
    }
}
