<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $table = 'services';

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function item_service()
    {
        return $this->hasMany('App\ItemService');
    }
}
