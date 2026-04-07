<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class Localizacao extends Model {
    protected $fillable = [
        'latitude',
        'longitude',
        'data_hora',
        'id_remessa'
    ];
}