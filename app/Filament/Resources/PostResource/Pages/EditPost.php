<?php

namespace App\Filament\Resources\PostResource\Pages;

use App\Filament\Resources\PostResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPost extends EditRecord
{
    protected static string $resource = PostResource::class;

    protected function getRedirectUrl(): ?string
    {
        return $this->getResource()::getUrl('index');
    }
    protected function getSavedNotificationTitle(): ?string
    {
        return 'Post Updated Success';
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\CreateAction::make()->label('Create Post')->icon('heroicon-o-plus')->size('md'),
        ];
    }
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['is_active'] = $data['is_active'];
        return $data;
    }
}
