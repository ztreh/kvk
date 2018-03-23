<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Employee;
use App\SalaryMonth;
use App\Working_day;
use App\Loan;

class ReportController extends Controller
{

	public function epfEtfReport(Request $request)
	{ 
		if ($request->isMethod('post'))
        {
           $year=$request->input('year');
        }else{
			$year=date('Y');
        	
        }
		$data['years']=$this->getYears();
		$data['search_year']=$year;
        $data['salarymonths']=SalaryMonth::where('year','=',$year)->get();
		$data['employees']=Employee::where('category_id', '<>', '2')
                ->where('epf_availability', '=', '1')
                ->get();
		return view('report.epf_report',$data);
	}

	public function freelancePaymentReport(Request $request)
	{
		if ($request->isMethod('post'))
        {
           $year=$request->input('year');
        }else{
			$year=date('Y');
        	
        }
		$data['years']=$this->getYears();
		$data['search_year']=$year;
        $data['salarymonths']=SalaryMonth::where('year','=',$year)->get();
		$data['employees']=Employee::where('category_id','=',2)->get();
		return view('report.freelance_payment_summury',$data);
	}

	public function advancePaymentReport(Request $request)
	{
		$data['employees']=Employee::all();
        if ($request->isMethod('post'))
        {
           $year=$request->input('year');
        }else{
			$year=date('Y');
        	
        }
		$data['years']=$this->getYears();
		$data['search_year']=$year;
        $data['salarymonths']=SalaryMonth::where('year','=',$year)->get();
		
		return view('report.advance_payment_summury',$data);
	}

	public function attendanceSummaryReport(Request $request)
	{
		if ($request->isMethod('post'))
        {
           $year=$request->input('year');
        }else{
			$year=date('Y');
        	
        }
		$data['years']=$this->getYears();
		$data['search_year']=$year;
        $data['salarymonths']=SalaryMonth::where('year','=',$year)->get();
		$data['employees']=Employee::all();

		return view('report.attendance_summary',$data);
	}

	public function leaveSummaryReport()
	{
		$data['employees']=Employee::all();
		return view('report.leave_summary',$data);
	}

	public function loanSummaryReport()
	{
		$data['employees']=Employee::all();
		$data['loans']=Loan::all();
		$data['loan_payments']=LoanPaymentSummary();
		return view('report.loan_details_summary',$data);
	}

	public function monthlySalarySummaryReport(Request $request)
	{
		if ($request->isMethod('post'))
        {
           $year=$request->input('year');
        }else{
			$year=date('Y');
        	
        }
		$data['years']=$this->getYears();
		$data['search_year']=$year;
        $data['salarymonths']=SalaryMonth::where('year','=',$year)->get();
		$data['employees']=Employee::where('category_id','<>',2)->get();
		return view('report.monthly_salary_summary',$data);
	}

	public function getYears()
	{
		$year=SalaryMonth::groupby('year')->select('year')->get();
		return $year;
	}
    
}
