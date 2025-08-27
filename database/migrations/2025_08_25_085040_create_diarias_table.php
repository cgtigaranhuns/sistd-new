<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('diarias', function (Blueprint $table) {
            ## Dados Pessoais
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade')->nullable();;
            $table->string('tipo_solicitante')->nullable();;  //Própria ou Terceiros         
            $table->string('nome')->nullable();
            $table->string('siape')->nullable();
            $table->string('rg')->nullable();
            $table->string('cpf');
            $table->string('orgao_expedidor')->nullable();
            $table->date('data_nascimento')->nullable();
            $table->string('telefone')->nullable();
            $table->string('email')->nullable();
            $table->string('orgao_setor_lotacao')->nullable(); // Órgão/Setor de Lotação para terceiros
            $table->foreignId('banco_id')->constrained()->onDelete('cascade')->nullable();
            $table->string('agencia')->nullable();
            $table->string('conta_corrente')->nullable();
            $table->string('tipo_conta')->nullable();
            ## Dados Institucionais
            $table->string('tipo_solicitacao')->nullable(); // - Servidor Federal - Servidor Estadual - Servidor Municipal - Empregado Público - Colaborador Eventual - Outros
            $table->string('outros_tipo_solicitante')->nullable();
            $table->string('cargo_funcao')->nullable(); // Professor, Técnico Administrativo, Estudante
            $table->boolean('auxilio_transporte')->nullable(); // Sim ou Não
            $table->boolean('forma_auxilio_transporte')->nullable(); // Semanal ou Final de Semana
            $table->string('escolaridade_cargo')->nullable(); // Fundamental, Médio, Superior
            $table->string('descricao_cargo_funcao')->nullable();
            $table->decimal('valor_vale_transporte', 10, 2)->nullable();
            $table->decimal('valor_vale_alimentacao', 10, 2)->nullable();
            ## Dados da Viagem
            $table->string('tipo_diaria')->nullable(); // Diária, Diária e Passagens
            $table->timestamp('data_hora_saida')->nullable();
            $table->timestamp('data_hora_retorno')->nullable();
            $table->longText('justificativa_data_viagem')->nullable();
            $table->timestamp('data_hora_evento')->nullable();
            $table->timestamp('data_hora_fim_evento')->nullable();
            $table->boolean('tipo_intinerario')->nullable();
            $table->boolean('pernoite_intinerario')->nullable(); 
            $table->json('intinerario')->nullable();
            $table->foreignId('estado_id')->nullable();
            $table->foreignId('cidade_id')->nullable();
            $table->string('finalidade_viagem')->nullable();
            $table->string('outro_finalidade_viagem')->nullable();
            $table->longText('descricao_finalidade_viagem')->nullable();
            $table->string('local_evento')->nullable();
            $table->string('justificativa_05_dias_evento')->nullable(); 
            $table->boolean('ciente_diaria')->nullable(); // Sim ou Não
            ## Prestação de Contas
            $table->boolean('prestacao_contas')->nullable(); // Sim ou Não
            $table->date('data_prestacao_contas')->nullable();
            $table->longText('descricao_prestacao_contas')->nullable(); 
            $table->longText('justificativa_atraso_prestacao_contas')->nullable();
            $table->boolean('ciente_prestacao_contas')->nullable(); // Sim ou Não           
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diarias');
    }
};
