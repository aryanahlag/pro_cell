<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';

    protected $guarded = [];

    public function stock()
    {
        return $this->hasMany('App\Stock', 'stock_id');
    }
}
