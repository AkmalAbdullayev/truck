<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id', 'source', 'from', 'to',
        'pickup_time', 'commodity', 'weight',
        'drive_price', 'load_number', 'status_id', 'bol_image'
    ];
    public function users()
    {
        return $this->belongsTo('App\User', "user_id");
    }
    public function status()
    {
        return $this->belongsTo('App\Status', "status_id");
    }

    public function calls()
    {
        return $this->hasMany('App\Call');
    }
}
