<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Field;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationGroup = 'Segurança';

    protected static ?string $navigationLabel = 'Usuários';


    protected static ?int $navigationSort = 1;




    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Fieldset::make('Informações Pessoais')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->label('Nome'),
                        
                        Forms\Components\Select::make('setor_id')
                            ->relationship('setor', 'nome')
                            ->label('Setor')
                            ->searchable()
                            ->required(),
                        Forms\Components\TextInput::make('email')
                            ->required()
                            ->email()
                            ->maxLength(255)
                            ->label('E-mail'),
                        Forms\Components\TextInput::make('contato')
                            ->required()
                            ->mask('(99) 99999-9999')
                            ->maxLength(255)
                            ->label('Contato'),
                        Forms\Components\DatePicker::make('data_nascimento')
                            ->required()
                            ->date('d/m/Y')
                            ->label('Data de Nascimento'),
                    ]),
                Fieldset::make('Credenciais')
                    ->schema([
                        Forms\Components\TextInput::make('username')
                            ->required()
                            ->maxLength(255)
                            ->label('Siape'),
                       Forms\Components\TextInput::make('password')
                                    ->password()
                                    ->dehydrateStateUsing(fn($state) => Hash::make($state))
                                    ->dehydrated(fn($state) => filled($state))
                                    ->required(fn(string $context): bool => $context === 'create'),
                    ]),
                Fieldset::make('Documentos')
                    ->schema([
                        Forms\Components\TextInput::make('cpf')
                            ->required()
                            ->mask('999.999.999-99')                           
                            ->minLength(11)
                            ->maxLength(14)                            
                            ->label('CPF'),
                        Forms\Components\Select::make('banco_id')
                            ->relationship('banco', 'nome')
                            ->label('Banco')
                            ->searchable()
                            ->required(),
                        Forms\Components\TextInput::make('agencia')
                            ->required()
                            ->maxLength(255)
                            ->label('Agência'),         
                        Forms\Components\TextInput::make('conta')
                            ->required()
                            ->maxLength(255)
                            ->label('Conta'),
                    ]),
            ]);
    }
                        
                
               
                
        
    

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nome')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('username')
                    ->label('Siape')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('E-mail')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('setor.nome')
                    ->label('Setor')
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
                  //  Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageUsers::route('/'),
        ];
    }
}
