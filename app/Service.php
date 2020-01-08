<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $table = 'services';

    protected $guarded = [];

    public function serviceOrder()
    {
        return $this->belongsTo('App\ServiceOrder');
    }

    public function stockDistribution()
    {
        return $this->belongsTo('App\StockDistribution');
    }
}
