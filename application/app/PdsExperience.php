<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PdsExperience extends Model
{
    protected $table='pds_experiences';
    protected $fillable=['emp_id','work_from','work_to','work_position', 'work_company','work_salary','work_grade','work_status','work_is_gov'];
}
