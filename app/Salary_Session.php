<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Salary_Session extends Model
{
    protected $fillable = ['name','year','month', 'status','start_date','end_date'];

    /*public function salary_session_work_places() {
        return $this->hasMany('App\SalarySessionWorkPlace','salary_sessions_id');
    }*/

    /*public function work_places()
	{
		return $this->belongsTo('App\Work_Place');
	}*/
	/*public function salary__sessions()
	{
		return $this->belongsToMany('App\Work_Place');
		
	}*/
	
	public function work__places()
    {
        return $this->belongsToMany('App\Work_Place', 'salary_session_work_places','salary_sessions_id','work_places_id')->withPivot('name');
    }
	
	public function salary__session__types()
    {
        return $this->belongsToMany('App\Salary_Session_Type', 'salary_session_work_places','salary_sessions_id','salary_session_types_id')->withPivot('name');
    }

// `work_places_id`, `salary_sessions_id`, `salary_session_types_id`,			
}
