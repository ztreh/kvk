<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TimeSlot;

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
        $data['timeslots']=TimeSlot::all();
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

        $timeslot = new TimeSlot($request->all());
        if(!($timeslot->checkSlotNameExist($request->input('name')))){
            $timeslot->save();
            $timeslot_id=$timeslot->id;
        }else{
            $timeslot_id=$timeslot->getID($request->input('name'));
        }

        //pivot


        //time slot time

        return redirect('/timeslot/create')->with('info','Time Slot Added Successfully');
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
        $data['timeslot']=TimeSlot::find($id);
        $data['title']="Modify";
        $data['timeslots']=TimeSlot::all();
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
        $this->validateData($request);

        $timeslot = TimeSlot::find($id);
        $timeslot->update($request->all()); 
        return redirect('/timeslot/create')->with('info','Time Slot Modified Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        TimeSlot::where('id',$id)->delete();
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
}
