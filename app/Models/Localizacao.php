<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Localizacao extends Model
{
    use HasFactory;

    protected $table = 'localizacoes';

    protected $fillable = [
        'latitude',
        'longitude',
        'remessa_id'
    ];

    // Relacionamento com remessa
    public function remessa()
    {
        return $this->belongsTo(Remessa::class);
    }
}