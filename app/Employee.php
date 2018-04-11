<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    public function labour() {
        return $this->belongsTo('App\Labour');
    }

    public function leaves() {
        return $this->belongsToMany('App\Leave');
    }
	
	public function advances() {
        return $this->hasMany('App\Advance');
    }

    public function work__places() {
	    return $this->belongsToMany('App\Work_Place','workplace_employee','employees_id','work_places_id');
	    	
	}

}
