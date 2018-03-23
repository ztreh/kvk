<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\LeaveType;
use App\Leave;
use App\Employee;
use Illuminate\Support\Facades\DB;
class LeaveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $leaves = DB::table('leaves')
            ->join('leave_types', 'leave_types.id', '=', 'leaves.leave_type_id')
            ->join('employees', 'employees.id', '=', 'leaves.employee_id')
            ->select('leaves.*', 'leave_types.name as leave_type_name','employees.name as employee_name' )
            ->get();
        $data['leaves']=$leaves;
        return  view('leave.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['leavetypes']=LeaveType::all();
        $data['title']="Register";
        $data['url']="/leave";
        return  view('leave.form',$data);
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
            'leave_type' => 'required',
            'employee_name' => 'required',
            'from_date' => 'required',
            'to_date' => 'required',
        ]);

        
        $leave=new Leave;
        $leave->leave_type_id=$request->input('leave_type');
        $leave->employee_id=getEmployeeID($request->input('employee_name'),"");
        $leave->from_date=$request->input('from_date');
        $leave->from_time=($request->input('from_time')!==null) ? $request->input('from_time') : '00:00' ;
        $leave->to_date=$request->input('to_date');
        $leave->to_time=($request->input('to_time')!==null) ? $request->input('to_time') : '00:00' ;
        $leave->save();
        return redirect('/leave')->with('info','Leave Registered Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
        $data['leavetypes']=LeaveType::all();
        $data['leave']=Leave::find($id);
        $data['employee_name']=DB::table('employees')
                    ->where('id', '=', $data['leave']->employee_id)
                    ->first();
        $data['url']="/leave/".$data['leave']->id;
        $data['title']="Modify";
        //print_r($data);
        return  view('leave.form',$data);
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
        $this->validate(request(),[
            'leave_type' => 'required',
            'employee_name' => 'required',
            'from_date' => 'required',
            'to_date' => 'required',
        ]);
        $employee_id=DB::table('employees')
                    ->where('name', '=', $request->input('employee_name'))
                    ->first();
        $data=array('leave_type_id'=>$request->input('leave_type'),
                'employee_id'=>$employee_id->id,
                'from_date'=>$request->input('from_date'),
                'to_date'=>$request->input('to_date'),
                );

        $data['from_time']=($request->input('from_time')!==null) ? $request->input('from_time') : '00:00';
        $data['to_time']=($request->input('to_time')!==null) ? $request->input('to_time') : '00:00' ;
        Leave::where('id',$id)->update($data);
        return redirect('/leave')->with('info','Leave Modified Successfully');    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Leave::where('id',$id)->delete();
        return redirect('/leave')->with('info','Leave Deleted Successfully');
    }

    
}