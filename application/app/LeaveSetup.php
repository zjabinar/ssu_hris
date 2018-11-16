<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LeaveSetup extends Model
{
    protected $table='sys_leave_setup';
    protected $fillable = ['year_active','monthly_earned_sl','monthly_earned_vl'];
}
