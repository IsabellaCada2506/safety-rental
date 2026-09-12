<?php

/**
 * Author: Isabella Ocampo
 * Date: 2026-09-11
 * Description: Feature test suite covering location management (CRUD, protected deletion) and customer browsing.
 */

namespace Tests\Feature;

use App\Models\Car;
use App\Models\Category;
use App\Models\Location;
use App\Models\Reservation;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LocationManagementTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    private User $customer;

    private Location $location;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();

        $this->admin = User::query()->where('role', User::ROLE_ADMIN)->first();
        $this->customer = User::query()->where('role', User::ROLE_CUSTOMER)->first();
        $this->location = Location::first();
    }

    /** AC 1: List Locations */
    public function test_admin_can_view_locations_list(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.location.index'));

        $response->assertStatus(200);
        $response->assertSee($this->location->getName());
        $response->assertSee($this->location->getAddress());
        $response->assertSee($this->location->getTelephone());
        $response->assertSee($this->location->getCity());
    }

    /** AC 2: Create Location */
    public function test_admin_can_create_location_with_valid_data(): void
    {
        $data = [
            'name' => 'Sede Envigado Premium',
            'address' => 'Calle 37 Sur # 43-20',
            'headquarters' => 'Sede Sur Valle de Aburra',
            'telephone' => '+57 604 333 9988',
            'city' => 'Envigado',
        ];

        $response = $this->actingAs($this->admin)->post(route('admin.location.store'), $data);

        $response->assertRedirect(route('admin.location.index'));
        $this->assertDatabaseHas('locations', [
            'name' => 'Sede Envigado Premium',
            'city' => 'Envigado',
        ]);
    }

    /** AC 3: Update Location */
    public function test_admin_can_update_existing_location(): void
    {
        $data = [
            'name' => 'Sede El Poblado Renovada',
            'address' => 'Carrera 43A # 1-99',
            'headquarters' => 'Sede Principal Antioquia',
            'telephone' => '+57 604 444 0000',
            'city' => 'Medellín',
        ];

        $response = $this->actingAs($this->admin)->put(
            route('admin.location.update', ['id' => $this->location->getId()]),
            $data
        );

        $response->assertRedirect(route('admin.location.index'));
        $this->assertDatabaseHas('locations', [
            'id' => $this->location->getId(),
            'name' => 'Sede El Poblado Renovada',
        ]);
    }

    /** AC 4: Prevent deletion when cars are associated */
    public function test_admin_cannot_delete_location_associated_with_cars(): void
    {
        // Ensure this location has at least one car
        $car = Car::first();
        $car->setLocationId($this->location->getId());
        $car->save();

        $response = $this->actingAs($this->admin)->delete(
            route('admin.location.delete', ['id' => $this->location->getId()])
        );

        $response->assertSessionHas('error');
        $this->assertDatabaseHas('locations', ['id' => $this->location->getId()]);
    }

    /** AC 4: Prevent deletion when reservations are associated */
    public function test_admin_cannot_delete_location_associated_with_reservations(): void
    {
        // Unlink cars from location
        Car::query()->where('location_id', $this->location->getId())->update(['location_id' => null]);

        // Create a reservation linked to this location
        $car = Car::first();
        $reservation = new Reservation;
        $reservation->setCode(88229911);
        $reservation->setState(Reservation::STATE_CONFIRMED);
        $reservation->setStartDate(Carbon::now()->addDays(5)->toDateString());
        $reservation->setEndDate(Carbon::now()->addDays(9)->toDateString());
        $reservation->setUserId($this->customer->getId());
        $reservation->setCarId($car->getId());
        $reservation->setLocationId($this->location->getId());
        $reservation->save();

        $response = $this->actingAs($this->admin)->delete(
            route('admin.location.delete', ['id' => $this->location->getId()])
        );

        $response->assertSessionHas('error');
        $this->assertDatabaseHas('locations', ['id' => $this->location->getId()]);
    }

    /** AC 4: Allow deletion when no cars or reservations are referenced */
    public function test_admin_can_delete_unreferenced_location(): void
    {
        // Create an unreferenced standalone location
        $newLocation = new Location;
        $newLocation->setName('Standalone Temporary Branch');
        $newLocation->setAddress('Avenida Temporal # 10');
        $newLocation->setHeadquarters('Temporal');
        $newLocation->setTelephone('3000000000');
        $newLocation->setCity('Bello');
        $newLocation->save();

        $response = $this->actingAs($this->admin)->delete(
            route('admin.location.delete', ['id' => $newLocation->getId()])
        );

        $response->assertRedirect(route('admin.location.index'));
        $this->assertDatabaseMissing('locations', ['id' => $newLocation->getId()]);
    }

    /** AC 5: Customer view */
    public function test_customer_can_browse_locations_list(): void
    {
        $response = $this->actingAs($this->customer)->get(route('locations.index'));

        $response->assertStatus(200);
        $response->assertSee($this->location->getName());
        $response->assertSee($this->location->getCity());
    }

    /** AC 5: Customer view with contact info and available vehicles */
    public function test_customer_can_view_location_with_available_vehicles(): void
    {
        $car = Car::first();
        $car->setLocationId($this->location->getId());
        $car->setStatus(Car::STATUS_ACTIVE);
        $car->save();

        $response = $this->actingAs($this->customer)->get(
            route('locations.show', ['id' => $this->location->getId()])
        );

        $response->assertStatus(200);
        $response->assertSee($this->location->getName());
        $response->assertSee($this->location->getAddress());
        $response->assertSee($this->location->getTelephone());
        $response->assertSee(number_format($car->getPrice(), 0, ',', '.'));
    }

    /** AC 6: Customer cannot access admin routes */
    public function test_customer_cannot_access_admin_location_routes(): void
    {
        $indexResponse = $this->actingAs($this->customer)->get(route('admin.location.index'));
        $indexResponse->assertStatus(403);

        $createResponse = $this->actingAs($this->customer)->get(route('admin.location.create'));
        $createResponse->assertStatus(403);

        $storeResponse = $this->actingAs($this->customer)->post(route('admin.location.store'), []);
        $storeResponse->assertStatus(403);

        $editResponse = $this->actingAs($this->customer)->get(
            route('admin.location.edit', ['id' => $this->location->getId()])
        );
        $editResponse->assertStatus(403);

        $updateResponse = $this->actingAs($this->customer)->put(
            route('admin.location.update', ['id' => $this->location->getId()]),
            []
        );
        $updateResponse->assertStatus(403);

        $deleteResponse = $this->actingAs($this->customer)->delete(
            route('admin.location.delete', ['id' => $this->location->getId()])
        );
        $deleteResponse->assertStatus(403);
    }

    /** AC 6: Unauthenticated user redirected to login */
    public function test_unauthenticated_user_is_redirected_to_login(): void
    {
        $response = $this->get(route('admin.location.index'));
        $response->assertRedirect('/login');

        $customerResponse = $this->get(route('locations.index'));
        $customerResponse->assertRedirect('/login');
    }

    public function test_admin_can_create_car_with_assigned_location(): void
    {
        $category = Category::first();

        $carData = [
            'plate' => 'NEW-999',
            'color' => 'Graphite',
            'soat' => 'SOAT-999999',
            'price' => 120000,
            'transit_license' => 'TL-999999',
            'mileage' => 1000,
            'category_id' => $category->getId(),
            'location_id' => $this->location->getId(),
        ];

        $response = $this->actingAs($this->admin)->post(route('admin.car.store'), $carData);

        $response->assertRedirect(route('admin.car.index'));
        $this->assertDatabaseHas('cars', [
            'plate' => 'NEW-999',
            'location_id' => $this->location->getId(),
        ]);
    }
}
