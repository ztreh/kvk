<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Employee;
use App\Designation;
use App\SalaryMonth;
use App\Work_Place;
use App\Salary_Session;
use App\Salary_Session_Type;
use App\SalarySessionWorkPlace;

use Illuminate\Support\Facades\DB;
class AutocompleteController extends Controller
{

		public function getValue(Request $request,$table_name="",$return_type=0)
		{   
				$where_column_array="name";
				$where_condition="like";
			 
				if(isset($request->q)){
						$where_value=trim($request->q);

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
				$uri=str_replace("/autocomplete/","",$uri);
				$get_function_name=explode("?", $uri);
				
				if(isset($get_function_name[0])){
						return $get_function_name[0];
						
				}
		}
		
	 /* public function salarySessionWorkplace(Request $request)
		{

		 
						return \Response::json($formatted_tags); 
		}*/
		
		public function salarySessionWorkplace(Request $request)
		{
			$term = trim($request->q);

			if (empty($term)) {
				return \Response::json([]);
			}
			$work_places_arr=Work_Place::where('name', 'like', '%'.$term.'%')->select('id')->get()->toArray();

			$salary_session_arr=Salary_Session::where('name', 'like', '%'.$term.'%')->select('id')->get()->toArray();

			$salary_session_type_arr=Salary_Session_Type::where('name', 'like', '%'.$term.'%')->select('id')->get()->toArray();

			$salary_session_workplaces=SalarySessionWorkPlace::whereIn('work_places_id', $work_places_arr)->whereIn('salary_sessions_id', $salary_session_arr)->whereIn('salary_session_types_id', $salary_session_type_arr)->get(); 

			$formatted_tags = [];
    		$salary_session_work_place=new SalarySessionWorkPlace;
			foreach ($salary_session_workplaces as $key) {
				$formatted_tags[] = ['id' => $key->id, 'text' =>$salary_session_work_place->getDetails($key->id) ];
			}

			return \Response::json($formatted_tags);

		}
		


 

}
