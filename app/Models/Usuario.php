<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class Usuario extends Model {
    protected $fillable = [
        'nome',
        'email',
        'senha',
    ];

    public function remessa(){
        return $this->hasMany(Remessa::class);
    }
}