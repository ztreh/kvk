<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TimeSlot;
use App\TimeSlotTime;
use App\Workplace_Time_Slots;

class TimeSlotController extends Controller
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
        $data['url']="/timeslot";
        $data['timeslotimes']=TimeSlotTime::all();
        return  view('time_slot.form',$data);
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
        
        $data['timeslotimes']=TimeSlotTime::all();
        return redirect('/timeslot/create')->with('info','Time Slot Added Successfully',$data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['timeslot']=TimeSlotTime::find($id);
        $data['title']="Modify";
        $data['timeslotimes']=TimeSlotTime::all();
        $data['url']="/timeslot/".$id;
        return  view('time_slot.form',$data);
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
         
        // echo($request->status);
        $this->validateData($request);
        $this->saveData($request,$id);
        $data['timeslotimes']=TimeSlotTime::all();

        return redirect('/timeslot/create')->with('info','Time Slot Modified Successfully',$data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        TimeSlotTime::where('id',$id)->delete();
        return redirect('/timeslot/create')->with('info','Time Slot Deleted Successfully');
    }

    public function validateData(Request $request)
    {
      $this->validate(request(),[
        'name' => 'required',
        'start_time' => 'required',
        'end_time' => 'required',
        'status' => 'required',
        'work_places_id' => 'required',
        ]);  
    }

    public function saveData(Request $request,$id=0)
    {
        $timeslot = new TimeSlot($request->all());
        $timeslot_id=$timeslot->insertData($request);

        $workplace_timeslot=new Workplace_Time_Slots($request->all());
        $workplace_timeslot_id=$workplace_timeslot->insertData($request,$timeslot_id);
        
        if($id>0){
            $time_slot_time=TimeSlotTime::find($id);
        }else{
            $time_slot_time=new TimeSlotTime($request->all());
        }
        $time_slot_time->insertData($request,$workplace_timeslot_id,$id);
        
    }

}
