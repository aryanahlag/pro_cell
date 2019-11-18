<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $table = 'stocks';

    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    public function provider()
    {
        return $this->belongsTo('App\Provider');
    }

    public function buying()
    {
        return $this->belongsTo('App\Buying');
    }
}
