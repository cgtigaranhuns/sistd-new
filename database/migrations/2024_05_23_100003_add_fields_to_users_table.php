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
        Schema::table('users', function (Blueprint $table) {
            $table->string('cpf', 14)->unique()->nullable()->after('password');
            $table->date('data_nascimento')->nullable()->after('cpf');
            $table->foreignId('setor_id')->nullable()->after('data_nascimento')->constrained('setores')->onDelete('set null');
            $table->string('contato')->nullable()->after('setor_id');
            $table->foreignId('banco_id')->nullable()->after('contato')->constrained('bancos')->onDelete('set null');
            $table->string('agencia')->nullable()->after('banco_id');
            $table->string('conta')->nullable()->after('agencia');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['setor_id']);
            $table->dropForeign(['banco_id']);

            $table->dropColumn([
                'cpf',
                'data_nascimento',
                'setor_id',
                'contato',
                'banco_id',
                'agencia',
                'conta',
            ]);
        });
    }
};