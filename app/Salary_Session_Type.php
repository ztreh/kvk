<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Salary_Session_Type extends Model
{
    protected $fillable = ['name'];

    public function salary_session_work_places() {
        return $this->hasMany('App\SalarySessionWorkPlace');
    }

    	
}
