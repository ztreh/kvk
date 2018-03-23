<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\HolidayType;
use App\Holiday;
use Illuminate\Support\Facades\DB;
class HolidayController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $holidays = DB::table('holidays')
            ->join('holiday_types', 'holiday_types.id', '=', 'holidays.holiday_type_id')
            ->select('holidays.*', 'holiday_types.name')
            ->get();
        $data['holidays']=$holidays;
        return  view('holiday.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['holidaytypes']=HolidayType::all();
        $data['title']="Register";
        $data['url']="/holiday";
        return  view('holiday.form',$data);
    }

    // employee_name
    // from_date
    // from_time
    // to_date
    // to_time


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate(request(),[
            'holiday_type' => 'required',
            'from_date' => 'required',
            'to_date' => 'required',
        ]);
 
        $holiday=new Holiday;
        $holiday->holiday_type_id=$request->input('holiday_type');
       
        $holiday->employee_id= ($request->input('employee_name')!==null) ? getEmployeeID($request->input('employee_name'),"") : 0;
        $holiday->from_time = ($request->input('from_time')!==null) ? $request->input('from_time') : '00:00:00';
        $holiday->to_time = ($request->input('to_time')!==null) ? $request->input('to_time') : '00:00:00';
        $holiday->to_date = ($request->input('to_date')!==null) ? $request->input('to_date') : '';
        $holiday->from_date = ($request->input('from_date')!==null) ? $request->input('from_date') : '';
        $holiday->save();
        return redirect('/holiday')->with('info','Holiday Registered Successfully');
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
        $data['holidaytypes']=HolidayType::all();
        $data['holiday']=Holiday::find($id);
        $data['url']="/holiday/".$data['holiday']->id;
        $data['title']="Modify";
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
        $this->validate(request(),[
            'holiday_type' => 'required',
            'from_date' => 'required',
            'to_date' => 'required',
        ]);
        
        
        $data=array('holiday_type_id' => $request->input('holiday_type'),'employee_id'=>getEmployeeID($request->input('employee_name'),""),'from_time'=>$request->input('from_time'),'to_time'=>$request->input('to_time'),'to_date'=>$request->input('to_date'),'from_date'=>$request->input('from_date'));
        Holiday::where('id',$id)->update($data);
        return redirect('/holiday')->with('info','Holiday Modified Successfully');    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Holiday::where('id',$id)->delete();
        return redirect('/holiday')->with('info','Holiday Deleted Successfully');
    }
}
