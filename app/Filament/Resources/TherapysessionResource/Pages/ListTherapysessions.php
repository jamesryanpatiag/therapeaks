<?php

namespace App\Filament\Resources\TherapysessionResource\Pages;

use App\Filament\Resources\TherapysessionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use ArielMejiaDev\FilamentPrintable\Actions\PrintAction;

class ListTherapysessions extends ListRecords
{
    protected static string $resource = TherapysessionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            PrintAction::make(),
        ];
    }
}
