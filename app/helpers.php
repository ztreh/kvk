<?php
use Illuminate\Support\Facades\DB;
use App\Employee;
use App\Leave;
use App\Commision;
use App\SalaryMonth;
use App\Work_Place;
use App\Salary_Session;
use App\Salary_Session_Type;
use App\SalarySessionWorkPlace;



function getDatesFromRange($from_date,$to_date) {
	$dates = array($from_date);
    while(end($dates) < $to_date){
        $dates[] = date('Y-m-d', strtotime(end($dates).' +1 day'));
    }
    return $dates;
}

//******no need
function getStartAndEndDateOfSalaryMonth($salary_month)
{
	$dates=array();
	$month=date('n',strtotime($salary_month));
	$year=date('Y',strtotime($salary_month));

	$salary_month=DB::table('salary_months')
                    ->where('year', '=', $year)
                    ->where('month', '=', $month)
                    ->first();
        
    if(count($salary_month)>0){
    	// echo "hhhh".$salary_month->id.'  '.$salary_month->start_date.' '.$salary_month->end_date;
        $dates['id']=$salary_month->id;
        $dates['start_date']=$salary_month->start_date;
        $dates['end_date']=$salary_month->end_date;
        return $dates;
    }else{
        return false;
    }
	
}

function getEmployeeName($employee_id=0){
    if($employee_id>0){
        $results = DB::table('employees');
        $results->where('id','=', $employee_id);
        $results = $results->first();
        if(count($results)>0){
           return $results->name;
        }
    }else{
        return false;
    }
}
function getEmployeeID($employee_name="",$finget_print_no=""){

	$results = DB::table('employees');
	if($employee_name!=""){
	    $results->where('name','=', $employee_name);
	}

	if($finget_print_no!=""){
	    $results->where('finger_print_no','=', $finget_print_no);
	}

	$results = $results->first();
    if(count($results)>0){
       return $results->id;
    }else{
        return false;
    }
}

//******no need
function getWorkDayID($salary_month_id,$date)
{
	$working_day=DB::table('working_days')
                    ->where('salary_id', '=', $salary_month_id)
                    ->where('date', '=', $date)
                    ->first();
        
    if(count($working_day)>0){
        return $working_day->id;
    }else{
        return false;
    }
	
}


//*****change
function checkAttendanceExists($working_day_id,$employee_id,$date,$time)
{
	$attendance=DB::table('attendances')
        ->where('working_day_id', '=', $working_day_id)
        ->where('employee_id', '=', $employee_id)
        ->where('date', '=', $date)
        ->where('time', '=', $time)
        ->first();
    if(count($attendance)>0){
        return false;
    }else{
        return true;
    }
}
//******no need
function getWorkDaysOfSalaryMonth($salary_month_id)
{
    $days=array();
    $working_day=DB::table('working_days')
                    ->where('salary_id', '=', $salary_month_id)
                    ->get();
    foreach ($working_day as $day) {
        array_push($days,$day->date) ;
    }
    return $days;
}

function getAttendanceEntries($employee,$day,$sal_end_date,$status)
{
    //status ==1 =>attendance view
    //status ==2 =>salary view
    $badge="";
    $detailed_array=array();

    $start_time=strtotime($day.' '.$employee->work_start_time);
    $end_time=strtotime($day.' '.$employee->work_off_time);

    $work_on_time=$day." ".$employee->work_start_time;
    $work_off_time=$day." ".$employee->work_off_time;
    $ot_availability=$employee->ot_availability;
    if($start_time<$end_time){
       
        $attendence_entries=  assignEntryNames(3,array_values(getAttendanceEntriesOfTheDay($employee->id,$day)));
        if($status==1){
            if(array_key_exists('on_time',$attendence_entries)){
                $badge.=onHTML($attendence_entries['on_time'],$work_on_time,$ot_availability,$status,$detailed_array);
            }

            if(array_key_exists('off_time',$attendence_entries)){
                 $badge.=offHTML($attendence_entries['off_time'],$work_off_time,$ot_availability,$status,$detailed_array);
            }

        }else{

            if(array_key_exists('on_time',$attendence_entries)){
               
              $detailed_array=onHTML($attendence_entries['on_time'],$work_on_time,$ot_availability,$status,$detailed_array) ;
                
            }

            if(array_key_exists('off_time',$attendence_entries)){
                $detailed_array=offHTML($attendence_entries['off_time'],$work_off_time,$ot_availability,$status,$detailed_array) ;
                
            }

        }

    }else{
        $attendence_entries= getOnOffTwoDaysAttendanceEntriesOfTheDay($employee->id,$employee->work_start_time,$employee->work_off_time,$day);
        
        $on_entries=assignEntryNames(1,array_values($attendence_entries['ontimes']));
        $off_entries=assignEntryNames(2,array_values($attendence_entries['offtimes']));

        if($status==1){
            if(array_key_exists('on_time',$on_entries)){
                $badge.=onHTML($on_entries['on_time'],$work_on_time,$ot_availability,$status,$detailed_array);
            }

            if(array_key_exists('off_time',$off_entries)){
                $badge.=offHTML($off_entries['off_time'],$work_off_time,$ot_availability,$status,$detailed_array);
            }

        }else{

            if(array_key_exists('on_time',$on_entries)){
                $detailed_array=onHTML($on_entries['on_time'],$work_on_time,$ot_availability,$status,$detailed_array) ;
            }
            // print_r($detailed_array);

            if(array_key_exists('off_time',$off_entries)){
               $detailed_array=offHTML($off_entries['off_time'],$work_off_time,$ot_availability,$status,$detailed_array) ;

            }
            // print_r($detailed_array);

        }
        
        
        
    }

    if($badge=="" && $status==1){
        if(IsHolidayEmployee($day,$employee->id) || IsHolidayForAll($day)){
            $badge.="<span class='label label-primary'>Holiday</span>";
        }elseif(IsOnLeave($employee->id,$day)){
            $leaves=getTotalLeaves($sal_end_date,$employee->id);
            if($leaves<=21){
                $badge.="<span class='label label-primary'>Leave</span>";
            }else{
                $badge.="<span class='label label-primary'>Leave (Not Approved)</span>";
            }

        }
        
    }

    if($status==2 && count($detailed_array)==0){
        if(IsHolidayEmployee($day,$employee->id) || IsHolidayForAll($day)){
            
           $detailed_array['holiday']=1; 

        }elseif(IsOnLeave($employee->id,$day)){
            $leaves=getTotalLeaves($sal_end_date,$employee->id);
            if($leaves<=21){
                $detailed_array['leave']=1;

            }else{
                $detailed_array['not_app_leave']=1 ;
           
            }

        }
        
    }
    if($status==1){
        echo $badge;
    }else{
        // print_r($detailed_array);
        return $detailed_array;
    }
    
} 

function onHTML($on_time,$work_on_time,$ot_availability,$status,$detailed_array)
{
    // print_r($detailed_array);
    if($status==1){
        $badge="<span class='label label-success'><i class='fa fa-sign-in' aria-hidden='true'></i>".date("H:i:s", $on_time)."  </span>&nbsp;";//late cut
        if($on_time>strtotime($work_on_time)){
            $badge.="<span class='label label-danger'><i class='fa fa-sign-in' aria-hidden='true'></i>".timeDifferenceInMinutes(strtotime($work_on_time),$on_time)." min late </span>&nbsp;";
           
            //late cut
        }elseif($on_time<strtotime($work_on_time) && $ot_availability){
            $badge.="<span class='label label-success'><i class='fa fa-sign-in' aria-hidden='true'></i>".timeDifferenceInMinutes($on_time,strtotime($work_on_time))." min ot</span>&nbsp;";//ot
        }

        return $badge;
    }else{
        $detailed_array['on_time']=$on_time;
        
        if($on_time>strtotime($work_on_time)){
           
            $detailed_array['late_cut']=timeDifferenceInMinutes(strtotime($work_on_time),$on_time);

            //late cut
        }elseif($on_time<strtotime($work_on_time) && $ot_availability){
            //ot
            $detailed_array['ot']=timeDifferenceInMinutes($on_time,strtotime($work_on_time));

        }
        // print_r($detailed_array);
        return $detailed_array;

    }
    
}

function offHTML($off_time,$work_off_time,$ot_availability,$status,$detailed_array)
{
    // print_r($detailed_array);
    if($status==1){
        $badge="<span class='label label-success'><i class='fa fa-sign-out' aria-hidden='true'></i>".date("H:i:s", $off_time)."  </span>&nbsp;";//late cut
                    
                if($off_time>strtotime($work_off_time) && $ot_availability){
                    $badge.="<span class='label label-success'><i class='fa fa-sign-out' aria-hidden='true'></i>".timeDifferenceInMinutes(strtotime($work_off_time),$off_time)." min ot </span>&nbsp;";//ot
                }elseif($off_time<strtotime($work_off_time)){
                    $badge.="<span class='label label-danger'><i class='fa fa-sign-out' aria-hidden='true'></i>".timeDifferenceInMinutes($off_time,strtotime($work_off_time))." min early</span>&nbsp;";//cut early
                }

        return $badge;

    }else{
        $detailed_array['off_time']=$off_time;//late cut
                    
                if($off_time>strtotime($work_off_time) && $ot_availability){
                    $detailed_array['ot']=timeDifferenceInMinutes(strtotime($work_off_time),$off_time);//ot
                }elseif($off_time<strtotime($work_off_time)){
                    $detailed_array['late_cut']=timeDifferenceInMinutes($off_time,strtotime($work_off_time));//cut early
                }
        // print_r($detailed_array);

        return $detailed_array;

    }

}
function timeDifferenceInMinutes($from_time='',$to_time='')
{
    if($from_time!="" && $to_time!=""){
        return round(abs($to_time - $from_time) / 60,2);
    }
}
function assignEntryNames($status=0,$arranged_entries=array()){
    // print_r($arranged_entries);
    // status 1 on only
    // 2 off only
    // 3 both on && off
   
    $number_of_entries= count($arranged_entries);
    $value_assigned_array=array();

    if($number_of_entries>0){
        if($status==1){
            $value_assigned_array['on_time']=reset($arranged_entries);

        }elseif($status==2){
            $value_assigned_array['off_time']=end($arranged_entries);

        }elseif($status==3){
            $value_assigned_array['on_time']=reset($arranged_entries);
            if($number_of_entries>1){
                $value_assigned_array['off_time']=end($arranged_entries);
            }

        }
    }
   
    return $value_assigned_array;
}
//*****change
function getOnOffTwoDaysAttendanceEntriesOfTheDay($employee_id,$start_time,$end_time,$working_date)
{
    $ontimes=array();
    $offtimes=array();
    $times_array=array();
    $on_select = DB::table('attendances')
            ->join('employees', 'employees.id', '=', 'attendances.employee_id')
            ->join('working_days', 'working_days.id', '=', 'attendances.working_day_id')
            ->where('employees.id', '=', $employee_id)
            ->where('working_days.date', '=', date('Y-m-d',strtotime($working_date)))
            ->where('attendances.time', '<=', '23:59')
            ->where('attendances.time', '>=', $start_time)
            ->select('attendances.date','attendances.time','attendances.id')
            ->get();
    
    $off_select = DB::table('attendances')
                ->join('employees', 'employees.id', '=', 'attendances.employee_id')
                ->join('working_days', 'working_days.id', '=', 'attendances.working_day_id')
                ->where('employees.id', '=', $employee_id)
                ->where('working_days.date', '=', date('Y-m-d',strtotime($working_date)))
                ->where('attendances.time', '>=', '00:00')
                ->where('attendances.time', '<=', $end_time)
                ->select('attendances.date','attendances.time','attendances.id')
                ->get();

    foreach ($on_select as $on) {
        $date_time=$on->date." ".$on->time;
        $ontimes[$on->id] = strtotime($date_time);
    }

    foreach ($off_select as $off) {
        $date_time=$off->date." ".$off->time;
        $offtimes[$off->id] = strtotime($date_time);
    }
    
    if(is_array($ontimes)){
        asort($ontimes);
    }
    if(is_array($offtimes)){
        asort($offtimes);
    }
   
    $times_array=array('ontimes'=>$ontimes,'offtimes'=>$offtimes);
    
    return $times_array;

}

function getAttendanceEntriesOfTheDay($fingerprint_no,$date)
  {
    $entries=array();
    $entries_of_the_day=DB::table('raw_attendances')
                    ->where('fingerprint_no', '=', $fingerprint_no)
                    ->where('date', '=', $date)
                    ->get();
    foreach ($entries_of_the_day as $entry) {
        array_push($entries,strtotime($entry->date.' '.$entry->time));
    }

    if(is_array($entries)){
        asort($entries);
    }
    return $entries;
  }  
//*****change
function IsHolidayEmployee($date,$employee_id)
{
    $holidays=DB::table('holidays')
            ->where('employee_id', '=', $employee_id)
            ->where('to_date', '=', $date)
            ->orWhere('from_date','=', $date)
            ->get();
    if(count($holidays)>0){
        return true;
    }else{
        return false;
    }
}
//*****change
function IsHolidayForAll($date)
{
    $holidays=DB::table('holidays')
            ->where('to_date', '=', $date)
            ->orWhere('from_date','=', $date)
            ->get();
    if(count($holidays)>0){
        return true;
    }else{
        return false;
    }
}
//*****change
function IsOnLeave($employee_id,$date)
{
    $leaves=DB::table('leaves')
            ->where('employee_id', '=', $employee_id)
            ->where('from_date', '<=', $date)
            ->where('to_date', '>=', $date)
            ->get();
    if(count($leaves)>0){
        return true;
    }else{
        return false;
    }
}

function getTotalLeaves($sal_end_date="",$employee_id=0,$type=0)
{
    $year = date('Y',strtotime($sal_end_date));
    $date = $year.'-01-01';
    $total_leaves=DB::table('leave_employees')
            ->where('employees_id', '=', $employee_id)
            ->where('start_date', '>=',$date );
           
    if($type==0){
        $total_leaves= $total_leaves->where('start_date', '<=',$sal_end_date );
        $total_leaves= $total_leaves->where('end_date', '<=', $sal_end_date);
        
    }
    if($type>0){
       $total_leaves= $total_leaves->where('leaves_id','=', $type)->where('end_date', '<=', $year.'-12-31');
    }

    $total_leaves= $total_leaves->get();

    
    $emp_work_start_time= getColumn('employees','work_start_time','id',$employee_id);
    $emp_work_end_time= getColumn('employees','work_off_time','id',$employee_id);

    $time_period=timeDifferenceInMinutes(strtotime($emp_work_start_time),strtotime($emp_work_end_time))/60;

    $total_time_in_hours=0;
    foreach ($total_leaves as $leaves) {
        // print_r($leaves);
        $diffinhours=0;
      if($leaves->start_date==$leaves->end_date){
        $from_time=$leaves->start_date.' '.$leaves->start_time;
        $to_time=$leaves->end_date.' '.$leaves->end_time;
        $diffinhours=timeDifferenceInMinutes(strtotime($from_time),strtotime($to_time))/60;
        $total_time_in_hours+=$diffinhours;
      }else{
        $from_date=$leaves->start_date;
        $to_date=$leaves->end_date;

        $starting=$leaves->start_date.' '.$leaves->start_time;
        $ending=$leaves->end_date.' '.$leaves->end_time;

        $end_date=$from_date;
        for($i=0;($end_date<=$to_date);$i++){
            // echo 'end '.$end_date.'   ';
            if($end_date==$from_date){
                $from_time=$starting;
            }else{
                $from_time=$end_date." ".$emp_work_start_time;
            }
            
            if($end_date==$to_date){
                $to_time=$ending;
            }else{
                $to_time=$end_date." ".$emp_work_end_time;
            }
            
            $diffinhours=(strtotime($to_time)-strtotime($from_time))/3600;
            // echo ' from time '.$from_time.' to time '.$to_time.'  '.($diffinhours).' </br> ';
            $time = strtotime($end_date);
            $end_date = date("Y-m-d", strtotime("+1 day", $time)); 
            
            $total_time_in_hours+=$diffinhours;
        }
      }
        
    }
    $days=0;
    if($type==0 && $time_period>0){
        $days=(int)($total_time_in_hours/$time_period);
    }elseif($type>0 && $time_period>0){
        $days=round(($total_time_in_hours/$time_period),1);
    }
    return $days;
}

function getColumn($table_name='',$column_name='',$condition_column='',$condition_value='')
{
    $result=DB::table($table_name)
            ->where($condition_column, '=', $condition_value)
            ->select($column_name)
            ->first();
    return $result->$column_name;
}

function getWorkedDetails($employee,$salary_month_id,$start_date,$end_date){

    /*
        insert slip if not exist
        insert welfare account details
        insert loan account details
        display loan details in pay slips        

    */
        $data=array('employee_id' => $employee->id,
                            'salary_month_id' => $salary_month_id,
                            'employee_salary_type' => $employee->employee_salary_type,
                            'ot_availability' => $employee->ot_availability,
                            'epf_availability' => $employee->epf_availability,
                            'basic_salary' =>$employee->basic_salary,
                            'work_start_time' => $employee->work_start_time,
                            'work_off_time' => $employee->work_off_time,
                            'date_paid' =>now() ,
                            'monthly_salary' => $employee->monthly_salary,
                            'per_day_salary' => $employee->per_day_salary,
                            'ot_rate' => $employee->ot_rate,
                            'attendance_incentive' => $employee->attendance_incentive,
                            'allowance_per_day' => $employee->allowance_per_day,
                            'welfare' => $employee->welfare);
    $workdetails=totWorkedDaysDetails($employee,$salary_month_id,$end_date);
    if($workdetails['total_worked_days']>0){
        if(checkSlipExist($salary_month_id,$employee->id)){
            DB::table('slips')
                ->where('id', checkSlipExist($salary_month_id,$employee->id))
                ->where('is_paid',0)
                ->update($data);
        }else{
            //insert slip
            $slips =  DB::table('slips')->insert($data);
            //update loan payments
            updateLoanDetails($start_date,$end_date,$salary_month_id,$employee->id);
        }

    }

    if($workdetails['total_worked_days']>0){
        $slip=DB::table('slips')
            ->where('id', checkSlipExist($salary_month_id,$employee->id))
            ->first();
        
    }else{
        $slip=$employee;
    }
    $total_commision=0;

    //get commisions
    $service_commisions=getServiceTotalCommisionForSalaryMonth($employee->id,$salary_month_id);
    $monthly_total_commision=getTotalCommision($employee->id,$salary_month_id);
    // echo " service_commisions ".$service_commisions." total_commision ".$total_commision;
    $total_commision=$service_commisions+$monthly_total_commision;
    $workdetails['slip']=$slip;
    //*****change
    $workdetails['budget_allowance']=SalaryMonth::find($salary_month_id)->budget_allowance;
    $workdetails['total_commision']= round($total_commision,2);
    $workdetails['total_advance']= getTotalAdvance($salary_month_id,$employee->id);
    $workdetails['other_total_allowances']=getSlipFeature(1,$salary_month_id,$employee->id);
    $workdetails['other_total_deductions']=getSlipFeature(2,$salary_month_id,$employee->id);
    $workdetails['loan_details']=getLoanDetails($salary_month_id,$employee->id);
    $slip_status=DB::table('slips')->where('employee_id', '=', $employee->id)->where('salary_month_id', '=', $salary_month_id)->first();
    if(!empty($slip_status)){
        $workdetails['slip_status']=$slip_status->is_paid;
    }else{
        $workdetails['slip_status']="";
    }
    $workdetails['total_leaves']=getTotalLeaves($end_date,$employee->id);
    // print_r($workdetails['loan_details']);
    return $workdetails;

}

function getServiceTotalCommisionForSalaryMonth($employee_id=0,$salary_month_id=0)
{       

    $service = DB::table('service_center_commisions')
            ->join('service_center_commision_items', 'service_center_commision_items.service_center_commision_id', '=', 'service_center_commisions.id')
            ->where('service_center_commisions.salary_month_id','=',$salary_month_id)
            ->where('service_center_commision_items.employee_id','=',$employee_id)
            ->select(DB::raw('SUM(service_center_commision_items.commision_value) as total_service_commsion'))
            ->first();
    
    return $service->total_service_commsion;
}

function getTotalCommision($employee_id=0,$salary_month_id=0)
{    
    // DB::enableQueryLog(); 

    $total_commision = DB::table('commisions')
            ->join('commision_categories', 'commision_categories.commision_id', '=', 'commisions.id')
            ->join('commision_category_items', 'commision_categories.id', '=', 'commision_category_items.commision_category_id')
            ->where('commisions.salary_month_id','=',$salary_month_id)
            ->where('commision_category_items.employee_id','=',$employee_id)
            ->select(DB::raw('SUM(commision_category_items.commision_value) as total_commsion'))
            ->first();
    // $query = DB::getQueryLog();
    // dd($query);
    return $total_commision->total_commsion;

}

function getTotalAdvance($salary_month_id,$employee_id){
  $orders = DB::table('advances')
            ->where('salary_month_id','=',$salary_month_id)
            ->where('employee_id','=',$employee_id)
            ->select(DB::raw('SUM(advance_amount) as total_advance'))
            ->first();
    return $orders->total_advance;
}


function getCommision($employee,$salary_month_id,$end_date)
{
    $emp_commision_id=getCommisionForSalaryMonth($employee->id,$salary_month_id,2);
    $employee_id=array();
    $designation_id=array();
    //check employees recieve this commision

    if(count($emp_commision_id)>0 && is_array($emp_commision_id)){
         foreach($emp_commision_id as $commision_id => $value) {
            $employee_list=getCommisionForSalaryMonth($employee->id,$salary_month_id,2,$commision_id);
            $employee_id[$commision_id]=array();
            foreach($employee_list as $key2 => $value2) {
                foreach ($value2 as $k) {
                    array_push($employee_id[$commision_id], $k['idcatemp']);
                }
            }
         }
    }
    //check commision for category
    $category_commision=getCommisionForSalaryMonth($employee->designation_id,$salary_month_id,1,0);
    if(count($category_commision)>0 && is_array($category_commision)){
        foreach ($category_commision as $commision_id => $value) {
            $designation_id[$commision_id]=array();
            $employee_list=getCommisionForSalaryMonth($employee->id,$salary_month_id,2,$commision_id);
            foreach($employee_list as $key2 => $value2) {
                foreach ($value2 as $k) {
                    array_push($designation_id[$commision_id],$k['idcatemp']);
                }
            }
        }
    }
    if(count($designation_id)>0 && is_array($designation_id)){
        foreach ($designation_id as $commision_id => $value ) {
            $employee_id[$commision_id]=array();
            if(count($value)>0 && is_array($value)){
                foreach ($value as $designation_id) {
                    $id= getEmployeeIDByDesignation($designation_id);
                    if(count($id)>0 && is_array($id)){
                        foreach ($id as $empid) {
                           array_push($employee_id[$commision_id],$empid );
                        }
                    
                    }
                }
            }
        }
    }
    
    $total_worked_days_for_commision=array();
    foreach ($employee_id as $commision_id=> $employeeidarr) {
        $total_worked_days_for_commision[$commision_id]=0;

        foreach ($employeeidarr as $id) {
            $employee_details=Employee::find($id);
            // DB::table('employees')->where('id','=',$id)->first();
            $total_worked_days=(totWorkedDaysDetails($employee_details,$salary_month_id,$end_date))['total_worked_days'];
            $total_worked_days_for_commision[$commision_id]+=$total_worked_days;
        }
    }
    return ($total_worked_days_for_commision);

}

function getEmployeeIDByDesignation($designation_id){
    $results=array();
    $get_ids = DB::table('employees')
        ->where('employees.designation_id', '=', $designation_id)
        ->get();
    
    if(count($get_ids)>0){
        foreach ($get_ids as $ids) {
            array_push($results, $ids->id);
        }
        return $results;
    }else{
        return false;
        
    }
}

function totWorkedDaysDetails($employee,$salary_month_id,$end_date)
{
    // print_r($employee);
    // echo " ".$salary_month_id.' '.$end_date.' '.$employee->id;
    $result=array();
    $detailed_array=array();     
    $workdays=getWorkDaysOfSalaryMonth($salary_month_id);
    $no_pay_days=0;
    $total_ot_minutes=0;
    $total_leaves=0;
    $total_worked_days=0;
    $total_holidays=0;
    foreach($workdays as $day){
        $start_time=strtotime($day.' '.$employee->work_start_time);
        $end_time=strtotime($day.' '.$employee->work_off_time);
        $wortime=timeDifferenceInMinutes($start_time,$end_time);
        $detailed_array[$day] =getAttendanceEntries($employee,$day,$end_date,2);

            if(isset($detailed_array[$day]['not_app_leave'])){
                $no_pay_days++;
            }
            
            if(isset($detailed_array[$day]['ot']) && $employee->ot_availability){
                $total_ot_minutes+=$detailed_array[$day]['ot'];
            }

            if(isset($detailed_array[$day]['on_time']) && isset($detailed_array[$day]['off_time'])){
               if($wortime/5<timeDifferenceInMinutes($detailed_array[$day]['on_time'],$detailed_array[$day]['off_time'])){
                    $total_worked_days++;

               }else{
                    $total_worked_days=$total_worked_days+0.5;
                
               }
            }
           
            if(isset($detailed_array[$day]['leave'])){
                $total_leaves++;
            }

            if(isset($detailed_array[$day]['holiday'])){
                $total_holidays++;
            }
        
    }
    $result['total_worked_days']=$total_worked_days;
    $result['total_ot_hours']=$total_ot_minutes/60;
    $result['no_pay_days']=$no_pay_days;
    $result['total_leaves']=$total_leaves;
    $result['total_holidays']=$total_holidays;
    return $result;
}

function getCommisionForSalaryMonth($employee_or_category_id,$salary_month_id,$status,$commision_id=0)
{
    // DB::enableQueryLog(); 
    /*$status=1 ----> catgory
    $status=2 ----> employee*/
    $results=array();
    $get_commision = DB::table('commisions')->join('commision_items', 'commisions.id', '=', 'commision_items.commision_id');
    if($commision_id==0){
        $get_commision->where('commision_items.status', '=', $status);
        $get_commision->where('commision_items.category_or_employee_id', '=', $employee_or_category_id);
        
    }elseif($commision_id>0){
        $get_commision->where('commisions.id', '=', $commision_id);
    }
     $get_commision= $get_commision->where('commisions.salary_month_id', '=', $salary_month_id)
        ->select('commisions.id as commision_id','commisions.commision_percentage as commision_percentage','commisions.sale_amount as sale_amount','commision_items.category_or_employee_id as idcatemp','commision_items.status as status')
        ->get();
   
    if(count($get_commision)>0){
        $count=0;
        foreach ($get_commision as $com) {
            $results[$com->commision_id][$count]['commision_percentage']=$com->commision_percentage;
            $results[$com->commision_id][$count]['sale_amount']=$com->sale_amount;
            $results[$com->commision_id][$count]['idcatemp']=$com->idcatemp;
            $results[$com->commision_id][$count]['status']=$com->status;
            $count++;
        }
        return $results;
    }else{
        return false;
        
    }

}

function getSlipFeature($type,$salary_month_id,$employee_id,$all=false)
{
   $slip_features = DB::table('slip_features')
        ->where('salary_month_id', '=', $salary_month_id)
        ->where('employee_id', '=', $employee_id)
        ->where('feature_type', '=', $type);
        
    if($all){
        $slip_features = $slip_features->get();
        return $slip_features;
    }else{
       $slip_features = $slip_features->select(DB::raw('SUM(amount) as total'))->first();
        return $slip_features->total;
        
    }
        

}

function updateLoanStatus($loan_id=5)
{
    //get full paid #
    //get half paid #
    //get not paid #
    
        $full_paid_loan_details = DB::table('loans')
            ->join('loan_payments', 'loan_payments.loan_id', '=', 'loans.id')
            ->where('loans.id', '=', $loan_id)
            ->where('loan_payments.status', '=', 2)
            ->selectRaw("count(loan_payments.id) as number")
            ->first();
        // $loan_pay_status[$i]=$full_paid_loan_details->number;
        // $loan_pay_status=array();
        // for ($i=0; $i <=2; $i++) {} 
    

    $total_installments=DB::table('loans')->where('loans.id', '=', $loan_id)->first()->num_of_installments;
    $status=0;
    $loan_details_2=$full_paid_loan_details->number;
    if($total_installments==$loan_details_2){
        $status=2;
    }elseif($total_installments>$loan_details_2 && $loan_details_2!=0){
        $status=1;
    }

    $loan_payment=DB::table('loans')
                ->where('id', $loan_id)
                ->update(['status'=>$status]);
}
function updateLoanDetails($start_date_salary_month,$end_date_salary_month,$salary_month_id,$employee_id)
{
    $loan_details = DB::table('loans')
        ->where('loans.employee_id', '=', $employee_id)
        ->where('loans.payment_start_date', '<', $start_date_salary_month)
        ->where('loans.status', '<>', 2)
        ->select('loans.id','loans.value_of_a_installment','loans.payment_start_date','loans.num_of_installments')
        ->get();

    $loan_payment_details=array();
    foreach($loan_details as $loan){
        // echo ($loan->id);
        $loan_details=numberOfInstallmentstoPay($loan,$end_date_salary_month);
        $number_of_tobe_paid_installment=$loan_details['number_of_tobe_paid_installment'];
        $paid_total=$loan_details['paid_total'];
        // echo $number_of_tobe_paid_installment;
        $to_be_paid=$number_of_tobe_paid_installment*($loan->value_of_a_installment)-$paid_total;
        $check_paid=DB::table('loan_payments')->where('loan_id', '=', $loan->id)->where('salary_month_id', '=', $salary_month_id)->first();

        if($to_be_paid>0 && count($check_paid)==0){
            $loan_payment=DB::table('loan_payments')
                ->insert(['paid_amount'=>$to_be_paid,'status'=>0,'salary_month_id'=>$salary_month_id,'pay_date'=>now(),'loan_id'=>$loan->id,'description'=>'']);
        }
      
         // updateLoanStatus($loan->id);
    }
}

function numberOfInstallmentstoPay($loan,$end_date_salary_month)
{
    $details=array();
    $get_loan_paid_total=DB::table('loan_payments')
        ->where('loan_id', '=', $loan->id)
        ->where('status', '=', 1)
        ->select(DB::raw('SUM(paid_amount) as paid_total'))
        ->groupBy('loan_payments.loan_id')
        ->first();

        $number_of_paid_installment=0;
        $paid_total=0;
        if(!empty($get_loan_paid_total)){
            $paid_total=$get_loan_paid_total->paid_total;    
            echo $get_loan_paid_total->paid_total;
            $number_of_paid_installment=(int)($get_loan_paid_total->paid_total)/($loan->value_of_a_installment);
            
        }

        $pay_date =$loan->payment_start_date;

        $number_of_tobe_paid_installment=0;
        for ($i=1; $i <= $loan->num_of_installments; $i++) { 
                
            if($pay_date<$end_date_salary_month){
                $number_of_tobe_paid_installment=$i;
            }else{
                break;
            }
            $pay_date = date("Y-m-d", strtotime("+1 month", strtotime($pay_date)));

        } 
        $details['number_of_tobe_paid_installment']=$number_of_tobe_paid_installment;
        $details['paid_total']=$paid_total;
        return $details;
}


function getLoanDetails($salary_month_id,$employee_id)
{
    $paid_total=0;

    $loan_details = DB::table('loans')
        ->join('loan_payments', 'loan_payments.loan_id', '=', 'loans.id')
        ->where('loan_payments.salary_month_id', '=', $salary_month_id)
        ->where('loans.employee_id', '=', $employee_id)
        ->get();

    foreach ($loan_details as $loan) {
       $paid_total+=$loan->paid_amount;
    }
    return $paid_total;
}

function checkSlipExist($salary_month_id,$employee_id)
{
    $slip = DB::table('slips')
        ->where('salary_month_id', '=', $salary_month_id)
        ->where('employee_id', '=', $employee_id)
        ->first(); 
    
    if(count($slip)>0){
        return $slip->id;
    }else{
        return false;

    }
}


function getPlannedWorkDay($employee,$salary_month_id=0,$from_date,$to_date)
{
    if($salary_month_id>0){
        $num_of_dates=getDatesFromRange($from_date,$to_date);
    }
    $workdetails=totWorkedDaysDetails($employee,$salary_month_id,$to_date);

    return $workdetails;
}

function LoanPaymentSummary()
{
    $loan_payments=array();
    $loans = DB::table('loans')
        ->get(); 

    foreach ($loans as $loan) {
        $loan_pays = DB::table('loan_payments')
        ->where('loan_id','=',$loan->id)
        ->select(DB::raw('SUM(paid_amount) as total_pay'))
        ->first(); 
        $loan_payments[$loan->id]=$loan_pays->total_pay;
    }
    // print_r($loan_payments);
    return $loan_payments;
}
