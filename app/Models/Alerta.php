<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alerta extends Model
{
    use HasFactory;

    protected $table = 'alertas';

    // Alinhado com o banco de dados final e o Controller
    protected $fillable = [
        'tipo',
        'mensagem',
        'remessa_id'
    ];
    
    public function remessa()
    {
        return $this->belongsTo(Remessa::class, 'remessa_id');
    }
}