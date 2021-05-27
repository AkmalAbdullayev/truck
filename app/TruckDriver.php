<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TruckDriver extends Model
{
    protected $fillable = ['truck_id', 'driver_id', 'date'];

    public function trucks()
    {
        return $this->belongsTo('App\Truck', "truck_id");
    }
    public function drivers()
    {
        return $this->belongsTo('App\Driver', "driver_id");
    }
}
