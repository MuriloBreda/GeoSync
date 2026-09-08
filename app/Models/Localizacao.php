<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Localizacao extends Model
{
    protected $table = 'localizacoes';

    protected $fillable = [
        'latitude',
        'longitude',
        'remessa_id'
    ];

    public function remessa(): BelongsTo
    {
        return $this->belongsTo(Remessa::class, 'remessa_id');
    }
}
