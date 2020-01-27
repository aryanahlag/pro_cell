<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StockDistribution extends Model
{
    protected $table = 'stock_distributions';

    protected $guarded = [];

    public function cabang()
    {
        return $this->belongsTo('App\Cabang');
    }

    public function stock()
    {
        return $this->belongsTo('App\Stock');
    }
}
