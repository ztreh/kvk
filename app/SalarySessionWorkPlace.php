<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SalarySessionWorkPlace extends Model
{
    protected $fillable = ['work_places_id','salary_sessions_id','salary_session_types_id', 'start_date','end_date'];

	//     belongs -->Workplace Name *
	// Salary Session *
	// Salary Session Type *
	public function advances(){
        return $this->hasMany('App\Advance');

	}
	public function work__places() {
	    return $this->belongsTo('App\Work_Place','work_places_id');
	}

	public function salary__sessions() {
	    return $this->belongsTo('App\Salary_Session','salary_sessions_id');
	}

	public function salary__session__types() {
	    return $this->belongsTo('App\Salary_Session_Type','salary_session_types_id');
	}

	public function getDetails($id)
	{
		$raw=$this->find($id);
		return $raw->work__places->name.", ".$raw->salary__sessions->name.", ".$raw->salary__session__types->name;
	}
}
