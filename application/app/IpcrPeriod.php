<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IpcrPeriod extends Model
{
    protected $table='ipcr_periods';
    protected $fillable=['name','rating_period', 'description', 'status','year','period_from','period_to','dep_id'];
}
