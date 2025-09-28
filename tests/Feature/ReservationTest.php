<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Restaurant;
use App\Models\DiningTable;

class ReservationTest extends TestCase
{
    use RefreshDatabase;

    private function createRestaurantWithTables($tables = 2, $seats = 4)
    {
        $restaurant = Restaurant::create([
            'name' => 'Res Test',
            'tables_count' => $tables,
            'max_capacity' => $tables * $seats
        ]);

        for ($i = 1; $i <= $tables; $i++) {
            DiningTable::create([
                'restaurant_id' => $restaurant->id,
                'name' => "Table $i",
                'seats' => $seats
            ]);
        }

        return $restaurant;
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function can_create_reservation()
    {
        $restaurant = $this->createRestaurantWithTables(2, 4);

        $response = $this->post('/reservations', [
            'restaurant_id' => $restaurant->id,
            'customer_first_name' => 'David',
            'customer_last_name' => 'James',
            'customer_email' => 'dcas@mail.com',
            'customer_phone' => '1234567890',
            'party_size' => 4,
            'start_at' => now()->addDay()->format('Y-m-d H:i:s'),
            'end_at' => now()->addDay()->addHours(2)->format('Y-m-d H:i:s'),
            'guests' => [
                ['first_name' => 'Guest1', 'last_name' => 'Last1', 'email' => 'g1@mail.com'],
                ['first_name' => 'Guest2', 'last_name' => 'Last2', 'email' => 'g2@mail.com']
            ]
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('reservations', ['customer_first_name' => 'David']);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function cannot_create_reservation_exceeding_capacity()
    {
        $restaurant = $this->createRestaurantWithTables(1, 4);

        $response = $this->post('/reservations', [
            'restaurant_id' => $restaurant->id,
            'customer_first_name' => 'Alice',
            'customer_last_name' => 'Smith',
            'customer_email' => 'alice@mail.com',
            'customer_phone' => '1234567890',
            'party_size' => 10,
            'start_at' => now()->addDay()->format('Y-m-d H:i:s'),
            'end_at' => now()->addDay()->addHours(2)->format('Y-m-d H:i:s'),
            'guests' => [
                ['first_name' => 'Guest1', 'last_name' => 'Last1', 'email' => 'g1@mail.com']
            ]
        ]);

        $response->assertSessionHasErrors('party_size');
        $this->assertDatabaseCount('reservations', 0);
    }
}