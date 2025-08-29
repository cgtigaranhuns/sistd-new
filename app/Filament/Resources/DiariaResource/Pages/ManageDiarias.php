<?php

namespace App\Filament\Resources\DiariaResource\Pages;

use App\Filament\Resources\DiariaResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageDiarias extends ManageRecords
{
    protected static string $resource = DiariaResource::class;

    protected static ?string $title = 'Gerenciar Diárias';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Solicitar Diária')                
                ->icon('heroicon-o-plus')
                ->modalHeading('Criar Diária')
                ->after(function ($record) {
                   $record->user_id = auth()->user()->id;
                   $record->status = 'Entragar Documentos';
                   $record->save();
                }),
                
        ];
    }
}
