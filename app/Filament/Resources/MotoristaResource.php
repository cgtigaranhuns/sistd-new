<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MotoristaResource\Pages;
use App\Filament\Resources\MotoristaResource\RelationManagers;
use App\Models\Motorista;
use Filament\Forms;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Grid;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MotoristaResource extends Resource
{
    protected static ?string $model = Motorista::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-circle';

    protected static ?string $navigationGroup = 'Cadastros';

    protected static ?string $navigationLabel = 'Motoristas';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make('Informações Pessoais')
                    ->columns([
                        'sm' => 1,
                        'md' => 2,
                        'lg' => 3,
                        'xl' => 3,
                        'xxl' => 3,
                    ])->schema([

                        Forms\Components\TextInput::make('nome')
                            ->required()
                            ->maxLength(255)
                            ->label('Nome'),
                        Forms\Components\TextInput::make('contato')
                            ->mask('(99) 99999-9999')
                            ->required()
                            ->maxLength(255)
                            ->label('Contato'),
                        Forms\Components\TextInput::make('cnh')
                            ->required()
                            ->maxLength(20)
                            ->label('CNH'),
                        Forms\Components\Select::make('categoria_cnh')
                            ->options([
                                'A' => 'A - Motocicletas',
                                'B' => 'B - Veículos leves',
                                'C' => 'C - Veículos pesados',
                                'D' => 'D - Transporte de passageiros',
                                'E' => 'E - Combinação de veículos',
                                'AB' => 'AB - Motocicletas e veículos leves',
                                'AC' => 'AC - Motocicletas e veículos pesados',
                                'AD' => 'AD - Motocicletas e transporte de passageiros',
                                'AE' => 'AE - Motocicletas e combinação de veículos',
                                 

                            ])
                            ->required()
                            ->label('Categoria CNH'),
                        Forms\Components\DatePicker::make('validade_cnh')
                            ->required()
                            ->label('Validade CNH'),
                        Forms\Components\DatePicker::make('validade_curso_conducao')
                            ->required()
                            ->label('Validade Curso de Condução'),
                        Forms\Components\TextInput::make('numero_contrato')
                            ->required()
                            ->maxLength(50)
                            ->label('Número do Contrato'),                
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nome')
                    ->label('Nome')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('contato')
                    ->label('Contato')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('cnh')
                    ->label('CNH')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('categoria_cnh')
                    ->label('Categoria CNH')
                    ->alignCenter()
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('validade_cnh')
                    ->label('Validade CNH')
                    ->date('d/m/Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('validade_curso_conducao')
                    ->label('Validade Curso de Condução')
                    ->date('d/m/Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('numero_contrato')
                    ->label('Número do Contrato')
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    //   Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageMotoristas::route('/'),
        ];
    }
}
