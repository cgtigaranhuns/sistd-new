<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'cpf',
        'data_nascimento',
        'setor_id',
        'contato',
        'banco_id',
        'agencia',
        'conta',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'email_verified_at',
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'data_nascimento' => 'date',
    ];
    /**
     * Get the setor that owns the user.
     */
    public function setor(): BelongsTo
    {
        return $this->belongsTo(Setor::class);
    }
    /**
     * Get the banco that owns the user.
     */
    public function banco(): BelongsTo
    {
        return $this->belongsTo(Banco::class);
    }
    /**
     * Get the full name of the user.
     */
    
}
