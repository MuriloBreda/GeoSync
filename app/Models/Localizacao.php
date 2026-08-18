<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Localizacao extends Model
{
    protected $table = 'localizacoes';

    protected $fillable = [
        'latitude',
        'longitude',
        'remessa_id'
    ];
}