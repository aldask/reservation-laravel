<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReservationGuest extends Model
{
    use HasFactory;

    protected $fillable = [
        'reservation_id',
        'first_name',
        'last_name',
        'email',
    ];

    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }
}