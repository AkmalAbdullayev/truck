<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpFoundation\Request;
use Illuminate\Auth\Events\Validated;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use SoftDeletes;

    protected $fillable = ['status', 'name'];

    public function driver()
    {
        return $this->belongsTo('App\Driver', "driver_id");
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
