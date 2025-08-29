<?php

namespace App\Filament\Resources\TherapysessionResource\Pages;

use App\Filament\Resources\TherapysessionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTherapysession extends EditRecord
{
    protected static string $resource = TherapysessionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
