<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $table = 'employees';

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function cabang()
    {
    	return $this->belongsTo(Cabang::class);
    }
}
