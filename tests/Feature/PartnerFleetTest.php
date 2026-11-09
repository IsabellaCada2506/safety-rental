<?php

/**
 * Author: Alejandro Correa Marin
 * Date: 2026-11-09
 * Description: Feature tests for consuming the preceding team fleet API.
 */

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class PartnerFleetTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    public function test_partner_page_shows_vehicles_from_the_preceding_team_api(): void
    {
        config(['services.partner.url' => 'https://team05.example.test/api/vehicles']);

        Http::fake([
            'https://team05.example.test/api/vehicles' => Http::response([
                'vehicles' => [
                    [
                        'make' => 'Renault',
                        'model' => 'Duster',
                        'category' => 'SUV',
                        'location' => 'Sede Envigado',
                        'daily_rate' => 210000,
                        'availability' => 'available',
                        'detail_url' => 'https://team05.example.test/catalog/8',
                    ],
                ],
            ], 200),
        ]);

        $response = $this->actingAs($this->customer())->get(route('partners.index'));

        $response->assertOk();
        $response->assertSee('Renault Duster');
        $response->assertSee('Sede Envigado');
        $response->assertSee('210.000');
        Http::assertSentCount(1);
    }

    public function test_partner_page_shows_a_translated_message_when_the_api_url_is_missing(): void
    {
        config(['services.partner.url' => '']);

        $response = $this->actingAs($this->customer())->get(route('partners.index'));

        $response->assertOk();
        $response->assertSee(__('partner.error_missing_config'));
        Http::assertNothingSent();
    }

    public function test_partner_page_shows_a_translated_message_when_the_api_times_out(): void
    {
        config(['services.partner.url' => 'https://team05.example.test/api/vehicles']);

        Http::fake(function (): never {
            throw new ConnectionException('cURL error 28: Operation timed out');
        });

        $response = $this->actingAs($this->customer())->get(route('partners.index'));

        $response->assertOk();
        $response->assertSee(__('partner.error_timeout'));
    }

    public function test_partner_page_shows_a_translated_message_when_the_api_returns_http_error(): void
    {
        config(['services.partner.url' => 'https://team05.example.test/api/vehicles']);

        Http::fake([
            'https://team05.example.test/api/vehicles' => Http::response(['message' => 'down'], 503),
        ]);

        $response = $this->actingAs($this->customer())->get(route('partners.index'));

        $response->assertOk();
        $response->assertSee(__('partner.error_http'));
    }

    public function test_partner_page_shows_an_empty_state_when_the_api_returns_no_vehicles(): void
    {
        config(['services.partner.url' => 'https://team05.example.test/api/vehicles']);

        Http::fake([
            'https://team05.example.test/api/vehicles' => Http::response(['vehicles' => []], 200),
        ]);

        $response = $this->actingAs($this->customer())->get(route('partners.index'));

        $response->assertOk();
        $response->assertSee(__('partner.empty_title'));
    }

    private function customer(): User
    {
        return User::query()->where('role', User::ROLE_CUSTOMER)->firstOrFail();
    }
}
