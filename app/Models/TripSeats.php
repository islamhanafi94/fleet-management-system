<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TripSeats extends Model
{
    use HasFactory;
    public $timestamps = false;

    public function trip()
    {
        return $this->belongsMany(Trip::class);
    }

}
