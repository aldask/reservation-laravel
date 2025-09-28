<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Restaurant;

class ReservationController extends Controller
{
    public function index()
    {
        return Reservation::with(['restaurant', 'tables', 'guests'])->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'restaurant_id' => 'required|exists:restaurants,id',
            'customer_first_name' => 'required|string|max:255',
            'customer_last_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
            'party_size' => 'required|integer|min:1',
            'start_at' => 'required|date',
            'end_at' => 'required|date|after:start_at',
            'guests' => 'required|array|min:1',
            'guests.*.first_name' => 'required|string|max:255',
            'guests.*.last_name' => 'nullable|string|max:255',
            'guests.*.email' => 'nullable|email|max:255',
        ]);

        $restaurant = Restaurant::with('tables')->findOrFail($validated['restaurant_id']);
        $totalSeats = $restaurant->tables->sum('seats');
        $neededSeats = $validated['party_size'];
        $start = $validated['start_at'];
        $end = $validated['end_at'];

        if ($totalSeats < $neededSeats) {
            if ($request->wantsJson()) {
                return response()->json(['message' => 'Party size exceeds restaurant capacity'], 422);
            }
            return redirect()->back()->withErrors(['party_size' => 'Party size exceeds restaurant capacity']);
        }

        $availableTables = [];
        foreach ($restaurant->tables as $table) {
            $conflict = $table->reservations()
                ->where(function ($q) use ($start, $end) {
                    $q->whereBetween('start_at', [$start, $end])
                        ->orWhereBetween('end_at', [$start, $end])
                        ->orWhere(function ($q2) use ($start, $end) {
                            $q2->where('start_at', '<', $start)
                                ->where('end_at', '>', $end);
                        });
                })->exists();

            if (!$conflict) {
                $availableTables[] = $table;
                $neededSeats -= $table->seats;
                if ($neededSeats <= 0)
                    break;
            }
        }

        if ($neededSeats > 0) {
            if ($request->wantsJson()) {
                return response()->json(['message' => 'Not enough free tables for this time'], 422);
            }
            return redirect()->back()->withErrors(['tables' => 'Not enough free tables for this time']);
        }

        $reservation = Reservation::create($validated);
        $reservation->tables()->attach(array_map(fn($t) => $t->id, $availableTables));
        $reservation->guests()->createMany($validated['guests']);

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Reservation created successfully',
                'reservation' => $reservation->load(['guests', 'tables', 'restaurant'])
            ], 201);
        }

        return redirect()->back()->with('success', 'Reservation created successfully!');
    }

}