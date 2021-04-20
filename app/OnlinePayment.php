<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OnlinePayment extends Model
{
    use HasFactory;

    protected $connection = 'mysql_bill';

    protected $guarded = [];

    public function getAmountAttribute($value)
    {
        return $value/100;
    }
    
    public function setAmountAttribute($value)
    {
        $this->attributes['amount'] = $value * 100;
    }
}
