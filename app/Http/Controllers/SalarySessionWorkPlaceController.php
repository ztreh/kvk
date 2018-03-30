<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SalarySessionWorkPlace;
class SalarySessionWorkPlaceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['workplace_salary_sessions']=SalarySessionWorkPlace::all();
        return  view('salary_session_work_palce.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['title']="Register";
        $data['url']="/workplace_salary_session";
        // $data['salary_session_types']=Salary_Session_Type::all();
        return  view('salary_session_work_palce.form',$data);  
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
        $salary_session_work_palce = new SalarySessionWorkPlace($request->all());
        $salary_session_work_palce->save();
        return redirect('/workplace_salary_session')->with('info','Workplace  Salary Session Added Successfully');   

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
        $data['workplace_salary_session']=SalarySessionWorkPlace::find($id);
        $data['title']="Modify";
        // $data['workplace_salary_sessions']=SalarySessionWorkPlace::all();
        $data['url']="/workplace_salary_session/".$id;
        return  view('salary_session_work_palce.form',$data); 
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

        $salary_session_type = SalarySessionWorkPlace::find($id);
        $salary_session_type->update($request->all()); 
        return redirect('/workplace_salary_session/create')->with('info','Workplace Salary Session Modified Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        SalarySessionWorkPlace::where('id',$id)->delete();
        return redirect('/workplace_salary_session')->with('info','Workplace Salary Session Deleted Successfully'); 
    }

    public function validateData(Request $request)
    {
      $this->validate(request(),[
        'work_places_id' => 'required',
        'salary_sessions_id' => 'required',
        'salary_session_types_id' => 'required',
        'start_date' => 'required',
        'end_date' => 'required',
        ]);  
    }
}




