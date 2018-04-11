<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\LeaveEmployee;
use App\Leave;

class LeaveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['leaves']=LeaveEmployee::all();
        return  view('leave.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       
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
        $this->validateData($request);
        $this->saveData($request);
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
        
        $data['leave']=LeaveEmployee::find($id);
        $data['url']="/leave/".$data['leave']->id;
        $data['title']="Modify";
        
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
        $this->validateData($request);
        $this->saveData($request,$id);
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

    public function validateData(Request $request)
    {
      $this->validate(request(),[
        'name' => 'required',
        'employees_id' => 'required',
        'start_date' => 'required',
        'start_time' => 'required',
        'end_date' => 'required',
        'end_time' => 'required',
        
        ]);  
    }


    public function saveData(Request $request,$id=0)
    {   
        $leave=new Leave($request->all());
        $leaves_id=$leave->insertData($request);

        $user->roles()->attach($roleId, ['expires' => $expires]);
        /*if($id>0){
            $leave_employee=LeaveEmployee::find($id);
        }else{
            $leave_employee=new LeaveEmployee($request->all());
        }
        $leave_employee->insertData($request,$leaves_id,$id);*/
        
    }

    
}