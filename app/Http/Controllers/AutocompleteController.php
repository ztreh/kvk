<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Employee;
use App\Designation;
use App\SalaryMonth;

use Illuminate\Support\Facades\DB;
class AutocompleteController extends Controller
{

    public function getValue(Request $request)
    {   
       
        $table_name="";
        $where_column_array="name";
        $where_condition="like";
        $return_type=0;
        
        switch($this->getURI()){
            case "/salarysessiontype":
                $table_name="salary__session__types";
                $return_type=1;
                break;
            case "/salarysession":
                $table_name="salary__sessions";
                $return_type=1;
                break;
            case "/workpalces":
                $table_name="work__places";
                $return_type=1;
                break;
            case "/deslist":
                $table_name="designations";
                $return_type=1;
                break;
            case "/emplist":
                $table_name="employees";
                $return_type=1;
                break;
            case "/holidayname":
                $table_name="holidays";
                $return_type=2;
                break;
            case "/leavename":
                $table_name="leaves";
                $return_type=2;
                break;
            case "/timeslotname":
                $table_name="time_slots";
                $return_type=2;
                break;
            case "/searchempname":
                $table_name="time_slots";
                $return_type=2;
                break;
            default:
                break;

        }

        if(isset($request->q)){
            $where_value=trim($request->q);;

        }elseif(isset($request->term)){
            $where_value=$request->term;

        }

        if (empty($where_value)) {
            return \Response::json([]);
        }
        

        $tags = DB::table($table_name)
            ->where($where_column_array, $where_condition, '%'.$where_value.'%')
            ->get();

        if($return_type==1){
            $formatted_tags = [];

            foreach ($tags as $tag) {
                $formatted_tags[] = ['id' => $tag->id, 'text' =>$tag->name];
            }

            return \Response::json($formatted_tags);

        }elseif($return_type==2){
            $result=array();
            foreach ($tags as $emp) {
               array_push($result, $emp->name) ;
            }
            return   $result; 
        }
    }

    public function getURI()
    {
        $uri=$_SERVER["REQUEST_URI"];
        $uri=str_replace("/autocomplete","",$uri);
        $get_function_name=explode("?", $uri);
       
        return $get_function_name[0];
    }
    
    
    

    


 

}
