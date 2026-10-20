<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class Usuario extends Model {
    protected $fillable = [
        'nome',
        'email',
        'password',
    ];

    public function remessa(){
        return $this->hasMany(Remessa::class);
    }
}