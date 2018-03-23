<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Designation;
use App\Employee;

class DesignationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['designations']=Designation::all();
        
        return  view('designation.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['title']="Register";
        $data['url']="/designation";
        return  view('designation.form',$data);
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
            'designation_name' => 'required',
        ]);

        $designation=new Designation;
        $designation->name=$request->input('designation_name');
        $designation->save();
        return redirect('/designation')->with('info','Designation Registered Successfully');
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
        $data['designation']=Designation::find($id);
        $data['url']="/designation/".$data['designation']->id;
        $data['title']="Modify";
        return  view('designation.form',$data);
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
            'designation_name' => 'required',
        ]);

        $data=array('name' => $request->input('designation_name'));
        Designation::where('id',$id)->update($data);
        return redirect('/designation')->with('info','Designation Modified Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $employees=Employee::where('designation_id','=',$id)->get();
        if(count($employees)>0){
            return redirect('/designation')->with('error_delete',' This Designation cannot delete ');

        }else{
            Designation::where('id',$id)->delete();
            return redirect('/designation')->with('info','Designation Deleted Successfully'); 
        }
    }
}
