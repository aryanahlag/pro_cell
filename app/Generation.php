<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Generation extends Model
{
    protected $table = 'generations';
    protected $dates = ['time'];
    protected $guarded = [];

    public function buying()
    {
        return $this->hasMany('App\Buying');
    }
}
