<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class GoogleRoutesProxyTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Cache::flush();
    }

    public function test_route_proxy_requires_authentication(): void
    {
        $this->postJson('/api/rotas/estimativa', $this->coordinates())
            ->assertUnauthorized();
    }

    public function test_server_proxies_route_and_caches_nearby_repeats(): void
    {
        config(['services.google.routes_key' => 'server-only-test-key']);
        Sanctum::actingAs(User::factory()->create());
        $calls = 0;
        Http::fake(function ($request) use (&$calls) {
            $calls++;
            $this->assertTrue($request->hasHeader('X-Goog-Api-Key', 'server-only-test-key'));
            $this->assertSame('TRAFFIC_AWARE', $request->data()['routingPreference']);
            return Http::response([
                'routes' => [['distanceMeters' => 12500, 'duration' => '900s']],
            ]);
        });

        $this->postJson('/api/rotas/estimativa', $this->coordinates())
            ->assertOk()
            ->assertJsonPath('data.distance_km', 12.5)
            ->assertJsonPath('data.duration_minutes', 15)
            ->assertJsonPath('cached', false);
        $this->postJson('/api/rotas/estimativa', $this->coordinates())
            ->assertOk()
            ->assertJsonPath('cached', true);

        $this->assertSame(1, $calls);
    }

    public function test_missing_server_key_does_not_call_google(): void
    {
        config(['services.google.routes_key' => null]);
        Sanctum::actingAs(User::factory()->create());
        Http::fake();

        $this->postJson('/api/rotas/estimativa', $this->coordinates())
            ->assertStatus(503);
        Http::assertNothingSent();
    }

    public function test_route_proxy_rejects_invalid_coordinates(): void
    {
        config(['services.google.routes_key' => 'server-only-test-key']);
        Sanctum::actingAs(User::factory()->create());

        $this->postJson('/api/rotas/estimativa', [
            'origin' => ['latitude' => 120, 'longitude' => 0],
            'destination' => ['latitude' => 0, 'longitude' => 0],
        ])->assertUnprocessable();
    }

    private function coordinates(): array
    {
        return [
            'origin' => ['latitude' => -23.5, 'longitude' => -46.6],
            'destination' => ['latitude' => -23.6, 'longitude' => -46.4],
        ];
    }
}