<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';

    protected $guarded = ["id"];

    public function stock()
    {
        return $this->hasMany('App\Stock', 'stock_id');
    }
}
