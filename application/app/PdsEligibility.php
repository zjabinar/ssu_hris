<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PdsEligibility extends Model
{
    protected $table='pds_eligibilities';
    protected $fillable=['emp_id','elig_name','elig_rating','elig_date', 'elig_place','elig_license','elig_expiry'];
}
