<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Work_Place;
class WorkPlaceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['workplaces']=Work_Place::all();
        return  view('workplace.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['title']="Register";
        $data['url']="/workplace";
        return  view('workplace.form',$data);
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
        $workplace = new Work_Place($request->all());
        $workplace->save();
        return redirect('/workplace')->with('info','Workplace Added Successfully');   


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
       $data['workplace']=Work_Place::find($id);
       $data['title']="Modify";
       $data['url']="/workplace/".$id;
       return  view('workplace.form',$data); 
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
        //
        $this->validateData($request);

        $workplace = Work_Place::find($id);
        $workplace->update($request->all()); 
        return redirect('/workplace')->with('info','Workplace Modified Successfully');   


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Work_Place::where('id',$id)->delete();
        return redirect('/workplace')->with('info','Workplace Deleted Successfully'); 

    }

    public function validateData(Request $request)
    {
      $this->validate(request(),[
        'name' => 'required',
        'address' => 'required',
        'start_date' => 'required',
        
        ]);  
    }

}
