<?php

namespace App\Filament\Resources\SetorResource\Pages;

use App\Filament\Resources\SetorResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageSetors extends ManageRecords
{
    protected static string $resource = SetorResource::class;

    protected static ?string $title = 'Gerenciar Setores';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Adicionar Setor')
                ->icon('heroicon-o-plus')
                ->color('primary'),
        ];
    }
}
