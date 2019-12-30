<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StockDistribution extends Model
{
    public function cabang()
    {
        return $this->belongsTo('App\Cabang');
    }

    public function selling()
    {
        return $this->belongsTo('App\Selling');
    }

    public function stock()
    {
        return $this->belongsTo('App\Stock');
    }
}
