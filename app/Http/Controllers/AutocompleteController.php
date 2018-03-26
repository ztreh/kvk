<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Employee;
use App\Designation;
use App\SalaryMonth;

use Illuminate\Support\Facades\DB;
class AutocompleteController extends Controller
{
    public function searchEmpName(Request $request)
    {
        $term=$request->term;
        $result=array();
        $employee = DB::table('employees')
                    ->where('name', 'like', '%'.$term.'%')
                    ->get();
        foreach ($employee as $emp) {
           array_push($result, $emp->name) ;
        }
        return   $result;
    }

    public function salaryMonthList(Request $request)
    {
       $term = trim($request->q);
       if (empty($term)) {
            return \Response::json([]);
        }

        $tags=DB::table('salary_months')
            ->where("CONCAT(MONTHNAME(STR_TO_DATE(month, '%m')),' ',year)", 'like', '%'.$term.'%')
            ->selectRaw("CONCAT(MONTHNAME(STR_TO_DATE(month, '%m')),' ', year) as year_n_month , id")
            ->get();

        $formatted_tags = [];

        foreach ($tags as $tag) {
            $formatted_tags[] = ['id' => $tag->id, 'text' => $tag->year_n_month];
        }

        return \Response::json($formatted_tags);
    }
    public function getEmployeeNameList(Request $request)
    {
        $term = trim($request->q);

        if (empty($term)) {
            return \Response::json([]);
        }
        $tags = DB::table('employees')
                    ->where('name', 'like', '%'.$term.'%')
                    ->get();

        $formatted_tags = [];

        foreach ($tags as $tag) {
            $name=$tag->name.' '.$tag->nic_no;
            $formatted_tags[] = ['id' => $tag->id, 'text' =>$name ];
        }

        return \Response::json($formatted_tags);
    }

    public function getWorkPlaceList(Request $request)
    {
        $term = trim($request->q);

        if (empty($term)) {
            return \Response::json([]);
        }
        $tags = DB::table('work__places')
                    ->where('name', 'like', '%'.$term.'%')
                    ->get();

        $formatted_tags = [];

        foreach ($tags as $tag) {
            $name=$tag->name;
            $formatted_tags[] = ['id' => $tag->id, 'text' =>$name ];
        }

        return \Response::json($formatted_tags);
    }


    
    public function getDesignationList(Request $request)
    {
        $term = trim($request->q);

        if (empty($term)) {
            return \Response::json([]);
        }
        $tags = DB::table('designations')
                    ->where('name', 'like', '%'.$term.'%')
                    ->get();

        $formatted_tags = [];

        foreach ($tags as $tag) {
            $formatted_tags[] = ['id' => $tag->id, 'text' => $tag->name];
        }

        return \Response::json($formatted_tags);
    }
}
