<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AlertaLeitura extends Model
{
    protected $table = 'alerta_leituras';
    public $timestamps = false;

    protected $fillable = ['alerta_id', 'user_id', 'read_at'];
}
