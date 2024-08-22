<?php

namespace App\Filament\Resources\DevelopmentProcessResource\Pages;

use App\Filament\Resources\DevelopmentProcessResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDevelopmentProcesses extends ListRecords
{
    protected static string $resource = DevelopmentProcessResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Create Development Process')->icon('heroicon-o-plus')->size('md'),
        ];
    }
}
