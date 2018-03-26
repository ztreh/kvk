<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Labour;
use App\Skill;
use App\Labour_Skill;
use Illuminate\Support\Facades\DB;


class LabourController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['labours']=Labour::all();
        return  view('labour.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        $data['title']="Register";
        $data['skills']=Skill::all();
        $data['url']="/labour";
        return  view('labour.form',$data);
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
        $labour=array();
        $labour=$this->getData($request,$labour);
        $labour_id=DB::table('labours')->insertGetId($labour);
        // $labour->save();
        // $labour->id;
        if(is_array($request->input('skill_list')) && count($request->input('skill_list'))>0){
          foreach ($request->input('skill_list') as $value) {
              $labour_skill=new Labour_Skill;
              $labour_skill->skill_id =$value;
              $labour_skill->labours_id=$labour_id;
              $labour_skill->created_at =now();
              $labour_skill->save();
          }

        }
        return redirect('/labour')->with('info','Labour Added Successfully');   
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
       $data['labour']=Labour::find($id);
       $data['labour_skill']=Labour_Skill::where('labours_id',$id)->get();
       $data['title']="Modify";
       $data['skills']=Skill::all();
       $data['url']="/labour/".$id;
       return  view('labour.form',$data);
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
        // echo $id;

        $this->validateData($request);
        $labour=array();
        $labour=$this->getData($request,$labour);
       
        // print_r($labour);
        Labour::where('id',$id)->update($labour);
        Labour_Skill::where('labours_id',$id)->delete();

        if(is_array($request->input('skill_list')) && count($request->input('skill_list'))>0){
          foreach ($request->input('skill_list') as $value) {
              $labour_skill=new Labour_Skill;
              $labour_skill->skill_id =$value;
              $labour_skill->labours_id=$id;
              $labour_skill->created_at =now();
              $labour_skill->save();
          }
        }
        return redirect('/labour')->with('info','Labour Modified Successfully');   
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // $commision= Commision::find($id);
        // $slip_exists=Slip::where('salary_month_id','=',$commision->salary_month_id)->where('is_paid','=',1)->get();
        // if(count($slip_exists)>0){
        //     return redirect('/commision')->with('error_delete',' This Commision cannot delete ');

        // }else{
        // }
        
        DB::table('labour__skills')->where('labours_id','=',$id)->delete();
        Labour::where('id',$id)->delete();
        return redirect('/labour')->with('info','Labour Deleted Successfully');
            
    }

    public function validateData(Request $request)
    {
      $this->validate(request(),[
        'employee_name' => 'required',
        'labour_category' => 'required',
        'expected_rate_per_day' => 'required',
        ]);  
    }

    public function getData(Request $request,$data)
    {   
        $data['employees_id']=$request->input('employee_name');
        $data['is_skill']=$request->input('labour_category');
        $data['expected_rate']=$request->input('expected_rate_per_day');
        $data['recomended_employee_id']=($request->input('contact_person_name')!==null) ?  $request->input('contact_person_name'): 0 
;
        $data['created_at']=now();
 
        return $data;
    }
}
