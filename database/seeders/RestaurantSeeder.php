<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Restaurant;
use App\Models\DiningTable;

class RestaurantSeeder extends Seeder
{
    public function run(): void
    {
        $restaurants = [
            [
                'name' => 'Liuksas',
                'tables_count' => 5,
                'max_capacity' => 20,
                'table_seats' => 4,
            ],
            [
                'name' => 'Mažasis bistro',
                'tables_count' => 3,
                'max_capacity' => 12,
                'table_seats' => 4,
            ],
            [
                'name' => 'Little Italy',
                'tables_count' => 10,
                'max_capacity' => 50,
                'table_seats' => 5,
            ],
            [
                'name' => 'Todžė',
                'tables_count' => 4,
                'max_capacity' => 16,
                'table_seats' => 4,
            ],
        ];

        foreach ($restaurants as $r) {
            $restaurant = Restaurant::create([
                'name' => $r['name'],
                'tables_count' => $r['tables_count'],
                'max_capacity' => $r['max_capacity'],
            ]);

            for ($i = 1; $i <= $restaurant->tables_count; $i++) {
                DiningTable::create([
                    'restaurant_id' => $restaurant->id,
                    'name' => "Table $i",
                    'seats' => $r['table_seats'],
                ]);
            }
        }
    }
}