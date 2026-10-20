<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Remessa extends Model
{
    protected $table = 'remessas';

    public const STATUS_PENDENTE = 'Pendente';
    public const STATUS_EM_ROTA = 'Em Rota';
    public const STATUS_ATRASADO = 'Atrasado';
    public const STATUS_ENTREGUE = 'Entregue';

    protected $fillable = [
        'codigo_rastreio', 'origem', 'destino', 'destino_cep', 'destino_rua',
        'destino_numero', 'destino_complemento', 'destino_bairro', 'destino_cidade',
        'destino_estado', 'latitude_destino', 'longitude_destino', 'destino_precisao',
        'tipo_carga', 'peso', 'previsao_entrega', 'status', 'cliente_id', 'motorista_id',
    ];

    protected $casts = [
        'latitude_destino' => 'float',
        'longitude_destino' => 'float',
        'proximidade_notificada_at' => 'datetime',
    ];

    public function motorista()
    {
        return $this->belongsTo(User::class, 'motorista_id');
    }

    public function cliente()
    {
        return $this->belongsTo(User::class, 'cliente_id');
    }

    public function localizacoes(): HasMany
    {
        return $this->hasMany(Localizacao::class, 'remessa_id');
    }

    public function temCoordenadasDestino(): bool
    {
        return $this->latitude_destino !== null && $this->longitude_destino !== null
            && $this->latitude_destino >= -35 && $this->latitude_destino <= 6
            && $this->longitude_destino >= -75 && $this->longitude_destino <= -30;
    }

    /** Dados do endereço no formato aceito pelo GeocodificadorDestino. */
    public function enderecoParaGeocodificar(): array
    {
        return $this->only([
            'destino', 'destino_cep', 'destino_rua', 'destino_numero',
            'destino_bairro', 'destino_cidade', 'destino_estado',
        ]);
    }
}
