<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\LoanTypes;
use App\Loan;
use App\LoanAccount;
use App\WelfareAccount;
use App\LoanPayments;
use Fpdf;

class LoanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['loans']=Loan::all();
        return  view('loan.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        $data['loan_types']=LoanTypes::all();
        $data['title']="Register";
        $data['url']="/loan";
        return  view('loan.form',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    /*
    
    loan_type
    employee_name
    loan_amount
    number_of_installment
    loan_interest
    value_of_a_installment
    total_amount_to_pay
    payment_start_date
    other_details


    */
    public function store(Request $request)
    {
         $this->validate(request(),[
            'loan_type' => 'required',
            'employee_name' => 'required',
            'loan_amount' => 'required',
            'number_of_installment' => 'required',
            'value_of_a_installment' => 'required',
            'payment_start_date' => 'required',
            
        ]);

        $loan=new Loan;
        $loan->employee_id =($request->input('employee_name')!==null) ? $request->input('employee_name') : 0 ;  
        $loan->loan_type_id=($request->input('loan_type')!==null) ? $request->input('loan_type') : 0 ;  
        $loan->loan_interest=($request->input('loan_interest')!==null) ? $request->input('loan_interest') : 0.00 ;  
        $loan->loan_amount=($request->input('loan_amount')!==null) ? $request->input('loan_amount') : '' ;  
        $loan->value_of_a_installment =($request->input('value_of_a_installment')!==null) ? $request->input('value_of_a_installment') : 0.00 ;  
        $loan->num_of_installments=($request->input('number_of_installment')!==null) ? $request->input('number_of_installment') : 0 ;  
        $loan->payment_start_date =($request->input('payment_start_date')!==null) ? $request->input('payment_start_date')  : '0000-00-00' ;  
        $loan->other_details=($request->input('other_details')!==null) ? $request->input('other_details')  : '' ;  
        $loan->save();
        if($request->input('loan_type')==1){
            $loan=new LoanAccount;
                $loan->description ="Salary Loan ".getColumn('employees','name','id',$request->input('employee_name')) ;
                $loan->type=2;
                $loan->status=1;
                $loan->date=now();
                $loan->amount=$request->input('loan_amount');
                $loan->save();
            
        }

        if($request->input('loan_type')==2){
        $welfare=new WelfareAccount;
                $welfare->description ="welfare loan ".getColumn('employees','name','id',$request->input('employee_name')) ;
                $welfare->type=2;
                $welfare->status=1;
                $welfare->employee_id=$request->input('employee_name');
                $welfare->date=now();
                $welfare->amount=$request->input('loan_amount');
                $welfare->save();
            
        }
      
        return redirect('/loan')->with('info','Loan Registered Successfully');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['loan_installments']=LoanPayments::where('loan_id','=',$id)->get();
        $loan= Loan::where('id', '=', $id)->first();

        $line_height=5;
        Fpdf::AddPage('P');
        Fpdf::SetFont('Arial','B',12);
       
        
        Fpdf::Cell(100,$line_height*2,'KVK Motors - '.getColumn('loan_types','name','id',$loan->loan_type_id),'T,L,R',0,'C');
        Fpdf::Ln();
        
        Fpdf::SetFont('Arial','',10);

        
        Fpdf::Cell(100,$line_height,'Employee Name:','T,L,R',0,'L');
        Fpdf::Ln();

        Fpdf::Cell(100,$line_height,getColumn('employees','name','id',$loan->employee_id),'L,R',0,'C');
        
        Fpdf::Ln();

        Fpdf::Cell(100,$line_height,'Employee NIC No :','L,R',0,'L');
        Fpdf::Ln();

        Fpdf::Cell(100,$line_height,getColumn('employees','nic_no','id',$loan->employee_id),'L,R',0,'C');
        
        Fpdf::Ln();
        Fpdf::Cell(100,$line_height,'Loan Amount : Rs.'.number_format($loan->loan_amount,2)." /=",'T,L,R',0,'L');
        Fpdf::Ln();

        Fpdf::Cell(100,$line_height,'Number of installments : '.$loan->num_of_installments,'L,R',0,'L');
        Fpdf::Ln();
        if($loan->loan_type_id!=3){
           Fpdf::Cell(100,$line_height,'Loan Interest : '.number_format($loan->loan_interest,2),'L,R',0,'L');
           Fpdf::Ln(); 
        }
        Fpdf::Cell(100,$line_height,'Amount of Installment : Rs.'.number_format($loan->value_of_a_installment,2),'L,R',0,'L');
        Fpdf::Ln();
        Fpdf::Cell(100,$line_height,'Total Amount to Pay : Rs.'.number_format(($loan->value_of_a_installment)*($loan->num_of_installments),2),'L,R',0,'L');
        Fpdf::Ln();

        Fpdf::Cell(100,$line_height,'Payments Start Date : '.$loan->payment_start_date,'L,R',0,'L');

        Fpdf::Ln();

        Fpdf::Cell(100,$line_height,'Description : '.$loan->other_details,'L,R',0,'L');
        Fpdf::Ln();
        Fpdf::Cell(100,$line_height,'Date Issued : '.($loan->created_at),'L,R,B',0,'L');
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


        // return  view('loan.loan_installments',$data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['loan']=Loan::find($id);
        $data['loan_types']=LoanTypes::all();
        $data['url']="/loan/".$data['loan']->id;
        $data['title']="Modify";
        return  view('loan.form',$data);
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
            'loan_type' => 'required',
            'employee_name' => 'required',
            'loan_amount' => 'required',
            'number_of_installment' => 'required',
            'value_of_a_installment' => 'required',
            'payment_start_date' => 'required',
            
        ]);
        $data=array();
        $data['employee_id'] =($request->input('employee_name')!==null) ? $request->input('employee_name') : '' ;  
        $data['loan_type_id']=($request->input('loan_type')!==null) ? $request->input('loan_type') : '' ;  
        $data['loan_interest']=($request->input('loan_interest')!==null) ? $request->input('loan_interest') : '' ;  
        $data['loan_amount']=($request->input('loan_amount')!==null) ? $request->input('loan_amount') : '' ;  
        $data['value_of_a_installment'] =($request->input('value_of_a_installment')!==null) ? $request->input('value_of_a_installment') : '' ;  
        $data['num_of_installments']=($request->input('number_of_installment')!==null) ? $request->input('number_of_installment') : '' ;  
        $data['payment_start_date'] =($request->input('payment_start_date')!==null) ? $request->input('payment_start_date')  : '0000-00-00' ;  
        $data['other_details']=($request->input('other_details')!==null) ? $request->input('other_details')  : '' ;  

        Loan::where('id',$id)->update($data);
        return redirect('/loan')->with('info','Loan Modified Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $check_loan_payments=LoanPayments::where('loan_id','=',$id)->where('status','=',1)->get();
        if(count($check_loan_payments)==0){
            Loan::where('id',$id)->delete();
            LoanPayments::where('loan_id',$id)->delete();
            return redirect('/loan')->with('info','Loan Deleted Successfully');
        }else{
            return redirect('/loan')->with('error_delete',' This Loan cannot delete ');

        }
    }



    public function loanAccount()
    {
        //
        $data['loan_accounts']=LoanAccount::orderBy('date', 'asc')->get();;
        $data['url']="/addloancreditdebit";
        return view('loan.loan_account',$data);
       
    }
    
    public function addLoanCreditDebit(Request $request)
    {
        //`description`, `type`, `date`, `amount`
        $this->validate(request(),[
            'description' => 'required',
            'type' => 'required',
            'date' => 'required',
            'amount' => 'required',
        ]);

        $loan=new LoanAccount;
        $loan->description =$request->input('description');
        $loan->type=$request->input('type');
        $loan->date=$request->input('date');
        $loan->amount=$request->input('amount');
        $loan->save();

        // $this->loanAccount();
        $data['loan_accounts']=LoanAccount::orderBy('date', 'asc')->get();;
        $data['url']="/addloancreditdebit";
        return  view('loan.loan_account',$data);

        // echo "cvhb3gfhfd";
    }

    public function loanPaymentList()
    {
        $data['loan_payments']=LoanAccount::orderBy('date', 'asc')->get();;
        $data['url']="/addloancreditdebit";
        return  view('loan.loan_payment_list',$data);

    }

    public function deletePayment($id)
    {
        LoanAccount::where('id',$id)->delete();
        return redirect('/loanpaylist')->with('info','Deleted Successfully');
    }


}
