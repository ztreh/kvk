<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Work_Place extends Model
{
    protected $fillable = ['name','address','tp_mobile', 'tp_land','start_date','end_date'];

    public function device() {
        return $this->hasMany('App\Device');
    }

    // public function device() {
    //     return $this->hasMany('App\Device');
    // }
}
