<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class TimeSlotTime extends Model
{
    //
    protected $fillable = ['workplace_time_slot_id','start_time','end_time','status'];

    public function checkTimeSlotTimeExist(Request $request,$workplace_time_slot_id)
    {
    	return TimeSlotTime::where('start_time', $request->input('start_time'))->where('end_time', $request->input('end_time'))->where('workplace_time_slot_id', $workplace_time_slot_id)->exists(); 
    }

    public function workplace__time__slot()
    {
    	return $this->belongsTo('App\Workplace_Time_Slots','workplace_time_slot_id');
    	// belongs to work-place
    }

    public function insertData(Request $request,$workplace_timeslot_id,$id=0)
    {
        if($id>0){
            $this->workplace_time_slot_id=$workplace_timeslot_id;
            $this->update($request->all()); 
        }else{
            if(!($this->checkTimeSlotTimeExist($request,$workplace_timeslot_id))){
                $this->workplace_time_slot_id=$workplace_timeslot_id;
                $this->save();
            }

        }
    }
    
}
