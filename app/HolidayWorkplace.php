<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class HolidayWorkplace extends Model
{
    //
    protected $fillable = ['start_date','status','start_time','holidays_id','end_date','end_time','work_places_id'];

    public function holidays()
    {
    	// belongs to time-slots
    	return $this->belongsTo('App\Holiday','holidays_id');
    }

    public function work_places()
    {
    	// belongs to time-slots
    	return $this->belongsTo('App\Work_Place','work_places_id');
    }


    public function insertData(Request $request,$holidays_id,$id=0)
    {
      
        $this->holidays_id=$holidays_id;
        if($id>0){
            $this->update($request->all()); 
        }else{
            $this->save();
        }
        
    }
}
