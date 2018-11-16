<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IpcrEmployee extends Model
{
    protected $table='ipcr_employees';
    protected $fillable=['ipcr_period_id','employee_id', 'dep_id', 'rating_period','year'];
}
