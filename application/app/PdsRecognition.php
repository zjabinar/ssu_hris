<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PdsRecognition extends Model
{
    protected $table='pds_recognitions';
    protected $fillable=['emp_id','name'];
}
