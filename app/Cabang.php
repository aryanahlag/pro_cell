<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cabang extends Model
{
    protected $table = 'cabangs';

    protected $guarded = [];

    public function employee()
    {
    	return $this->hasMany(Employee::class);
    }

    public function stockDistribution()
    {
    	return $this->hasMany(StockDistribution::class);
    }

    public function service()
    {
    	return $this->hasMany(Service::class);
    }
}
