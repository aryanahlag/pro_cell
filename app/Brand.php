<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $table = 'brands';

    protected $guarded = [];

    public function stock()
    {
        return $this->hasMany('App\Stock');
    }
}
