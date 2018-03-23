<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rules\SalaryMonthExists;
use App\Advance;
use App\SalaryMonth;
use App\Slip;
use Fpdf;

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
         $advances = DB::table('advances')
            ->join('salary_months', 'salary_months.id', '=', 'advances.salary_month_id')
            ->select('advances.*','salary_months.month','salary_months.year' )
            ->get();
         $data['advances']=$advances;
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
        $this->validate(request(),[
            'advance_amount' => 'required',
            'employee_name' => 'required',
            'salary_year_and_month' => ['required', new SalaryMonthExists]
        ]);
        
        $dates=getStartAndEndDateOfSalaryMonth($request->input('salary_year_and_month'));
        $advance=new Advance;
        $advance->advance_amount=($request->input('advance_amount')!==null) ? $request->input('advance_amount') : 0 ;
        $advance->employee_id=($request->input('employee_name')!==null) ? $request->input('employee_name') : '' ;
        $advance->salary_month_id=($dates['id']!==null) ? $dates['id'] : 0 ;
        $advance->save();
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
        $advance=Advance::find($id);
        $salary_month=SalaryMonth::find($advance->salary_month_id);
        // echo($id);
        $line_height=5;
        Fpdf::AddPage('P');
        Fpdf::SetFont('Arial','B',12);
       
        // Fpdf::Cell(10,$line_height*2,'',0,0,'C');
        Fpdf::Cell(100,$line_height*2,'KVK Motors - Advance Payment','T,L,R',0,'C');

        Fpdf::Ln();
        Fpdf::SetFont('Arial','',10);
        // Fpdf::Cell(10,5,'',0,0,'C');
        Fpdf::Cell(100,5,'For the Salary Month of '.date("F", strtotime("2001-" .$salary_month->month. "-01")).' '.$salary_month->year,'L,R',0,'C');
        Fpdf::Ln();
        Fpdf::SetFont('Arial','',10);

        // Fpdf::Cell(10,$line_height*2,'',0,0,'C');
        Fpdf::Cell(100,$line_height,'Employee Name:','T,L,R',0,'L');
        Fpdf::Ln();

        // Fpdf::Cell(10,$line_height*2,'',0,0,'C');
        Fpdf::Cell(100,$line_height,getColumn('employees','name','id',$advance->employee_id),'L,R',0,'C');
        
        Fpdf::Ln();

        Fpdf::Cell(100,$line_height,'Employee NIC No :','L,R',0,'L');
        Fpdf::Ln();

        // Fpdf::Cell(10,$line_height*2,'',0,0,'C');
        Fpdf::Cell(100,$line_height,getColumn('employees','nic_no','id',$advance->employee_id),'L,R',0,'C');
        
        Fpdf::Ln();
        // Fpdf::Cell(10,$line_height,'',0,0,'C');
        Fpdf::Cell(100,$line_height,'Amount : Rs.'.number_format($advance->advance_amount,2)." /=",'L,R',0,'L');
        Fpdf::Ln();
        // Fpdf::Cell(10,$line_height,'',0,0,'C');
        
        Fpdf::Cell(100,$line_height,'Date Issued : '.($advance->created_at),'L,R,B',0,'L');
        Fpdf::SetFont('Arial','B',10);
        
        Fpdf::Ln();
        // Fpdf::Cell(10,$line_height,'',0,0,'C');
        Fpdf::Cell(50,$line_height*2,'','L',0,'C');
        Fpdf::Cell(50,$line_height*2,'','R',0,'C'); 
        Fpdf::Ln();
        // Fpdf::Cell(10,$line_height,'',0,0,'C');
        Fpdf::Cell(50,$line_height,'...............................','L',0,'C');
        Fpdf::Cell(50,$line_height,'...............................','R',0,'C'); 
        Fpdf::Ln();
        // Fpdf::Cell(10,$line_height,'',0,0,'C');
        Fpdf::Cell(50,$line_height,'Prepared By','L',0,'C');
        Fpdf::Cell(50,$line_height,'Received By','R',0,'C'); 

        Fpdf::Ln();
        // Fpdf::Cell(10,$line_height,'',0,0,'C');
        Fpdf::Cell(100,$line_height,'','L,R',0,'C'); 
        Fpdf::Ln();
        // Fpdf::Cell(10,$line_height,'',0,0,'C');
        Fpdf::Cell(100,$line_height,'......................','L,R',0,'C');
        Fpdf::Ln();
        // Fpdf::Cell(10,$line_height,'',0,0,'C');
        Fpdf::Cell(100,$line_height,'Authorized By','L,R,B',0,'C');
        Fpdf::Output();
        exit;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['advance']=Advance::find($id);
        $data['salary_month']=SalaryMonth::find($data['advance']->salary_month_id);
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
        $this->validate(request(),[
            'advance_amount' => 'required',
            'employee_name' => 'required',
            'salary_year_and_month' => ['required', new SalaryMonthExists]
        ]);
        $data=array();
        $dates=getStartAndEndDateOfSalaryMonth($request->input('salary_year_and_month'));
        $data['advance_amount']=($request->input('advance_amount')!==null) ? $request->input('advance_amount') : 0 ;
        $data['employee_id']=($request->input('employee_name')!==null) ? $request->input('employee_name') : '' ;
        $data['salary_month_id']=($dates['id']!==null) ? $dates['id'] : 0 ;

        // $data= array('advance_amount'=>$request->input('advance_amount'),
        //         'employee_id'=>$request->input('employee_name'),
        //         'salary_month_id'=>$dates['id']);
        Advance::where('id',$id)->update($data);
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
}
