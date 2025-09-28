<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Restaurant;
use App\Models\DiningTable;

class RestaurantController extends Controller
{
    public function index()
    {
        $restaurants = Restaurant::with("tables")->get();
        return response()->json($restaurants);
    }

    public function show(Restaurant $restaurant)
    {
        $restaurant->load('tables');
        return response()->json($restaurant);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'tables_count' => 'required|integer|min:1',
            'max_capacity' => 'required|integer|min:1',
            'table_seats' => 'required|integer|min:1'
        ]);

        $restaurant = Restaurant::create([
            'name' => $validated['name'],
            'tables_count' => $validated['tables_count'],
            'max_capacity' => $validated['max_capacity']
        ]);

        for ($i = 1; $i <= $validated['tables_count']; $i++) {
            DiningTable::create([
                'restaurant_id' => $restaurant->id,
                'name' => "Table $i",
                'seats' => $validated['table_seats']
            ]);
        }

        return redirect()->back()->with('success', 'Restaurant created successfully!');
    }
}