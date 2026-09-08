<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Remessa extends Model
{
    protected $table = 'remessas';

    protected $fillable = [
        'codigo_rastreio', 'origem', 'destino', 'tipo_carga', 'peso', 'previsao_entrega', 'status', 'cliente_id', 'motorista_id'
    ];

    // Relacionamento com o Motorista
    public function motorista()
    {
        return $this->belongsTo(User::class, 'motorista_id');
    }

    // Relacionamento com o Cliente
    public function cliente()
    {
        return $this->belongsTo(User::class, 'cliente_id');
    }

    public function localizacoes(): HasMany
    {
        return $this->hasMany(Localizacao::class, 'remessa_id');
    }
}