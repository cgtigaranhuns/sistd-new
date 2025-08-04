<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Motorista extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'contato',
        'cnh',
        'categoria_cnh',
        'validade_cnh',
        'validade_curso_conducao',
        'numero_contrato',
    ];
}
