<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $connection = 'mysql_bill';

    protected $appends = ['full_name'];

    public function bill()
    {
        return $this->hasOne('App\Bill')->month();
    }

    public function consumption_type()
    {
        return $this->belongsTo('App\ConsumptionType', 'consumption_type_id');
    }

    public function getFullNameAttribute()
    {
        return "{$this->last_name} {$this->middle_name} {$this->first_name}";
    }
}
