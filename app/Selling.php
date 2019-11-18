<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Selling extends Model
{
    protected $table = 'sellings';

    protected $guarded = [];

    public function stock()
    {
        return $this->hasMany('App\Stock');
    }
}
