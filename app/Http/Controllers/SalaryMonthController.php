<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SalaryMonth;
use App\Working_day;
use App\Slip;
use App\Commision;
use App\Advance;
use App\LoanPayments;

use Illuminate\Support\Facades\DB;

class SalaryMonthController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['salarymonths']=SalaryMonth::all();
        return  view('salarymonth.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['title']="Register";
        $data['url']="/salarymonth";
        return  view('salarymonth.form',$data);
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
            'salary_year_and_month' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
        ]);

        $salarymonth=new SalaryMonth;
        $salarymonth->year=date('Y',strtotime($request->input('salary_year_and_month')));
        $salarymonth->month=date('n',strtotime($request->input('salary_year_and_month')));
        $salarymonth->start_date=$request->input('start_date');
        $salarymonth->end_date=$request->input('end_date');
        $salarymonth->budget_allowance=3500;
        $salarymonth->save();

        $id = $salarymonth->id;

        $dates=getDatesFromRange($request->input('start_date'),$request->input('end_date'));
        foreach ($dates as $date) {
            $workday=new Working_day;
            $workday->salary_id=$id;
            $workday->date=$date;
            $workday->save();
        }
        return redirect('/salarymonth')->with('info','Salary Month Registered Successfully');
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
        $data['salarymonth']=SalaryMonth::find($id);
        $data['url']="/salarymonth/".$data['salarymonth']->id;
        $data['title']="Modify";
        return  view('salarymonth.form',$data);
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
            'salary_year_and_month' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
        ]);

        $data=array('year' => date('Y',strtotime($request->input('salary_year_and_month'))),'month' => date('n',strtotime($request->input('salary_year_and_month'))),'start_date' => $request->input('start_date'),'end_date' => $request->input('end_date'),'budget_allowance' => 3500);
        SalaryMonth::where('id',$id)->update($data);
        return redirect('/salarymonth')->with('info','Salary Month Modified Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $check_slips=Slip::where('is_paid','=',1)->where('salary_month_id','=',$id)->get();
        $check_commsions=Commision::where('salary_month_id','=',$id)->get();
        $check_advances=Advance::where('salary_month_id','=',$id)->get();
        $check_loan_payments=LoanPayments::where('salary_month_id','=',$id)->get();
        
        if(count($check_slips)==0 && count($check_commsions)==0 && count($check_advances)==0 && count($check_loan_payments)==0){
            SalaryMonth::where('id',$id)->delete();
            return redirect('/salarymonth')->with('info','Salary Month Deleted Successfully'); 
            
        }else{
            return redirect('/salarymonth')->with('error_delete',"This Salary Month can't deleted"); 

        }
    }
}
