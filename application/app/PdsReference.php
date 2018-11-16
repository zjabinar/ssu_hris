<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PdsReference extends Model
{
    protected $table='pds_references';
    protected $fillable=['emp_id','ref_name','ref_address','ref_tel'];
}
