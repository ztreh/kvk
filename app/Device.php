<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
   protected $fillable = ['name','work_places_id'];

   
    public function work_places() {
        return $this->belongsTo('App\Work_Place','work_places_id');
    }	
}
