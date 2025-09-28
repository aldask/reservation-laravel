<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Restaurant;
use App\Models\DiningTable;
use App\Models\Reservation;

class TableAssignmentTest extends TestCase
{
    use RefreshDatabase;

    #[\PHPUnit\Framework\Attributes\Test]
    public function reservation_assigns_multiple_tables_if_needed()
    {
        $restaurant = Restaurant::create([
            'name' => 'Test Restaurant',
            'tables_count' => 3,
            'max_capacity' => 12,
        ]);

        $table1 = DiningTable::create(['restaurant_id' => $restaurant->id, 'name' => 'Table 1', 'seats' => 4]);
        $table2 = DiningTable::create(['restaurant_id' => $restaurant->id, 'name' => 'Table 2', 'seats' => 4]);
        $table3 = DiningTable::create(['restaurant_id' => $restaurant->id, 'name' => 'Table 3', 'seats' => 4]);

        $response = $this->postJson('/api/reservations', [
            'restaurant_id' => $restaurant->id,
            'customer_first_name' => 'Mark',
            'customer_last_name' => 'Twain',
            'customer_email' => 'mark@example.com',
            'customer_phone' => '1234567890',
            'party_size' => 8,
            'start_at' => now()->addDay()->format('Y-m-d H:i:s'),
            'end_at' => now()->addDay()->addHour()->format('Y-m-d H:i:s'),
            'guests' => [
                ['first_name' => 'Guest1'],
                ['first_name' => 'Guest2'],
                ['first_name' => 'Guest3'],
                ['first_name' => 'Guest4'],
                ['first_name' => 'Guest5'],
                ['first_name' => 'Guest6'],
                ['first_name' => 'Guest7'],
                ['first_name' => 'Guest8'],
            ]
        ]);

        $response->assertStatus(201);

        $reservation = Reservation::where('customer_email', 'mark@example.com')->first();
        $this->assertEquals(2, $reservation->tables()->count(), 'Reservation should be assigned to 2 tables');
    }
}