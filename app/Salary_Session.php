<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Salary_Session extends Model
{
    protected $fillable = ['name','year','month', 'status','start_date','end_date'];

    public function salary_session_work_places() {
        return $this->hasMany('App\SalarySessionWorkPlace');
    }	
}
