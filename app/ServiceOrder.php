<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiceOrder extends Model
{
    protected $table = 'service_orders';

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function service()
    {
        return $this->hasMany('App\Service');
    }
}
