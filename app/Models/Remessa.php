<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Remessa extends Model
{
    use HasFactory;

    protected $table = 'remessas';

    protected $fillable = [
        'codigo_rastreio',
        'origem',
        'destino',
        'tipo_carga',
        'peso',
        'previsao_entrega',
        'status',
        'user_id'
    ];

    // Relacionamento com usuário
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relacionamento com alertas
    public function alertas()
    {
        return $this->hasMany(Alerta::class);
    }

    // Relacionamento com localizações
    public function localizacoes()
    {
        return $this->hasMany(Localizacao::class);
    }
}