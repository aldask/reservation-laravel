<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Reservation;
use App\Models\ReservationGuest;
use App\Models\Restaurant;

class ReservationSeeder extends Seeder
{
    public function run(): void
    {
        $restaurants = Restaurant::with('tables')->get();

        foreach ($restaurants as $restaurant) {
            // Skipping very small restaurants
            if ($restaurant->tables()->count() < 2) {
                continue;
            }

            // Create 2 reservations per restaurant
            for ($i = 1; $i <= 2; $i++) {
                $start = now()->addDays($i)->setHour(18);
                $end = (clone $start)->addHours(2);

                $party_size = rand(2, max(2, $restaurant->max_capacity / 2));

                $reservation = Reservation::create([
                    'restaurant_id' => $restaurant->id,
                    'customer_first_name' => "GuestFirst{$i}",
                    'customer_last_name' => "GuestLast{$i}",
                    'customer_email' => "guest{$i}_rest{$restaurant->id}@mail.com",
                    'customer_phone' => "1234567890",
                    'party_size' => $party_size,
                    'start_at' => $start,
                    'end_at' => $end,
                ]);

                // Assign tables (allocate until enough seats)
                $neededSeats = $party_size;
                $availableTables = [];
                foreach ($restaurant->tables as $table) {
                    if ($neededSeats <= 0)
                        break;
                    $availableTables[] = $table->id;
                    $neededSeats -= $table->seats;
                }
                $reservation->tables()->attach($availableTables);

                // Add guests (unique emails per reservation + guest)
                for ($g = 1; $g <= $party_size; $g++) {
                    ReservationGuest::create([
                        'reservation_id' => $reservation->id,
                        'first_name' => "Guest{$g}",
                        'last_name' => "Lastname{$g}",
                        'email' => "guest{$reservation->id}_{$g}@mail.com",
                    ]);
                }
            }
        }
    }
}