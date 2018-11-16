<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PdsOrganization extends Model
{
    protected $table='pds_organizations';
    protected $fillable=['emp_id','org_name','org_from','org_to', 'org_hours','org_position'];
}
