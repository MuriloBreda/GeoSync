<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contato extends Model
{
    protected $table = 'contatos';
    public $timestamps = false; // Como não tem updated_at, desativamos o padrão

    protected $fillable = [
        'nome',
        'email',
        'mensagem',
        'created_at'
    ];
}