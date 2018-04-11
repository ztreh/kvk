<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Advance;
use App\Slip;

use Illuminate\Support\Facades\DB;

class AdvanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      
        $advance=new Advance;
        $data['advances']=$advance->getAllAdvancePayments();

        return  view('advance.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['title']="Register";
        $data['url']="/advance";
        return  view('advance.form',$data);
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
        return redirect('/advance')->with('info','Advance Registered Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {   
        $advance=new Advance;
        $advance->printAdvance($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $advance=new Advance;
        $data['advance']=(object)$advance->getAllAdvancePayments($id)[0];
        $data['url']="/advance/".$data['advance']->id;
        $data['title']="Modify";
        return  view('advance.form',$data);
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
        return redirect('/advance')->with('info','Advance Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $salary_month_id=Advance::find($id)->salary_month_id;
        $check_slips=Slip::where('is_paid','=',1)->where('salary_month_id','=',$salary_month_id)->get();
        if(count($check_slips)==0){
            Advance::where('id',$id)->delete();
            return redirect('/advance')->with('info','Advance Deleted Successfully'); 

        }else{
            return redirect('/advance')->with('error_delete','This Advance cannot  Delete '); 
            
        }
    }

    public function validateData(Request $request)
    {
      $this->validate(request(),[
        'salary_session_work_places_id' => 'required',
        'employees_id' => 'required',
        'advance_amount' => 'required|numeric|min:1',
        
        ]);  
    }

    public function saveData(Request $request,$id=0)
    {
       
        if($id>0){
            $advance=Advance::find($id);
        }else{
            $advance=new Advance($request->all());
        }
        $advance->insertData($request,$id);
        
    }
}
