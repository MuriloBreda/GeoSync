<?php

namespace Database\Seeders;

use App\Models\Alerta;
use App\Models\Avaliacao;
use App\Models\Localizacao;
use App\Models\Pagamento;
use App\Models\Remessa;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * Dados de demonstração para testar a integração web (Laravel) x app (Flutter).
 * Idempotente: pode ser executado várias vezes.
 *
 *   php artisan db:seed --class=DemoSeeder
 */
class DemoSeeder extends Seeder
{
    public function run(): void
    {
        $motorista = User::updateOrCreate(
            ['email' => 'motorista@geosync.test'],
            [
                'name' => 'Carlos Motorista',
                'password' => Hash::make('senha123'),
                'tipo' => 'motorista',
                'telefone' => '(11) 98888-1111',
                'cpf' => '111.444.777-35',
                'birth_date' => '1988-04-12',
            ]
        );

        $cliente = User::updateOrCreate(
            ['email' => 'cliente@geosync.test'],
            [
                'name' => 'Ana Cliente',
                'password' => Hash::make('senha123'),
                'tipo' => 'cliente',
                'telefone' => '(11) 97777-2222',
                'cpf' => '529.982.247-25',
                'birth_date' => '1995-09-30',
            ]
        );

        $base = [
            'origem' => 'Centro de Distribuição - Guarulhos/SP',
            'cliente_id' => $cliente->id,
        ];

        // 1) Em rota, com histórico de localizações (rastreamento ao vivo)
        $emRota = Remessa::updateOrCreate(['codigo_rastreio' => 'GS-DEMO-0001'], $base + [
            'destino' => 'Av. Paulista, 1578 - Bela Vista, São Paulo/SP',
            'destino_cep' => '01310-200',
            'destino_rua' => 'Av. Paulista',
            'destino_numero' => '1578',
            'destino_bairro' => 'Bela Vista',
            'destino_cidade' => 'São Paulo',
            'destino_estado' => 'SP',
            'latitude_destino' => -23.5613991,
            'longitude_destino' => -46.6565712,
            'destino_precisao' => 'exata',
            'tipo_carga' => 'Eletrônicos',
            'peso' => 12.50,
            'previsao_entrega' => now()->addDay()->toDateString(),
            'status' => Remessa::STATUS_EM_ROTA,
            'motorista_id' => $motorista->id,
        ]);

        // 2) Pendente sem motorista (aparece em "remessas disponíveis" no app)
        $pendente = Remessa::updateOrCreate(['codigo_rastreio' => 'GS-DEMO-0002'], $base + [
            'destino' => 'Rua Augusta, 2690 - Jardins, São Paulo/SP',
            'destino_cep' => '01412-100',
            'destino_rua' => 'Rua Augusta',
            'destino_numero' => '2690',
            'destino_bairro' => 'Jardins',
            'destino_cidade' => 'São Paulo',
            'destino_estado' => 'SP',
            'latitude_destino' => -23.5651,
            'longitude_destino' => -46.6670,
            'destino_precisao' => 'exata',
            'tipo_carga' => 'Documentos',
            'peso' => 1.20,
            'previsao_entrega' => now()->addDays(3)->toDateString(),
            'status' => Remessa::STATUS_PENDENTE,
            'motorista_id' => null,
        ]);

        // 3) Atrasada
        $atrasada = Remessa::updateOrCreate(['codigo_rastreio' => 'GS-DEMO-0003'], $base + [
            'destino' => 'Av. Brigadeiro Faria Lima, 3477 - Itaim Bibi, São Paulo/SP',
            'destino_cep' => '04538-133',
            'destino_rua' => 'Av. Brigadeiro Faria Lima',
            'destino_numero' => '3477',
            'destino_bairro' => 'Itaim Bibi',
            'destino_cidade' => 'São Paulo',
            'destino_estado' => 'SP',
            'latitude_destino' => -23.5868,
            'longitude_destino' => -46.6815,
            'destino_precisao' => 'exata',
            'tipo_carga' => 'Móveis',
            'peso' => 85.00,
            'previsao_entrega' => now()->subDays(2)->toDateString(),
            'status' => Remessa::STATUS_ATRASADO,
            'motorista_id' => $motorista->id,
        ]);

        // 4) Entregue
        $entregue = Remessa::updateOrCreate(['codigo_rastreio' => 'GS-DEMO-0004'], $base + [
            'destino' => 'Rua Oscar Freire, 900 - Jardim Paulista, São Paulo/SP',
            'destino_cep' => '01426-001',
            'destino_rua' => 'Rua Oscar Freire',
            'destino_numero' => '900',
            'destino_bairro' => 'Jardim Paulista',
            'destino_cidade' => 'São Paulo',
            'destino_estado' => 'SP',
            'latitude_destino' => -23.5629,
            'longitude_destino' => -46.6697,
            'destino_precisao' => 'exata',
            'tipo_carga' => 'Vestuário',
            'peso' => 4.30,
            'previsao_entrega' => now()->subDays(5)->toDateString(),
            'status' => Remessa::STATUS_ENTREGUE,
            'motorista_id' => $motorista->id,
        ]);

        $demoIds = [$emRota->id, $pendente->id, $atrasada->id, $entregue->id];
        Localizacao::whereIn('remessa_id', $demoIds)->delete();
        Alerta::whereIn('remessa_id', $demoIds)->delete();

        // Trajeto Guarulhos -> Av. Paulista (últimos pontos mais recentes)
        $trajeto = [
            [-23.4543, -46.5333], [-23.4801, -46.5520], [-23.5052, -46.5895],
            [-23.5205, -46.6150], [-23.5340, -46.6352], [-23.5468, -46.6440],
            [-23.5540, -46.6505],
        ];
        $total = count($trajeto);
        foreach ($trajeto as $i => [$lat, $lng]) {
            $l = new Localizacao([
                'latitude' => $lat,
                'longitude' => $lng,
                'remessa_id' => $emRota->id,
                'fonte' => $i % 2 ? 'app' : 'esp32',
            ]);
            $l->created_at = $l->updated_at = now()->subMinutes(($total - 1 - $i) * 10);
            $l->save();
        }

        foreach ([[-23.5300, -46.6600], [-23.5700, -46.6750]] as $i => [$lat, $lng]) {
            $l = new Localizacao(['latitude' => $lat, 'longitude' => $lng, 'remessa_id' => $atrasada->id, 'fonte' => 'esp32']);
            $l->created_at = $l->updated_at = now()->subHours(3 - $i);
            $l->save();
        }

        $l = new Localizacao(['latitude' => -23.5629, 'longitude' => -46.6697, 'remessa_id' => $entregue->id, 'fonte' => 'app']);
        $l->created_at = $l->updated_at = now()->subDays(5);
        $l->save();

        Alerta::create(['remessa_id' => $emRota->id, 'tipo' => 'Proximidade do destino', 'mensagem' => 'A remessa GS-DEMO-0001 está a menos de 2 km do destino.']);
        Alerta::create(['remessa_id' => $atrasada->id, 'tipo' => 'Atraso', 'mensagem' => 'A remessa GS-DEMO-0003 ultrapassou a previsão de entrega.']);
        Alerta::create(['remessa_id' => $entregue->id, 'tipo' => 'Entrega concluída', 'mensagem' => 'A remessa GS-DEMO-0004 foi entregue com sucesso.']);

        Pagamento::updateOrCreate(
            ['user_id' => $cliente->id, 'plano' => 'Plano Profissional'],
            [
                'email' => $cliente->email,
                'telefone' => $cliente->telefone,
                'cnpj' => '12.345.678/0001-95',
                'metodo' => 'pix',
                'valor' => 199.90,
                'status' => 'Aprovado',
            ]
        );

        Avaliacao::updateOrCreate(['nome_exibicao' => 'Ana Cliente'], ['nota' => 5, 'comentario' => 'Acompanhei a entrega em tempo real, excelente!']);
        Avaliacao::updateOrCreate(['nome_exibicao' => 'Carlos Motorista'], ['nota' => 4, 'comentario' => 'App fácil de usar durante as rotas.']);
    }
}
