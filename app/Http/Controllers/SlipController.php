<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rules\SalaryMonthExists;
use App\SlipFeature;
use App\LoanAccount;
use App\WelfareAccount;
use App\Employee;
use App\Loan;
use Illuminate\Support\Facades\DB;
use Session;
use App\SalaryMonth;
use Fpdf;
class SlipController extends Controller
{
    public function viewFreelancePaySlips(Request $request)
    {
        if ($request->isMethod('post'))
        {
           $this->validate(request(),[
            'salary_month' => ['required', new SalaryMonthExists]
            ]);
        }
        $data=$this->getSalaryDetails(1, $request);
        return  view('slip.fslips',$data);
    }

    public function viewPaySlips(Request $request)
    {
        if ($request->isMethod('post'))
        {
           $this->validate(request(),[
            'salary_month' => ['required', new SalaryMonthExists]
            ]);
        }
        $data=$this->getSalaryDetails(2, $request);
        return  view('slip.slips',$data);
    }
    public function viewEPFPaySlips(Request $request)
    {
        if ($request->isMethod('post'))
        {
           $this->validate(request(),[
            'salary_month' => ['required', new SalaryMonthExists]
            ]);
        }
        $data=$this->getSalaryDetails(3, $request);
        return  view('slip.eslips',$data);
    }

    public function viewEPFPayReport(Request $request)
    {
    	
        if ($request->isMethod('post'))
        {
           $this->validate(request(),[
            'salary_month' => ['required', new SalaryMonthExists]
            ]);
        }
        $data=$this->getSalaryDetails(4, $request);
        return  view('slip.epfreport',$data);
    }



    public function addSlipFeatures(Request $request)
    {
        $this->validate(request(),[
            'feature_type' => 'required',
            'description' => 'required',
            'employee_name' => 'required',
            'amount' => 'required',
            'salary_month_id' => 'required',
            ]);
        $slip_feature=new SlipFeature;
        $slip_feature->description=$request->input('description');
        $slip_feature->salary_month_id=$request->input('salary_month_id');
        $slip_feature->employee_id=$request->input('employee_name');
        $slip_feature->feature_type=$request->input('feature_type');
        $slip_feature->amount=$request->input('amount');
        $slip_feature->save();
        
        $data=$this->getSalaryDetails($request->input('page_type'), $request);
        // return back()->with('info','Slip Feature Added Successfully');
        Session::flash('success', 'Slip Feature Added Successfully');
        if($request->input('page_type')==1){
            return  view('slip.fslips',$data);
        }else{
            return  view('slip.slips',$data);
        }
        
    }

    public function getSalaryDetails($type,Request $request)
    {
        //type ==1 freelance else all type==3 epf ,4-epfreport
        
        $data=array();
        $dates=getStartAndEndDateOfSalaryMonth($request->input('salary_month'));
            
        $data['salary_month_id']=$dates['id'];
        $data['salary_month']=$request->input('salary_month');
        $data['start_date']=$dates['start_date'];
        $data['end_date']=$dates['end_date'];

        // $data['workdays']=getWorkDaysOfSalaryMonth($dates['id']);
        
        if($type==1){
            $data['url']="/viewfreelanceslips";
            $data['page_type']=1;
            
            $data['employees']=DB::table('employees')
                ->where('category_id', '=', '2')
                ->get();

        }elseif($type==3){
            $data['url']="/viewepfslips";
            $data['page_type']=3;
            
            $data['employees']=DB::table('employees')
                ->where('category_id', '<>', '2')
                ->where('epf_availability', '=', '1')
                ->get();

        }elseif($type==4){
            $data['url']="/viewepfreport";
            $data['page_type']=4;
            
            $data['employees']=DB::table('employees')
                ->where('category_id', '<>', '2')
                ->where('epf_availability', '=', '1')
                ->get();

        }else{
            $data['employees']=DB::table('employees')
                ->where('category_id', '<>', '2')
                ->get();

            $data['page_type']=2;
            $data['url']="/viewslips";

        }
        $data['title']="View";
        $data['url_slip_features']="/addslipfeatures";
        
        return $data;
    }

    public function editSlip($employee_id,$salary_month_id)
    {
        $data=array();
        $data['title']="Modify";
        $data['url']="editloanpay/$employee_id/$salary_month_id";
        $data['employee_id']=$employee_id;
        $data['salary_month_id']=$salary_month_id;

        $data['allowances']=getSlipFeature(1,$salary_month_id,$employee_id,true);
        $data['deductions'] =getSlipFeature(2,$salary_month_id,$employee_id,true);
        $data['loan_details']=getLoanDetails($salary_month_id,$employee_id);

        return  view('slip.edit',$data);

    }

    public function deleteSlipFeature($employee_id,$salary_month_id,$feature_id)
    {
        // echo "".$employee_id." ".$salary_month_id." ".$feature_id;
        SlipFeature::where('id',$feature_id)->delete();
        return redirect('/editslip/'.$employee_id.'/'.$salary_month_id)->with('info','Deleted Successfully');
    }

    public function editLoanPay(Request $request,$employee_id,$salary_month_id)
    {
       
        $salary_month=SalaryMonth::find($salary_month_id);
        $amount_to_pay=$request->input('loan_amount_to_pay');
        $paid_sum_for_this_month=getLoanDetails($salary_month_id,$employee_id);
        
        $loan_payments=DB::table('loan_payments')->where('salary_month_id', '=', $salary_month_id)->get();
        $loan_pay_array=array();

        if($paid_sum_for_this_month>$amount_to_pay){
            foreach ($loan_payments as $loan_pay) {
            $loan=Loan::find($loan_pay->loan_id);

            $loan_details=numberOfInstallmentstoPay($loan,$salary_month->end_date);
            $number_of_tobe_paid_installment=$loan_details['number_of_tobe_paid_installment'];
            $paid_total=$loan_details['paid_total'];
            // print_r($get_loans);
            $to_be_paid=$number_of_tobe_paid_installment*($loan->value_of_a_installment)-$paid_total;
            $installment=0;
            if($to_be_paid>$amount_to_pay){
                $installment=$amount_to_pay;
                $amount_to_pay=0;
            }elseif($to_be_paid<$amount_to_pay){
                $installment=$to_be_paid;
                $amount_to_pay=$amount_to_pay-$to_be_paid;
            }
            
            $loan_payment=DB::table('loan_payments')->where('id', '=', $loan_pay->id)->where('status', '=', 0)
                ->update(['paid_amount'=>$installment,'status'=>0,'pay_date'=>now(),'description'=>'']);
            
           
           }

        }elseif($paid_sum_for_this_month<$amount_to_pay){
                    // DB::enableQueryLog(); 
            
            $loans = DB::table('loans')
                ->where('loans.employee_id', '=', $employee_id)
                ->where('loans.payment_start_date', '<', $salary_month->end_date)
                ->where('loans.status', '<>', 2)
                ->get();
            // $query = DB::getQueryLog();
            // dd($query);
            if($amount_to_pay>0){
                foreach($loans as $loan){
                   $loan_details = DB::table('loans')
                   ->join('loan_payments', 'loan_payments.loan_id', '=', 'loans.id')
                   ->where('loans.id', '=', $loan->id)
                   ->select(DB::raw('SUM(paid_amount) as paid_total'))
                   ->first();  

                   $balance_to_pay=($loan->loan_amount)-($loan_details->paid_total);
                   
                   if($balance_to_pay>$amount_to_pay){
                        $installment=$amount_to_pay;
                        $amount_to_pay=0;
                    }elseif($balance_to_pay<$amount_to_pay){
                        $installment=$balance_to_pay;
                        $amount_to_pay=$amount_to_pay-$balance_to_pay;
                    }

                    $check_paid=DB::table('loan_payments')->where('loan_id', '=', $loan->id)->where('salary_month_id', '=', $salary_month_id)->first();

                    if($installment>0 && count($check_paid)==0){

                    $loan_payment=DB::table('loan_payments')
                        ->insert(['paid_amount'=>$installment,'status'=>0,'salary_month_id'=>$salary_month_id,'pay_date'=>now(),'loan_id'=>$loan->id,'description'=>'']);

                    }elseif(count($check_paid)>0 && $installment>0){
                        $loan_payment=DB::table('loan_payments')->where('id', '=', $check_paid->id)->where('status', '=', 0)
                            ->update(['paid_amount'=>$installment,'status'=>0,'pay_date'=>now(),'description'=>'']);
            
                    }
                }

            }
            
        }
        
        DB::table('loan_payments')->where('paid_amount', '=', 0.00)->delete();
        
        return redirect('/editslip/'.$employee_id.'/'.$salary_month_id)->with('info',' Successfully');
        
    }

    function markPaidSlip($employee_id,$salary_month_id,$is_paid)
    {
        DB::table('slips')->where('employee_id', '=', $employee_id)->where('salary_month_id', '=', $salary_month_id)
                            ->update(['is_paid'=>$is_paid,'date_paid'=>now()]);
        $loan_payments=DB::table('loans')
               ->join('loan_payments', 'loan_payments.loan_id', '=', 'loans.id')
               ->where('loans.employee_id', '=', $employee_id)->where('loan_payments.salary_month_id', '=', $salary_month_id)->select('loan_payments.*')->get();
        if($is_paid==1){
            //insert loan accont && welfare account update status of loan payment

            foreach ($loan_payments as $payment) {
                $loan=new LoanAccount;
                $loan->description ="Loan Payment from ".getColumn('employees','name','id',$employee_id) ;
                $loan->type=1;
                $loan->status=1;
                $loan->date=now();
                $loan->amount=$payment->paid_amount;
                $loan->loan_payment_id=$payment->id;
                $loan->save();
                DB::table('loan_payments')->where('id', '=', $payment->id)->update(['status'=>1]);

            }

            $welfare=new WelfareAccount;
                $welfare->description ="welfare payment from ".getColumn('employees','name','id',$employee_id) ;
                $welfare->type=1;
                $welfare->status=1;
                $welfare->salary_month_id=$salary_month_id;
                $welfare->employee_id=$employee_id;
                $welfare->date=now();
                $welfare->amount=DB::table('employees')->where('id','=',$employee_id)->first()->welfare;
                $welfare->save();

        }else{
            //delete from loan accont && welfare account
        foreach ($loan_payments as $payment) {
                DB::table('loan_accounts')->where('loan_payment_id', '=', $payment->id)->delete();
                DB::table('loan_payments')->where('id', '=', $payment->id)->update(['status'=>0]);

            }
        DB::table('welfare_accounts')->where('salary_month_id', '=', $salary_month_id)->where('employee_id', '=', $employee_id)->delete();

        }
        return redirect()->back();
    }

    

    public function printSlips($employee_id,$salary_month_id)
    {
        $employee=Employee::find($employee_id);
        $salary_month=SalaryMonth::find($salary_month_id);
        $details=getWorkedDetails($employee,$salary_month->id,$salary_month->start_date,$salary_month->end_date);
        
        $line_height=5;
        $pdf = new FPDF();
        Fpdf::AddPage('L');
        Fpdf::SetFont('Arial','B',12);
       
        Fpdf::Cell(10,$line_height*2,'',0,0,'C');
        Fpdf::Cell(100,$line_height*2,'KVK Motors','T,L,R',0,'C');

        Fpdf::Ln();
        Fpdf::SetFont('Arial','',10);
        Fpdf::Cell(10,5,'',0,0,'C');
        Fpdf::Cell(100,5,'Salary : Month of '.date("F", strtotime("2001-" .$salary_month->month. "-01")).' '.$salary_month->year,'L,R',0,'C');
        Fpdf::Ln();
        Fpdf::Cell(10,$line_height,'',0,0,'C');
        Fpdf::Cell(100,$line_height,'Employee : '.ucfirst($employee->name),'L,R',0,'C');
        Fpdf::Ln();
        Fpdf::Cell(10,$line_height,'',0,0,'C');
        $designation=getColumn('designations','name','id',$employee->designation_id);
        Fpdf::Cell(100,$line_height,'Designation : '.ucfirst($designation),'L,R,B',0,'C');
        Fpdf::SetFont('Arial','B',10);

        Fpdf::Ln();
        Fpdf::Cell(10,$line_height,'',0,0,'L');
        Fpdf::Cell(60,$line_height,'No of  days worked: ','L,B',0,'L');
        Fpdf::Cell(40,$line_height,($details['total_worked_days']),'R,B',0,'C');
        
        
        if(($employee->employee_salary_type==0)){
         $total=$employee->per_day_salary*$details['total_worked_days']; 
        }else{
          $total=$employee->monthly_salary; 
        }
        
        Fpdf::SetFont('Arial','',10);
        Fpdf::Ln();
        Fpdf::Cell(10,$line_height,'',0,0,'L');
        Fpdf::Cell(60,$line_height,'Total Amount','L',0,'L');
        Fpdf::Cell(40,$line_height,number_format($total,2),'R',0,'R');
        
        $ot=$details['total_ot_hours']*($employee->ot_rate);
        if($ot>0){
            Fpdf::Ln();
            Fpdf::Cell(10,$line_height,'',0,0,'L');
            Fpdf::Cell(60,$line_height,'OT Paid ','L',0,'L');
            Fpdf::Cell(40,$line_height,number_format($ot,2),'R',0,'R');
            
        }

        $commision=$details['total_commision'];
        if($commision>0){
            Fpdf::Ln();
            Fpdf::Cell(10,$line_height,'',0,0,'L');
            Fpdf::Cell(60,$line_height,'Commision ','L',0,'L');
            Fpdf::Cell(40,$line_height,number_format($commision,2),'R',0,'R');
            
        }

        $allowance_total=0;
          if($details['total_worked_days']>25){
            if($employee->employee_salary_type==0){
              $allowance_total=$employee->allowance_per_day*$details['total_worked_days'];
            }else{
              $allowance_total=$employee->allowance_per_day;
            }

          }

        if($allowance_total>0){
            Fpdf::Ln();
            Fpdf::Cell(10,$line_height,'',0,0,'C');
            Fpdf::Cell(50,$line_height,'Allowance over 25 days','T,L',0,'L');
            Fpdf::Cell(50,$line_height,number_format($allowance_total,2),'T,R',0,'R'); 
            
            
        }
        
        $other_allowances=$details['other_total_allowances'];
        if($other_allowances>0){
            Fpdf::Ln();
            Fpdf::Cell(10,$line_height,'',0,0,'C');
            Fpdf::Cell(50,$line_height,'Other Allowances','L',0,'L');
            Fpdf::Cell(50,$line_height,number_format($other_allowances,2),'R',0,'R'); 
        }


        $total_salary=$total+$ot+$commision+$other_allowances+$allowance_total;
        Fpdf::Ln();
        Fpdf::Cell(10,$line_height,'',0,0,'C');
        Fpdf::Cell(50,$line_height,'Total','T,L',0,'L');
        Fpdf::Cell(50,$line_height,number_format($total_salary,2),'T,R',0,'R'); 
        
        $advance=$details['total_advance'];
        if($advance>0){
            Fpdf::Ln();
            Fpdf::Cell(10,$line_height,'',0,0,'C');
            Fpdf::Cell(50,$line_height,'Advance','T,L',0,'L');
            Fpdf::Cell(50,$line_height,number_format($advance,2),'T,R',0,'R'); 
            

        }
        
        $loan=$details['loan_details'];
        if($loan>0){
            Fpdf::Ln();
            Fpdf::Cell(10,$line_height,'',0,0,'C');
            Fpdf::Cell(50,$line_height,'Loan Details','L',0,'L');
            Fpdf::Cell(50,$line_height,number_format($loan,2),'R',0,'R'); 
        }

        $other_deductions=$details['other_total_deductions'];
        if($other_deductions>0){
            Fpdf::Ln();
            Fpdf::Cell(10,$line_height,'',0,0,'C');
            Fpdf::Cell(50,$line_height,'Other Deductions','L',0,'L');
            Fpdf::Cell(50,$line_height,number_format($other_deductions,2),'R',0,'R'); 
        }
        
        $welfare=$employee->welfare;
        if($welfare>0){
            Fpdf::Ln();
            Fpdf::Cell(10,$line_height,'',0,0,'C');
            Fpdf::Cell(50,$line_height,'Welfare','L',0,'L');
            Fpdf::Cell(50,$line_height,number_format($welfare,2),'R',0,'R'); 
            
        }

        $total_deductions=$advance+$loan+$other_deductions+$welfare;

        Fpdf::Ln();
        Fpdf::Cell(10,$line_height,'',0,0,'C');
        Fpdf::Cell(50,$line_height,'Total Deductions','T,L',0,'L');
        Fpdf::Cell(50,$line_height,number_format($total_deductions,2),'T,R',0,'R'); 

        $gross_salary=$total_salary-$total_deductions;
        Fpdf::Ln();
        Fpdf::Cell(10,$line_height,'',0,0,'C');
        Fpdf::Cell(50,$line_height,'Gross Salary','T,L',0,'L');
        Fpdf::Cell(50,$line_height,number_format($gross_salary,2),'T,R',0,'R'); 

        if($details['total_leaves']>21){
          $epf_8=((($employee->basic_salary+$details['budget_allowance'])/25)*$details['total_worked_days'])*(8/100);
          $epf_12=((($employee->basic_salary+$details['budget_allowance'])/25)*$details['total_worked_days'])*(12/100);
          $etf_3=((($employee->basic_salary+$details['budget_allowance'])/25)*$details['total_worked_days'])*(3/100);
        }else{
          $epf_8=($employee->basic_salary+$details['budget_allowance'])*(8/100);
          $epf_12=($employee->basic_salary+$details['budget_allowance'])*(12/100);
          $etf_3=($employee->basic_salary+$details['budget_allowance'])*(3/100);
        }
        $epf_tot=$epf_8+$epf_12;
        if($employee->epf_availability==1){
            $net_salary=$gross_salary-$epf_8;
        }else{
            $net_salary=$gross_salary;
        }

        if($employee->epf_availability==1){
            Fpdf::Ln();
            Fpdf::Cell(10,$line_height,'',0,0,'C');
            Fpdf::Cell(50,$line_height,'EPF 8%','T,L',0,'L');
            Fpdf::Cell(50,$line_height,number_format($epf_8,2),'T,R',0,'R');
            
            Fpdf::Ln();
            Fpdf::Cell(10,$line_height,'',0,0,'C');
            Fpdf::Cell(50,$line_height,'EPF 12%','T,L',0,'L');
            Fpdf::Cell(50,$line_height,number_format($epf_12,2),'T,R',0,'R');
            
            Fpdf::Ln();
            Fpdf::Cell(10,$line_height,'',0,0,'C');
            Fpdf::Cell(50,$line_height,'EPF Total','T,L',0,'L');
            Fpdf::Cell(50,$line_height,number_format($epf_tot,2),'T,R',0,'R');
            
            Fpdf::Ln();
            Fpdf::Cell(10,$line_height,'',0,0,'C');
            Fpdf::Cell(50,$line_height,'ETF 3%','T,L',0,'L');
            Fpdf::Cell(50,$line_height,number_format($etf_3,2),'T,R',0,'R');
            
        }

        Fpdf::Ln();
        Fpdf::Cell(10,$line_height,'',0,0,'C');
        Fpdf::Cell(50,$line_height,'Net Salary','T,L',0,'L');
        Fpdf::Cell(50,$line_height,number_format($net_salary,2),'T,R',0,'R');

        Fpdf::Ln();
        Fpdf::Cell(10,$line_height,'',0,0,'C');
        Fpdf::Cell(50,$line_height,'','L',0,'C');
        Fpdf::Cell(50,$line_height,'','R',0,'C'); 
        Fpdf::Ln();
        Fpdf::Cell(10,$line_height,'',0,0,'C');
        Fpdf::Cell(50,$line_height,'...............................','L',0,'C');
        Fpdf::Cell(50,$line_height,'...............................','R',0,'C'); 
        Fpdf::Ln();
        Fpdf::Cell(10,$line_height,'',0,0,'C');
        Fpdf::Cell(50,$line_height,'Prepared By','L',0,'C');
        Fpdf::Cell(50,$line_height,'Received By','R',0,'C'); 

        Fpdf::Ln();
        Fpdf::Cell(10,$line_height,'',0,0,'C');
        Fpdf::Cell(100,$line_height,'','L,R',0,'C'); 
        Fpdf::Ln();
        Fpdf::Cell(10,$line_height,'',0,0,'C');
        Fpdf::Cell(100,$line_height,'......................','L,R',0,'C');
        Fpdf::Ln();
        Fpdf::Cell(10,$line_height,'',0,0,'C');
        Fpdf::Cell(100,$line_height,'Authorized By','L,R,B',0,'C');
        Fpdf::Output();
        exit;
    }
}
