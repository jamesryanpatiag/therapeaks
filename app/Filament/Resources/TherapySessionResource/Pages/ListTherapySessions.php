<?php

namespace App\Filament\Resources\TherapySessionResource\Pages;

use App\Filament\Resources\TherapySessionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use ArielMejiaDev\FilamentPrintable\Actions\PrintAction;

class ListTherapySessions extends ListRecords
{
    protected static string $resource = TherapySessionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            PrintAction::make(),
        ];
    }
}
