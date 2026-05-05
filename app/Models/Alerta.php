<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alerta extends Model
{
    use HasFactory;

    protected $table = 'alertas';

    protected $fillable = [
        'tipo_alerta',
        'descricao',
        'remessa_id'
    ];

    // Relacionamento com remessa
    public function remessa()
    {
        return $this->belongsTo(Remessa::class);
    }
}