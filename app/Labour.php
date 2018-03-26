<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Labour extends Model
{
    //labours has many skills
    public function labour_skill() {
        return $this->hasMany('App\Labour_Skill');
    }

    public function employee() {
        return $this->belongsTo('App\Employee');
    }
}
