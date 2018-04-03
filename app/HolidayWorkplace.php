<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HolidayWorkplace extends Model
{
    //
    protected $fillable = ['start_date','status','start_time','holidays_id','end_date','end_time','work_places_id'];

    public function holidays()
    {
    	// belongs to time-slots
    	return $this->belongsTo('App\Holiday','holidays_id');
    }
}
