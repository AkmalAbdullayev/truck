<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $fillable = ['name'];

    public function companies()
    {
        return $this->belongsTo('App\Company', "company_id");
    }
}
