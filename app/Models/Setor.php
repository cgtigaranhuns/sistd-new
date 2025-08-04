<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Setor extends Model
{
    protected $table = 'setores';
    use HasFactory;

    protected $fillable = ['nome','descricao'];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}