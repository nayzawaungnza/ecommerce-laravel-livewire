<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateProduct extends CreateRecord
{
    protected static string $resource = ProductResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // if (isset($data['images']) && is_array($data['images'])) {
        //     $data['images'] = json_encode($data['images']);
        // }

        //dd($data);
        return $data;
    }
}