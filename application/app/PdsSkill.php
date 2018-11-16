<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PdsSkill extends Model
{
    protected $table='pds_skills';
    protected $fillable=['emp_id','name'];
}
