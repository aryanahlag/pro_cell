<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $table = 'admins';

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
