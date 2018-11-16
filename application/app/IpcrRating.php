<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IpcrRating extends Model
{
    protected $table='ipcr_ratings';
    protected $fillable=['ipcr_emp_rec_id','employee_id','ipcr_period_id','mfo_group_id','mfo_group_sort','mfo_name','default_weight'];
}
