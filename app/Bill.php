<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Bill extends Model
{
    use HasFactory;

    protected $connection = 'mysql_bill';

    public function scopeMonth($query, $month = null)
    {
        return $query->whereMonth('created_at', Carbon::parse('this month'));
    }
}
