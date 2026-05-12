<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Avaliacao extends Model
{
    use HasFactory;

    // Nome da tabela conforme seu script SQL
    protected $table = 'avaliacoes';

    // Campos que podem ser preenchidos via formulário
    protected $fillable = [
        'user_id',
        'nota',
        'comentario',
    ];

    /**
     * Relacionamento: Uma avaliação pertence a um usuário.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}