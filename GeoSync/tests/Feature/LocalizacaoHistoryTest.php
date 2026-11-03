<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class LocalizacaoHistoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_history_returns_all_points_in_chronological_order(): void
    {
        $remessaId = DB::table('remessas')->insertGetId([
            'codigo_rastreio' => 'GS-HIST-001',
            'origem' => 'São Paulo',
            'destino' => 'Campinas',
            'status' => 'Em Rota',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('localizacoes')->insert([
            [
                'latitude' => -23.55050000,
                'longitude' => -46.63330000,
                'remessa_id' => $remessaId,
                'created_at' => '2026-11-03 10:00:00',
                'updated_at' => '2026-11-03 10:00:00',
            ],
            [
                'latitude' => -23.10000000,
                'longitude' => -46.90000000,
                'remessa_id' => $remessaId,
                'created_at' => '2026-11-03 10:05:00',
                'updated_at' => '2026-11-03 10:05:00',
            ],
        ]);

        $this->getJson("/api/localizacao/remessa/{$remessaId}")
            ->assertOk()
            ->assertJsonCount(2, 'data')
            ->assertJsonPath('data.0.latitude', -23.5505)
            ->assertJsonPath('data.1.latitude', -23.1);
    }
}
