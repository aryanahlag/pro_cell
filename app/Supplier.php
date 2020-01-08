<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $table = 'suppliers';

    protected $guarded = [];

    public function stock()
    {
        return $this->hasMany('App\Stock');
    }
}
