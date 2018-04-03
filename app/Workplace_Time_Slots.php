<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Workplace_Time_Slots extends Model
{
    //
    protected $fillable = ['time_slot_id','work_places_id'];

    public function checkExist($time_slot_id,$work_places_id)
    {
        return Workplace_Time_Slots::where('time_slot_id', $time_slot_id)->where('work_places_id', $work_places_id)->exists(); 
    }

    public function getWorkplaceTimeSlotId($time_slot_id,$work_places_id)
    {
    	return Workplace_Time_Slots::where('time_slot_id', $time_slot_id)->where('work_places_id', $work_places_id)->first()->id; 
    }

    public function time_slots()
    {
    	// belongs to time-slots
    	return $this->belongsTo('App\TimeSlot','time_slot_id');
    }

    public function time_slot_times()
    {
    	return $this->hasMany('App\TimeSlotTime','workplace_time_slot_id');
    	// has many time-slots-time
    }

    public function work_places()
    {
    	return $this->belongsTo('App\Work_Place','work_places_id');
    	// belongs to work-place
    }
 
    public function insertData(Request $request,$timeslot_id)
    {
        
        if(!($this->checkExist($timeslot_id,$request->input('work_places_id')))){
            $this->time_slot_id=$timeslot_id;
            $this->work_places_id=$request->input('work_places_id');
            $this->save();
            $workplace_timeslot_id=$this->id;
          
        }else{
            $workplace_timeslot_id=$this->getWorkplaceTimeSlotId($timeslot_id,$request->input('work_places_id'));
        }

        return $workplace_timeslot_id;
    }

 

    
}
