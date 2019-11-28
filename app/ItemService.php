<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemService extends Model
{
    protected $table = 'item_services';

    protected $guarded = [];

    public function service()
    {
        return $this->belongsTo('App\Service');
    }
}
