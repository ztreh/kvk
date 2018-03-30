<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Salary_Session_Type;
class SalarySessionTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['title']="Register";
        $data['url']="/salary_session_type";
        $data['salary_session_types']=Salary_Session_Type::all();
        return  view('salary_session_type.form',$data);  
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
        $salary_session_type = new Salary_Session_Type($request->all());
        $salary_session_type->save();
        return redirect('/salary_session_type/create')->with('info','Salary Session Type Added Successfully');
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
        $data['salary_session_type']=Salary_Session_Type::find($id);
        $data['title']="Modify";
        $data['salary_session_types']=Salary_Session_Type::all();
        $data['url']="/salary_session_type/".$id;
        return  view('salary_session_type.form',$data); 
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

        $salary_session_type = Salary_Session_Type::find($id);
        $salary_session_type->update($request->all()); 
        return redirect('/salary_session_type/create')->with('info','Salary Session Type Modified Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Salary_Session_Type::where('id',$id)->delete();
        return redirect('/salary_session_type/create')->with('info','Salary Session Type Deleted Successfully'); 

    }

    public function validateData(Request $request)
    {
      $this->validate(request(),[
        'name' => 'required',
        ]);  
    }
}
