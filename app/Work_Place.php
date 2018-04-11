<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Work_Place extends Model
{
    protected $fillable = ['name','address','tp_mobile', 'tp_land','start_date','end_date'];


    public function device() {
        return $this->hasMany('App\Device','work_places_id');
    }

    public function salary_session_work_places() {
        return $this->hasMany('App\SalarySessionWorkPlace','work_places_id');
    }
    public function workplace_time_slot() {
        return $this->hasMany('App\Workplace_Time_Slots');
    }

    public function holiday_workplaces() {
        return $this->hasMany('App\HolidayWorkplace');
    }

     public function employees()
    {
        // belongs to time-slots
        return $this->belongsToMany('App\Employee','workplace_employee','work_places_id','employees_id');
    }

    /*public function salary_session() {
        return $this->hasMany('App\Salary_Session');
    }*/

   /* public function salary__session__types()
    {
        return $this->belongsToMany('App\Salary_Session_Type', 'salary_session_work_places','work_places_id','salary_session_types_id')->withPivot('name');
    }

    public function salary__sessions()
    {
        return $this->belongsToMany('App\Salary_Session', 'salary_session_work_places','work_places_id','salary_sessions_id')->withPivot('name');
    }*/
} 
