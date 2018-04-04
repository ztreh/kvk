<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Holiday;
use App\HolidayWorkplace;
class HolidayWorkplaceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['holidays']=HolidayWorkplace::all();
        return  view('holiday.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['title']="Register";
        $data['url']="/holiday";
        return  view('holiday.form',$data);
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
        return redirect('/holiday')->with('info','Holiday Added Successfully');
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
        $data['holiday']=HolidayWorkplace::find($id);
        $data['title']="Modify";
        $data['url']="/holiday/".$id;
        return  view('holiday.form',$data);
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
        return redirect('/holiday')->with('info','Holiday Added Successfully');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        HolidayWorkplace::where('id',$id)->delete();
        return redirect('/holiday')->with('info','Holiday Deleted Successfully');
    }

    public function validateData(Request $request)
    {
      $this->validate(request(),[
        'name' => 'required',
        'work_places_id' => 'required',
        'start_date' => 'required',
        'start_time' => 'required',
        'end_date' => 'required',
        'end_time' => 'required',
        'status' => 'required',
        ]);  
    }

    public function saveData(Request $request,$id=0)
    {   
        $holiday=new Holiday($request->all());
        $holiday_id=$holiday->insertData($request);

        if($id>0){
            $holiday_workplace=HolidayWorkplace::find($id);
        }else{
            $holiday_workplace=new HolidayWorkplace($request->all());
        }
        $holiday_workplace->insertData($request,$holiday_id,$id);
        
    }

}
