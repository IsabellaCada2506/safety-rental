<?php

/**
 * Author: Alejandro
 * Date: 07/09/2026
 * Description: Feature tests for the administrator Blade layout and navigation.
 */

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminLayoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_dashboard_uses_the_administrator_layout_and_navigation(): void
    {
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->get(route('admin.dashboard.index'));

        $response->assertOk();
        $response->assertViewIs('admin.dashboard.index');
        $response->assertSee('admin-layout', false);
        $response->assertSee(__('admin.dashboard'), false);
        $response->assertSee(__('admin.vehicles'), false);
        $response->assertSee(__('admin.reservations'), false);
        $response->assertSee(__('admin.locations'), false);
        $response->assertSee(__('admin.metrics'), false);
        $response->assertSee(__('admin.logout'), false);
        $response->assertSee(route('auth.logout'), false);
        $response->assertDontSee(route('home.index'), false);
        $response->assertDontSee(route('profile.index'), false);
    }

    public function test_customer_home_stays_on_the_customer_layout(): void
    {
        $customer = User::factory()->create();

        $response = $this->actingAs($customer)->get(route('home.index'));

        $response->assertOk();
        $response->assertViewIs('home.index');
        $response->assertDontSee('admin-layout', false);
        $response->assertDontSee(__('admin.metrics'), false);
        $response->assertSee(__('authentication.customer_area'), false);
    }

    public function test_admin_translation_keys_match_in_english_and_spanish(): void
    {
        $englishKeys = array_keys(require lang_path('en/admin.php'));
        $spanishKeys = array_keys(require lang_path('es/admin.php'));

        $this->assertSame($englishKeys, $spanishKeys);
    }

    public function test_customers_cannot_open_administrator_pages(): void
    {
        $customer = User::factory()->create();

        $this->actingAs($customer)
            ->get(route('admin.dashboard.index'))
            ->assertForbidden();
    }

    public function test_guests_cannot_open_administrator_pages(): void
    {
        $this->get(route('admin.dashboard.index'))
            ->assertRedirect(route('login'));
    }
}
