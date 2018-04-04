<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Holiday extends Model
{
    //
    protected $fillable = ['name','status','duration'];

    public function holiday_workplaces() {
        return $this->hasMany('App\HolidayWorkplace','holidays_id');
    }

     public function checkHolidayExist($name='')
    {
    	return Holiday::where('name', $name)->exists(); 
    }

    public function getID($name='')
    {
    	return Holiday::where('name', $name)->first()->id; 
    }

    public function insertData(Request $request)
    {
        if(!($this->checkHolidayExist($request->input('name')))){
            $this->save();
            $holiday_id=$this->id;
        }else{
            $holiday_id=$this->getID($request->input('name'));
        } 

        return $holiday_id; 
    }
}
