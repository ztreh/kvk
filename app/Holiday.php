<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Holiday extends Model
{
    //
    protected $fillable = ['name','status','duration'];

    public function holiday_workplaces() {
        return $this->hasMany('App\HolidayWorkplace','holidays_id');
    }
}
