<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class TimeSlot extends Model
{
    //
    protected $fillable = ['name'];

    public function checkSlotNameExist($name='')
    {
    	return TimeSlot::where('name', $name)->exists(); 
    }

    public function getID($name='')
    {
    	return TimeSlot::where('name', $name)->first()->id; 
    }

     public function work_place_time_slots() {
        return $this->hasMany('App\Workplace_Time_Slots','time_slot_id');
    }
    

    public function insertData(Request $request)
    {
        if(!($this->checkSlotNameExist($request->input('name')))){
            $this->save();
            $timeslot_id=$this->id;
        }else{
            $timeslot_id=$this->getID($request->input('name'));
        } 

        return $timeslot_id; 
    }
}
