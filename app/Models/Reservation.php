<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'restaurant_id',
        'customer_first_name',
        'customer_last_name',
        'customer_email',
        'customer_phone',
        'party_size',
        'start_at',
        'end_at',
    ];

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function tables()
    {
        return $this->belongsToMany(DiningTable::class, 'dining_table_reservation');
    }

    public function guests()
    {
        return $this->hasMany(ReservationGuest::class);
    }
}