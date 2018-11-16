<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IpcrGroupsMember extends Model
{
    protected $table='ipcr_group_members';
    protected $fillable=['ipcr_group_id','employee_id'];
}
