<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Restaurant;

class RestaurantTest extends TestCase
{
    use RefreshDatabase;

    #[\PHPUnit\Framework\Attributes\Test]
    public function can_create_restaurant()
    {
        $response = $this->post('/restaurants', [
            'name' => 'Test Restaurant',
            'tables_count' => 3,
            'max_capacity' => 12,
            'table_seats' => 4,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('restaurants', ['name' => 'Test Restaurant']);
        $this->assertDatabaseCount('dining_tables', 3);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function can_list_all_restaurants()
    {
        Restaurant::create([
            'name' => 'List Restaurant',
            'tables_count' => 2,
            'max_capacity' => 8,
        ]);

        $response = $this->get('/restaurants');
        $response->assertStatus(200);
        $response->assertSee('List Restaurant');
    }
}