<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
}
