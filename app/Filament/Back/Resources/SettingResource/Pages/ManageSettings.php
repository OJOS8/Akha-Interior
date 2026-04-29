<?php

namespace App\Filament\Back\Resources\SettingResource\Pages;

use App\Filament\Back\Resources\SettingResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageSettings extends ManageRecords
{
    protected static string $resource = SettingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
