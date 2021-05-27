<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Call extends Model
{
    protected $fillable = ['order_id', 'driver_id', 'duration', 'file'];

    public function order()
    {
        return $this->belongsTo('App\Order');
    }

    public function driver()
    {
        return $this->belongsTo('App\Driver');
    }
}
