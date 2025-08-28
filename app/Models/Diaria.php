<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diaria extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'tipo_solicitante',
        'nome',
        'siape',
        'rg',
        'cpf',
        'orgao_expedidor',
        'data_nascimento',
        'telefone',
        'email',
        'orgao_setor_lotacao',
        'banco_id',
        'agencia',
        'conta_corrente',
        'tipo_conta',
        'tipo_solicitacao',
        'outros_tipo_solicitante',
        'cargo_funcao',
        'auxilio_transporte',
        'forma_auxilio_transporte',
        'escolaridade_cargo',
        'descricao_cargo_funcao',
        'valor_vale_transporte',
        'valor_vale_alimentacao',
        'tipo_diaria',
        'data_hora_saida',
        'data_hora_retorno',
        'justificativa_data_viagem',
        'data_hora_evento',
        'data_hora_fim_evento',
        'transporte_ida',
        'transporte_volta',
        'tipo_intinerario',        
        'intinerario',
        'estado_id',
        'cidade_id',
        'finalidade_viagem',
        'outro_finalidade_viagem',
        'descricao_finalidade_viagem',
        'local_evento',
        'justificativa_05_dias_evento',
        'ciente_diaria',
        'ciente_normativo',
        'prestacao_contas', 
        'data_prestacao_contas', 
        'descricao_prestacao_contas', 
        'justificativa_atraso_prestacao_contas', 
        'ciente_prestacao_contas', 
    ];

    protected $casts = [
        'intinerario' => 'array',
        'anexos' => 'array',
        'auxilio_transporte' => 'boolean',
        'forma_auxilio_transporte' => 'boolean',
        'tipo_intinerario' => 'boolean',
        'pernoite_intinerario' => 'boolean',
        'prestacao_contas' => 'boolean',
        'ciente_diaria' => 'boolean',
        'ciente_prestacao_contas' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function banco()
    {
        return $this->belongsTo(Banco::class);
    }

    public function estado()
    {
        return $this->belongsTo(Estado::class);
    }

    public function cidade()
    {
        return $this->belongsTo(Cidade::class);
    }

    
}
