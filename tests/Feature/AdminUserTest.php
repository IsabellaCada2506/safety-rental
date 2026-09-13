<?php

/**
 * Author: Alejandro Correa Marin
 * Date: 2026-09-12
 * Description: Feature tests covering administrator user listing, updates, and protected deletion.
 */

namespace Tests\Feature;

use App\Models\Car;
use App\Models\Location;
use App\Models\Reservation;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminUserTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    private User $customer;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();

        $this->admin = User::query()->where('email', 'admin@safetyrental.test')->first();
        $this->customer = User::query()->where('email', 'customer@safetyrental.test')->first();
    }

    public function test_admin_can_view_the_users_list(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.user.index'));

        $response->assertOk();
        $response->assertSee($this->admin->getEmail());
        $response->assertSee($this->customer->getEmail());
        $response->assertSee(__('user.admin_title_index'));
    }

    public function test_customer_cannot_access_user_management(): void
    {
        $response = $this->actingAs($this->customer)->get(route('admin.user.index'));

        $response->assertForbidden();
    }

    public function test_admin_can_update_a_user(): void
    {
        $response = $this->actingAs($this->admin)->put(route('admin.user.update', ['id' => $this->customer->getId()]), [
            'name' => 'Updated',
            'last_name' => 'Customer',
            'birth_date' => '2000-01-01',
            'address' => 'Updated Address',
            'license_number' => $this->customer->getLicenseNumber(),
            'emergency_contact' => 3000000099,
            'identification_number' => $this->customer->getIdentificationNumber(),
            'emergency_contact_name' => 'Updated',
            'emergency_contact_last_name' => 'Contact',
            'eps' => 'Sura',
            'email' => $this->customer->getEmail(),
            'role' => User::ROLE_CUSTOMER,
        ]);

        $response->assertRedirect(route('admin.user.index'));
        $this->assertSame('Updated', $this->customer->fresh()->getName());
        $this->assertSame('Updated Address', $this->customer->fresh()->getAddress());
    }

    public function test_admin_cannot_delete_their_own_account(): void
    {
        $response = $this->actingAs($this->admin)->delete(route('admin.user.delete', ['id' => $this->admin->getId()]));

        $response->assertRedirect();
        $response->assertSessionHasErrors('error');
        $this->assertNotNull(User::query()->find($this->admin->getId()));
    }

    public function test_admin_can_delete_a_user_without_reservations(): void
    {
        $deletableUser = User::factory()->create([
            'email' => 'deletable@safetyrental.test',
        ]);

        $response = $this->actingAs($this->admin)->delete(route('admin.user.delete', ['id' => $deletableUser->getId()]));

        $response->assertRedirect(route('admin.user.index'));
        $this->assertNull(User::query()->find($deletableUser->getId()));
    }

    public function test_admin_cannot_delete_a_user_with_reservations(): void
    {
        $reservation = new Reservation;
        $reservation->setCode(random_int(40000000, 49999999));
        $reservation->setState(Reservation::STATE_PENDING);
        $reservation->setStartDate(Carbon::now()->addDays(10));
        $reservation->setEndDate(Carbon::now()->addDays(12));
        $reservation->setUserId($this->customer->getId());
        $reservation->setCarId(Car::query()->first()->getId());
        $reservation->setLocationId(Location::query()->first()->getId());
        $reservation->save();

        $response = $this->actingAs($this->admin)->delete(route('admin.user.delete', ['id' => $this->customer->getId()]));

        $response->assertRedirect();
        $response->assertSessionHasErrors('error');
        $this->assertNotNull(User::query()->find($this->customer->getId()));
    }
}
