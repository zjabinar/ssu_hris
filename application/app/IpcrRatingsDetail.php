<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IpcrRatingsDetail extends Model
{
    protected $table='ipcr_rating_details';
    protected $fillable=['ipcr_rating_id','employee_id','ipcr_period_id','weight','indicator','group_approval_id','date_approved','group_rating_id','accomplishments','rating_q','rating_e','rating_t','rating_a','rating_wp','remarks'];
}
