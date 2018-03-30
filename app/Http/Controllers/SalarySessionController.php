<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Salary_Session;

use Illuminate\Support\Facades\DB;

class SalarySessionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['salary_sessions']=Salary_Session::all();
        return  view('salary_session.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['title']="Register";
        $data['url']="/salary_session";
        return  view('salary_session.form',$data);
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
        $salary_session = new Salary_Session($request->all());
        $salary_session->save();
        return redirect('/salary_session')->with('info','Salary Session Added Successfully');   
        // $id = $salary_session->id;
        
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
        $data['salary_session']=Salary_Session::find($id);
        $data['url']="/salary_session/".$data['salary_session']->id;
        $data['title']="Modify";
        return  view('salary_session.form',$data);
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
        $salary_session = Salary_Session::find($id);
        $salary_session->update($request->all()); 
        return redirect('/salary_session')->with('info','Salary Session Modified Successfully');   
       
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Salary_Session::where('id',$id)->delete();
        return redirect('/salary_session')->with('info','Salary Session Deleted Successfully'); 
        
    }

     public function validateData(Request $request)
    {
      $this->validate(request(),[
        'name' => 'required',
        'salary_year_and_month' => 'required',
        'start_date' => 'required',
        'end_date' => 'required',
        'status' => 'required',
        ]);  
    }

}
