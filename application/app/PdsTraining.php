<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PdsTraining extends Model
{
    protected $table='pds_trainings';
    protected $fillable=['emp_id','train_title','train_from','train_from', 'train_to','train_hours','train_type','train_conducted_by'];
}
