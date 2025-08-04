<?php

namespace App\Filament\Resources\MotoristaResource\Pages;

use App\Filament\Resources\MotoristaResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageMotoristas extends ManageRecords
{
    protected static string $resource = MotoristaResource::class;

    protected static ?string $title = 'Gerenciar Motoristas';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Adicionar Motorista')
                ->icon('heroicon-o-plus')
                ->color('primary'),
        ];
    }
}
