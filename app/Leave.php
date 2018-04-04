<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Leave extends Model
{
    //
    protected $fillable = ['name','duration','status'];

    public function leave_employees() {
        return $this->hasMany('App\LeaveEmployee','leaves_id');
    }

     public function checkLeaveExist($name='')
    {
    	return Leave::where('name', $name)->exists(); 
    }

    public function getID($name='')
    {
    	return Leave::where('name', $name)->first()->id; 
    }

    public function insertData(Request $request)
    {
        if(!($this->checkLeaveExist($request->input('name')))){
            $this->save();
            $leaves_id=$this->id;
        }else{
            $leaves_id=$this->getID($request->input('name'));
        } 

        return $leaves_id; 
    }
}
