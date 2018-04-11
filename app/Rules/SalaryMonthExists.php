<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class SalaryMonthExists implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        

        $salary_month=DB::table('salary_session_work_places')
                    ->where('id', $value)
                    ->first();
        
        if(count($salary_month)>0){
            return true;
        }else{
            return false;
        }
     
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return "The :attribute doesn't exists " ;
    }
}
