<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Labour_Skill extends Model
{
    public function labour()
	{
	    return $this->belongsToMany('App\Labour');
	}
	 public function skill()
	{
	    return $this->belongsToMany('App\Labour');
	}
}
