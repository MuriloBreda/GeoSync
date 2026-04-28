<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class Remessa extends Model {
    protected $fillable = [
        'codigo_rastreio',
        'origem',
        'destino',
        'tipo_carga',
        'peso',
        'previsao_entrega',
        'status',
        'data_hora',
        'id_usuario'
    ];

    public function usuario(){
        return $this->belongsTo(Usuario::class);
    }

    public function alerta(){
        return $this->hasMany(Alerta::class);
    }

    public function localizacao(){
        return $this->hasOne(Localizacao::class);
    }
}