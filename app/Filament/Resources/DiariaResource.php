<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DiariaResource\Pages;
use App\Filament\Resources\DiariaResource\RelationManagers;
use App\Models\Diaria;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DiariaResource extends Resource
{
    protected static ?string $model = Diaria::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';

    protected static ?string $navigationGroup = 'Solicitações';

    protected static ?string $navigationLabel = 'Diárias';

    protected static ?string $modalwidth = '3xl';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Tabs::make('Diária')
                    ->tabs([
                        Forms\Components\Tabs\Tab::make('Dados Pessoais')
                            ->schema([
                                Forms\Components\ToggleButtons::make('tipo_solicitante')
                                    ->label('Tipo de Solicitante')
                                    ->options([
                                        'Própria' => 'Própria',
                                        'Terceiros' => 'Terceiros',
                                    ])
                                    ->colors([
                                        'Própria' => 'success',
                                        'Terceiros' => 'danger',
                                    ])
                                    ->icons([
                                        'Própria' => 'heroicon-o-user-circle',
                                        'Terceiros' => 'heroicon-o-users',
                                    ])
                                    ->default('Própria')
                                    ->inline()
                                    ->live()
                                    ->columnSpanFull()
                                    ->required(),

                                Forms\Components\TextInput::make('nome')
                                    ->label('Nome')
                                    ->required()
                                    ->maxLength(255)
                                    ->columnSpan([
                                        'sm' => 1,
                                        'md' => 2,
                                        'xl' => 2,
                                    ]),
                                Forms\Components\TextInput::make('cpf')
                                    ->label('CPF')
                                    ->required()
                                    ->maxLength(14)
                                    ->mask('000.000.000-00'),
                                Forms\Components\TextInput::make('rg')
                                    ->label('RG')
                                    ->required()
                                    ->maxLength(20),
                                Forms\Components\TextInput::make('orgao_expedidor')
                                    ->label('Órgão Expedidor')
                                    ->required()
                                    ->maxLength(50),
                                Forms\Components\DatePicker::make('data_nascimento')
                                    ->required()
                                    ->label('Data de Nascimento'),
                                Forms\Components\TextInput::make('telefone')
                                    ->label('Telefone')
                                    ->required()
                                    ->maxLength(15)
                                    ->mask('(00) 00000-0000'),
                                Forms\Components\TextInput::make('email')
                                    ->label('E-mail')
                                    ->email()
                                    ->required()
                                    ->maxLength(255)
                                    ->columnSpan([
                                        'sm' => 1,
                                        'md' => 2,
                                        'xl' => 2,
                                    ]),
                                Forms\Components\Select::make('banco_id')
                                    ->label('Banco')
                                    ->relationship('banco', 'nome')
                                    ->required()
                                    ->searchable()
                                    ->preload()
                                    ->nullable(),
                                Forms\Components\TextInput::make('agencia')
                                    ->label('Agência')
                                    ->required()
                                    ->maxLength(20),
                                Forms\Components\TextInput::make('conta_corrente')
                                    ->label('Conta Corrente')
                                    ->required()
                                    ->maxLength(20),
                                Forms\Components\Select::make('tipo_conta')
                                    ->label('Tipo de Conta')
                                    ->options([
                                        'Corrente' => 'Corrente',
                                        'Poupança' => 'Poupança',
                                        'Salário' => 'Salário',
                                        'Outros' => 'Outros',
                                    ])
                                    ->required(),
                                Forms\Components\TextInput::make('orgao_setor_lotacao')
                                    ->label('Órgão/Setor de Lotação (para terceiros)')
                                    ->visible(fn(Forms\Get $get) => $get('tipo_solicitante') === 'Terceiros')
                                    ->maxLength(255)
                                    ->required()
                                    ->columnSpan([
                                        'sm' => 1,
                                        'md' => 2,
                                        'xl' => 2,
                                    ]),
                            ])
                            ->columns([
                                'sm' => 1,
                                'md' => 2,
                                'xl' => 3,
                            ]),
                        Forms\Components\Tabs\Tab::make('Dados Institucionais')
                            ->schema([
                                Forms\Components\Select::make('tipo_solicitacao')
                                    ->label('Tipo de Solicitação')
                                    ->options([
                                        'Servidor Federal' => 'Servidor Federal',
                                        'Servidor Estadual' => 'Servidor Estadual',
                                        'Servidor Municipal' => 'Servidor Municipal',
                                        'Empregado Público' => 'Empregado Público',
                                        'Colaborador Eventual' => 'Colaborador Eventual',
                                        'Outros' => 'Outros',
                                    ])
                                    ->visible(fn(Forms\Get $get) => $get('tipo_solicitante') === 'Terceiros')
                                    ->default('Servidor Federal')
                                    ->live()
                                    ->required(),
                                Forms\Components\TextInput::make('outros_tipo_solicitante')
                                    ->label('Especifique se Outros')
                                    ->visible(fn(Forms\Get $get) => $get('tipo_solicitante') === 'Terceiros' && $get('tipo_solicitacao') === 'Outros')
                                    ->required()
                                    ->maxLength(255)
                                    ->columnSpan([
                                        'sm' => 1,
                                        'md' => 2,
                                        'xl' => 2,
                                    ]),


                                Forms\Components\TextInput::make('siape')
                                    ->label('SIAPE')
                                    ->visible(fn(Forms\Get $get) => $get('tipo_solicitante') === 'Própria')
                                    ->required()
                                    ->maxLength(20)
                                    ->columnSpan([
                                        'sm' => 1,
                                        'md' => 1,
                                        'xl' => 1,
                                    ]),
                                Forms\Components\Select::make('cargo_funcao')
                                    ->label('Cargo')
                                    ->options([
                                        'Professor' => 'Professor',
                                        'Técnico Administrativo' => 'Técnico Administrativo',
                                        'Estudante' => 'Estudante',
                                        'Outros' => 'Outros',
                                    ])
                                    ->required()
                                    ->columnSpan([
                                        'sm' => 1,
                                        'md' => 1,
                                        'xl' => 1,
                                    ]),
                                Forms\Components\Select::make('escolaridade_cargo')
                                    ->label('Escolaridade do Cargo/Função')
                                    ->required()
                                    ->options([
                                        'Fundamental' => 'Fundamental',
                                        'Médio' => 'Médio',
                                        'Superior' => 'Superior',
                                    ])                                    
                                    ->columnSpan([
                                        'sm' => 1,
                                        'md' => 1,
                                        'xl' => 1,
                                    ]),
                                Forms\Components\TextInput::make('descricao_cargo_funcao')
                                    ->label('Descrição do Cargo/Função')
                                    ->visible(fn(Forms\Get $get) => $get('tipo_solicitante') === 'Terceiros')
                                    ->maxLength(255)
                                    ->required()
                                    ->columnSpanFull(),
                                Forms\Components\ToggleButtons::make('auxilio_transporte')
                                    ->label('Auxílio Transporte')
                                    ->boolean()
                                    ->grouped()
                                    ->live()
                                    ->required()
                                    ->columnSpan([
                                        'sm' => 1,
                                        'md' => 1,
                                        'xl' => 1,
                                    ]),
                                Forms\Components\ToggleButtons::make('forma_auxilio_transporte')
                                    ->label('Forma do Auxílio Transporte')
                                    ->visible(fn(Forms\Get $get) => $get('auxilio_transporte') == true && $get('tipo_solicitante') === 'Própria')
                                    ->options([
                                        'Semanal' => 'Semanal',
                                        'Final de Semana' => 'Final de Semana',
                                    ])
                                    ->icons([
                                        'Semanal' => 'heroicon-o-calendar',
                                        'Final de Semana' => 'heroicon-o-sun',
                                    ])
                                    ->columnSpan([
                                        'sm' => 1,
                                        'md' => 1,
                                        'xl' => 1,
                                    ]),
                                Forms\Components\TextInput::make('valor_vale_transporte')
                                    ->label('Valor do Vale Transporte')
                                    ->numeric()
                                    ->visible(fn(Forms\Get $get) => $get('auxilio_transporte') == true && $get('tipo_solicitante') === 'Terceiros')
                                    ->required()
                                    ->prefix('R$')                                    
                                    ->columnSpan([
                                        'sm' => 1,
                                        'md' => 1,
                                        'xl' => 1,
                                    ]),
                                Forms\Components\TextInput::make('valor_vale_alimentacao')
                                    ->label('Valor do Vale Alimentação')
                                    ->numeric()
                                     ->visible(fn(Forms\Get $get) => $get('auxilio_transporte') == true && $get('tipo_solicitante') === 'Terceiros')
                                    ->prefix('R$')
                                    ->required()
                                    ->columnSpan([
                                        'sm' => 1,
                                        'md' => 1,
                                        'xl' => 1,
                                    ]),
                            ])
                            ->columns([
                                'sm' => 1,
                                'md' => 2,
                                'xl' => 3,
                            ]),
                        Forms\Components\Tabs\Tab::make('Dados da Viagem')
                            ->schema([
                                Forms\Components\ToggleButtons::make('tipo_diaria')
                                    ->label('Tipo de Diária')
                                    ->inline()
                                    ->required()
                                    ->options([
                                        'Diárias' => 'Diárias',
                                        'Diárias e Passagens' => 'Diárias e Passagens',
                                    ])                                    
                                    ->columnSpan([
                                        'sm' => 1,
                                        'md' => 2,
                                    ]),

                                Forms\Components\DateTimePicker::make('data_hora_saida')
                                    ->label('Data e Hora de Saída')                                   
                                    ->required()
                                    ->columnSpan([
                                        'sm' => 1,
                                        'md' => 1,
                                    ]),
                                Forms\Components\DateTimePicker::make('data_hora_retorno')
                                    ->label('Data e Hora de Retorno')
                                    ->required()
                                    ->columnSpan([
                                        'sm' => 1,
                                        'md' => 1,
                                    ]),

                                Forms\Components\DateTimePicker::make('data_hora_evento')
                                    ->label('Data e Hora do Evento')
                                    ->required()
                                    ->live()
                                    ->columnSpan([
                                        'sm' => 1,
                                        'md' => 1,
                                    ]),
                                Forms\Components\DateTimePicker::make('data_hora_fim_evento')
                                    ->label('Data e Hora do Fim do Evento')
                                    ->required()
                                    ->columnSpan([
                                        'sm' => 1,
                                        'md' => 1,
                                    ]),

                                Forms\Components\Select::make('estado_id')
                                    ->label('Estado')
                                    ->relationship('estado', 'nome')
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->columnSpan([
                                        'sm' => 1,
                                        'md' => 1,
                                    ]),
                                Forms\Components\Select::make('cidade_id')
                                    ->label('Cidade')
                                    ->relationship('cidade', 'nome')
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->columnSpan([
                                        'sm' => 1,
                                        'md' => 1,
                                    ]),
                                 Forms\Components\ToggleButtons::make('tipo_intinerario')
                                    ->label('Tipo de Itinerário')
                                    ->grouped()
                                    ->required()
                                    ->live()
                                    ->options([
                                        0 => 'Único Local',
                                        1 => 'Múltiplos Locais (com pernoites)',
                                    ])
                                    ->colors([
                                        0 => 'success',
                                        1 => 'warning',
                                    ])
                                    ->icons([
                                        0 => 'heroicon-o-sun',
                                        1 => 'heroicon-o-moon',
                                    ])
                                    ->columnSpanFull(),                    

                                Forms\Components\Repeater::make('intinerario')
                                    ->label('Itinerário da Viagem com Pernoites')
                                    ->visible(fn(Forms\Get $get) => $get('tipo_intinerario') == true)
                                    ->minItems(1)
                                    ->addActionLabel('Adicionar Local e Data/Hora dos Pernoites')
                                    ->schema([
                                        Forms\Components\TextInput::make('local')
                                            ->label('Local')
                                            ->required()
                                            ->maxLength(255),
                                        Forms\Components\DateTimePicker::make('data_hora')
                                            ->label('Data e Hora')
                                            ->required(),
                                    ])
                                    ->columns([
                                        'sm' => 1,
                                        'md' => 2,
                                    ])
                                    ->columnSpanFull(),                                    
                                Forms\Components\Select::make('transporte_ida')
                                    ->label('Transporte de Ida')
                                    ->options([
                                        'Carro Oficial' => 'Carro Oficial',
                                        'Carro Próprio' => 'Carro Próprio',
                                        'Aéreo' => 'Aéreo',
                                        'Rodoviário' => 'Rodoviário',
                                        'Trem' => 'Trem',
                                        'Carro Oficial + Aéreo' => 'Carro Oficial + Aéreo',
                                        'Carro Oficial + Carro Próprio' => 'Carro Oficial + Carro Próprio',                                        
                                        'Carro Oficial + Rodoviário' => 'Carro Oficial + Rodoviário',
                                        'Carro Oficial + Trem' => 'Carro Oficial + Trem',
                                    ])
                                    ->required()
                                    ->columnSpan([
                                        'sm' => 1,
                                        'md' => 1,
                                    ]),
                                Forms\Components\Select::make('transporte_volta')
                                    ->label('Transporte de Volta')
                                    ->options([
                                        'Carro Oficial' => 'Carro Oficial',
                                        'Carro Próprio' => 'Carro Próprio',
                                        'Aéreo' => 'Aéreo',     
                                        'Rodoviário' => 'Rodoviário',
                                        'Trem' => 'Trem',
                                        'Carro Oficial + Aéreo' => 'Carro Oficial + Aéreo   
',                                     'Carro Oficial + Carro Próprio' => 'Carro Oficial + Carro Próprio',                                       
                                        'Carro Oficial + Rodoviário' => 'Carro Oficial + Rodoviário',
                                        'Carro Oficial + Trem' => 'Carro Oficial + Trem',
                                    ])
                                    ->required()
                                    ->columnSpan([
                                        'sm' => 1,
                                        'md' => 1,
                                    ]),

                                Forms\Components\TextInput::make('local_evento')
                                    ->label('Local do Evento')
                                    ->maxLength(255)
                                    ->required()
                                    ->columnSpan([
                                        'sm' => 1,
                                        'md' => 2,
                                    ]),

                                Forms\Components\Select::make('finalidade_viagem')
                                    ->label('Finalidade da Viagem')
                                    ->options([
                                        'Reunião Técnica' => 'Reunião Técnica',
                                        'Visita Técnica' => 'Visita Técnica',
                                        'Capacitação/Curso' => 'Capacitação/Curso',
                                        'Evento/Congresso/Seminário' => 'Evento/Congresso/Seminário',
                                        'Outros' => 'Outros',
                                    ])
                                    ->required()
                                    ->live()
                                    ->columnSpan([
                                        'sm' => 1,
                                        'md' => 1,
                                    ]),
                                Forms\Components\TextInput::make('outro_finalidade_viagem')
                                    ->label('Especifique se Outros')
                                    ->maxLength(255)
                                    ->required()
                                    ->visible(fn(Forms\Get $get) => $get('finalidade_viagem') === 'Outros')
                                    ->columnSpan([
                                        'sm' => 1,
                                        'md' => 1,
                                    ]),

                                Forms\Components\Textarea::make('descricao_finalidade_viagem')
                                    ->label('Descrição da Finalidade da Viagem')
                                    ->autosize()
                                    ->required()
                                    ->columnSpan([
                                        'sm' => 1,
                                        'md' => 2,
                                    ]),

                                Forms\Components\Textarea::make('justificativa_data_viagem')
                                    ->label('Justificativa da Data da Viagem')
                                    ->autosize()
                                    ->required()
                                    ->columnSpan([
                                        'sm' => 1,
                                        'md' => 2,
                                    ]),

                                Forms\Components\Textarea::make('justificativa_05_dias_evento')
                                    ->label('Justificativa para Solicitação com menos de 5 dias do Evento')
                                    ->required()
                                    ->visible(fn(Forms\Get $get) => now()->diffInDays($get('data_hora_evento'), false) < 5)
                                    ->autosize()
                                    ->columnSpan([
                                        'sm' => 1,
                                        'md' => 2,
                                    ]),

                               

                                Forms\Components\Toggle::make('ciente_diaria')
                                    ->label('Ciente dos Termos para Solicitação de Diária')                                    
                                    ->required()
                                    ->columnSpan([
                                        'sm' => 1,
                                        'md' => 2,
                                    ]),
                            ])
                            ->columns([
                                'sm' => 1,
                                'md' => 2,
                            ]),
                        Forms\Components\Tabs\Tab::make('Prestação de Contas')
                            ->schema([
                                Forms\Components\Toggle::make('prestacao_contas')
                                    ->label('Prestação de Contas')
                                    ->onColor('success')
                                    ->offColor('secondary')
                                    ->nullable(),
                                Forms\Components\DatePicker::make('data_prestacao_contas')
                                    ->label('Data da Prestação de Contas')
                                    ->nullable(),
                                Forms\Components\Textarea::make('descricao_prestacao_contas')
                                    ->label('Descrição da Prestação de Contas')
                                    ->rows(3)
                                    ->maxLength(1000)
                                    ->nullable(),
                                Forms\Components\Textarea::make('justificativa_atraso_prestacao_contas')
                                    ->label('Justificativa para Atraso na Prestação de Contas')
                                    ->rows(3)
                                    ->maxLength(1000)
                                    ->nullable(),
                                Forms\Components\Toggle::make('ciente_prestacao_contas')
                                    ->label('Ciente dos Termos para Prestação de Contas')
                                    ->onColor('success')
                                    ->offColor('secondary')
                                    ->nullable(),
                            ])
                            ->columns(2),
                    ])
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
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
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageDiarias::route('/'),
        ];
    }
}
