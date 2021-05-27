<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Truck extends Model
{
    protected $fillable = ['name', 'company_id', 'plate_number', 'info'];
    public function companies()
    {
        return $this->belongsTo('App\Company', "company_id");
    }
}
