<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Remessa extends Model
{
    protected $fillable = [
        'codigo_rastreio',
        'origem',
        'destino',
        'tipo_carga',
        'peso',
        'previsao_entrega',
        'status',
        'cliente_id',
        'motorista_id'
    ];

    public function cliente()
    {
        return $this->belongsTo(User::class,'cliente_id');
    }

    public function motorista()
    {
        return $this->belongsTo(User::class,'motorista_id');
    }

    public function localizacoes()
    {
        return $this->hasMany(Localizacao::class);
    }

    public function alertas()
    {
        return $this->hasMany(Alerta::class);
    }
}