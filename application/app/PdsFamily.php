<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PdsFamily extends Model
{
    protected $table='pds_families';
    protected $fillable=['emp_id','name','birthdate'];
}
