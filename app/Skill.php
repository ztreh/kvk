<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    public function labour_skill() {
        return $this->hasMany('App\Labour_Skill');
    }
}
