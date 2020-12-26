<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TripUser extends Model
{
    use HasFactory;
    public $timestamps = false;
    public $fillable = [
        'user_id',
        'start_station',
        'end_station' ,
        'seat_id' 
    ];
}
