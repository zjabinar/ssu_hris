<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PdsMembership extends Model
{
    protected $table='pds_memberships';
    protected $fillable=['emp_id','name'];
}
