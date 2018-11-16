<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IpcrGroup extends Model
{
    protected $table='ipcr_groups';
    protected $fillable=['name','description'];
}
