<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SalarySessionWorkPlace extends Model
{
    protected $fillable = ['work_places_id','salary_sessions_id','salary_session_types_id', 'start_date','end_date'];

	//     belongs -->Workplace Name *
	// Salary Session *
	// Salary Session Type *
	
	public function work_places() {
	    return $this->belongsTo('App\Work_Place');
	}

	public function salary__sessions() {
	    return $this->belongsTo('App\Salary_Session');
	}

	public function salary_session_type() {
	    return $this->belongsTo('App\Salary_Session_Type');
	}

}
