<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['name'];


    public function seats()
    {
        return $this->hasMany(TripSeats::class);
    }


    public function stations()
    {
        return $this->hasMany(TripStations::class);
    }


    public function passingers()
    {
        return $this->hasMany(TripUser::class);
    }


    public function emptySeats($station_id) {
        $station = $this->stations()->where('station_id',$station_id)->first('order');

        $stations = $this->stations()
                            ->where([
                                    ['order','<=' ,$station->order]
                                ])
                            ->pluck('id');

        return $this->seats()->where('empty_at_station',null)
                        ->orWhereIn('empty_at_station',$stations)
                        ->get(['id','code']);
    }


    public function hasValidStations($from,$to){
        if (!$this->hasStation($from) ||  !$this->hasStation($to)) {
            return False;
        }

        $origin_order = $this->stations()->where('station_id',$from)->get('order');
        $destination_order = $this->stations()->where('station_id',$to)->get('order');

        return $destination_order > $origin_order ?  True : False;
    }


    protected function hasStation($station_id){
        $station = $this->stations()->where('station_id',$station_id)->first();
        return is_null($station) ? FALSE : TRUE;
        
    }

    protected function isValidSeat($seat_id, $station_id) {
        $seat = $this->seats()->where([
                    ['empty_at_station','=',$station_id],
                    ['id','=',$seat_id]
                    ])->first(['id','code']);
        
        return $seat ? TRUE : FALSE;
    }



    public function addPassenger($passenger_id,$from,$to,$seat_id){
        if (!$this->hasValidStations($from,$to)){
            return response()->json(["error" => "Invalid Stations"], 422);
        }

        if (empty($this->emptySeats($from))) {
            return response()->json(["error" => "This Trip Has no empty seats"], 422);
        }

        if (!$this->isValidSeat($seat_id, $from)) {
            return response()->json(["error" => "Invalid Seat"], 422);
        }

        

        $seat = TripSeats::find($seat_id);
        $seat->empty_at_station = $to;
        $seat->save();
        

        $this->passingers()->create([
            'user_id' => $passenger_id,
            'start_station' => $from,
            'end_station' => $to,
            'seat_id' => $seat_id
        ]);

        return $this->seats()->where('id',$seat_id)->first();
    }

}
