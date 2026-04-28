<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class Alerta extends Model {
    protected $fillable = [
        'tipo_alerta',
        'descricao',
        'data_hora',
        'id_remessa'
    ];

    public function remessa(){
        return $this->belongsTo(Remessa::class);
    }
}