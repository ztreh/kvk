<?php

namespace App\Http\Controllers;
ini_set('max_execution_time', 180);
use Illuminate\Http\Request;
use App\Rules\SalaryMonthExists;
use App\Attendance;
use App\Employee;
use App\SalarySessionWorkPlace;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['title']="Register";
        $data['url']="/attendance";
        return  view('attendance.form',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate(request(),[
            'attendance_file' => 'required',
            'salary_month' => ['required', new SalaryMonthExists]
        ]);

        $attendance_file = $request->file('attendance_file');

        $input['attendanceFile'] = time().'.'.$attendance_file->getClientOriginalExtension();

        $destinationPath = public_path('/attendance_file');
        $attendance_file->move($destinationPath, $input['attendanceFile']);

        if(public_path('/attendance_file/'.$input['attendanceFile'])){
            $dates=getStartAndEndDateOfSalaryMonth($request->input('salary_month'));
            //print_r($dates);
            $salary_month_id=$dates['id'];
            $start_date=$dates['start_date'];
            $end_date=$dates['end_date'];
            
            $finger_print_file = fopen(public_path('/attendance_file/'.$input['attendanceFile']), "r") or exit("Unable to open file!");
            $finger_print_data=array();
            $fingerprint_heading_array=array();
            $count=0;
            while(!feof($finger_print_file))
            {
                $var=fgetcsv($finger_print_file);
                if($count==0){
                    $fingerprint_heading_array=$var;
                }else{
                    array_push($finger_print_data,$var);
                }
                $count++;
                
            }
               
            $key_of_enrol_id=array_search("Enroll ID", $fingerprint_heading_array);
            $key_of_date=array_search("Date", $fingerprint_heading_array);
            $key_of_time=array_search("Time", $fingerprint_heading_array);

            for ($i=0; $i < count($finger_print_data) ; $i++) { 

                if($start_date <=$finger_print_data[$i][$key_of_date] && $end_date >=$finger_print_data[$i][$key_of_date] &&  $finger_print_data[$i][$key_of_date]!='0000-00-00'){
                    $employee_id=getEmployeeID("",$finger_print_data[$i][$key_of_enrol_id]);
                    $work_day_id=getWorkDayID($salary_month_id,$finger_print_data[$i][$key_of_date]);

                    // check attendance exist
                    if(checkAttendanceExists($work_day_id,$employee_id,$finger_print_data[$i][$key_of_date],$finger_print_data[$i][$key_of_time]) && $employee_id>0){
                        // insert attendance
                        $attendance=new Attendance;
                        $attendance->working_day_id=$work_day_id;
                        $attendance->employee_id=$employee_id;
                        $attendance->date=$finger_print_data[$i][$key_of_date];
                        $attendance->time=$finger_print_data[$i][$key_of_time];
                        $attendance->save();
                    }
                }
            }
            fclose($finger_print_file);
    }
        return redirect('/attendance/create')->with('info','Attendance Marked Successfully');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function addManualEntry(Request $request)
    {
        $attendance=new Attendance;
        $attendance->working_day_id=getWorkDayID($request->input('salary_month_id'),$request->input('entry_date'));
        $attendance->employee_id=$request->input('employee_name');
        $attendance->date=$request->input('entry_date');
        $attendance->time=$request->input('entry_time');
        $attendance->save();

        $dates=getStartAndEndDateOfSalaryMonth($request->input('salary_month'));
        $data['title']="View";
        $data['url']="/viewattendance";
        $data['url_add_manual_attendance']="/addattendance";   
        $data['salary_month_id']=$dates['id'];
        $data['salary_month']=$request->input('salary_month');
        $data['start_date']=$dates['start_date'];
        $data['end_date']=$dates['end_date'];

        $data['workdays']=getWorkDaysOfSalaryMonth($dates['id']);
        $data['employees']=Employee::all();

        return  view('attendance.index',$data);

    }

    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function viewAttendance(Request $request)
    {
        $data['title']="View";
        $data['url']="/viewattendance";
        $data['url_add_manual_attendance']="/addattendance";
        if ($request->isMethod('post'))
        {
           $this->validate(request(),[
            'salary_session_work_places_id' => 'required'
            ]);
            $work_places_salary_session_id=$request->input('salary_session_work_places_id');
           /* echo $work_places_salary_session_id;
            $wpss= SalarySessionWorkPlace::find($work_places_salary_session_id);
            echo count($wpss->work__places->employees())."  **</br>";
            echo count($wpss->work__places->device)."  **</br>";
            echo "</br>".($wpss->work__places->employees)."  **</br>";
            echo "</br>".($wpss->work__places->name)."  **</br>";
            echo "</br></br></br>".($wpss->work__places->device)."  **</br>";
 // dd($wpss->work__places->employees->get('id')) ;

foreach ($wpss->work__places->employees as  $employee) {
    echo "  </br>";
    // echo $employee->id." ";
    echo $employee->id." ".$employee->name;
    echo "  </br>";
}*/
            // $dates=getStartAndEndDateOfSalaryMonth($request->input('salary_month'));
            
            // $data['salary_month_id']=$dates['id'];
            // $data['salary_month']=$request->input('salary_month');
            // $data['start_date']=$dates['start_date'];
            // $data['end_date']=$dates['end_date'];

            // $data['workdays']=getWorkDaysOfSalaryMonth($dates['id']);

            /*get employees of the selected workplace
            get start and end date,salary session name of the salary session*/

            // $data['employees']=Employee::all();;
        }else{

            return  view('attendance.index',$data);
        }
        
    }
}
    