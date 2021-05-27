<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    protected $fillable = ['name', 'driver_type_id', 'company_id'];
    public function companies()
    {
        return $this->belongsTo('App\Company', "company_id");
    }
    public function drivertypes()
    {
        return $this->belongsTo('App\DriverType', "driver_type_id");
    }
}
