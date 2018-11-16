<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IpcrMfoGroup extends Model
{
    protected $table='ipcr_mfo_groups';
    protected $fillable=['name','description','srot'];
}
