<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    public function labour() {
        return $this->belongsTo('App\Labour');
    }
}
