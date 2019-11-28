<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Buying extends Model
{
    protected $table = 'buyings';

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function stock()
    {
        return $this->hasMany('App\Stock');
    }
}
