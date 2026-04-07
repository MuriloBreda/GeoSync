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
}