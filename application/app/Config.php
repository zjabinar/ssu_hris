<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    protected $table='config';
    protected $fillable = ['emp_president','emp_president_pos','emp_vp_acad','emp_vp_acad_pos','emp_vp_admin','emp_vp_admn_pos','emp_vp_research','emp_vp_research_pos','emp_admin','emp_admin_pos','emp_finance','emp_finance_pos','emp_hrmo','emp_hrmo_pos','emp_accountant','emp_accountant_pos','emp_cashier','emp_cashier_pos'];
}
