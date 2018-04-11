<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Salary_Session_Type extends Model
{
    protected $fillable = ['name'];

    public function salary_session_work_places() {
        return $this->hasMany('App\SalarySessionWorkPlace','salary_session_types_id');
    }

    public function work__places()
    {
        return $this->belongsToMany('App\Work_Place', 'salary_session_work_places','salary_session_types_id','work_places_id')->withPivot('name');
    }
	
	public function salary__sessions()
    {
        return $this->belongsToMany('App\Salary_Session', 'salary_session_work_places','salary_session_types_id','salary_sessions_id')->withPivot('name');
    }	
}
