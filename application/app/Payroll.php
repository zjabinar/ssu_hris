<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Payroll extends Model
{
    protected $table='payroll';

    /* department  Function Start Here */
    public function payroll_period()
    {
        return $this->hasOne('App\PayrollPeriod','id','payroll_period_id');
    }


}
