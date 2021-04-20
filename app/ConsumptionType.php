<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsumptionType extends Model
{
    use HasFactory;

    protected $connection = 'mysql_bill';
}
