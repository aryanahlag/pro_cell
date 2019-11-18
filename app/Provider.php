<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    protected $table = 'providers';

    protected $guarded = [];

    public function stock()
    {
        return $this->hasMany('App\Stock', 'stock_id');
    }
}
