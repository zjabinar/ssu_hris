<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    protected $table='loans_records';

    /* employee_name  Function Start Here */
    public function employee_info()
    {
        return $this->hasOne('App\Employee','record_id','employee_id');
    }

}
