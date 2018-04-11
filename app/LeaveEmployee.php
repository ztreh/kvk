<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class LeaveEmployee extends Model
{
	protected $fillable = ['start_date','employees_id','start_time','leaves_id','end_date','end_time','remarks'];
	
    public function leaves()
    {
    	// belongs to time-slots
    	return $this->belongsTo('App\Leave','leaves_id');
    }
    
    public function employees()
    {
    	// belongs to time-slots
    	return $this->belongsTo('App\Employee','employees_id');
    }

    public function insertData(Request $request,$leaves_id,$id=0)
    {
      
        $this->leaves_id=$leaves_id;
        if($id>0){
            $this->update($request->all()); 
        }else{
            $this->save();
        }
        
    }

}
