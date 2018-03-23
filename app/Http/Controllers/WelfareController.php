<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\WelfareAccount;

class WelfareController extends Controller
{
    public function welfareAccount()
    {
        //
        $data['welfare_accounts']=WelfareAccount::orderBy('date', 'asc')->get();
        $data['url']="/addwelfarecreditdebit";
        return view('welfare.welfare_account',$data);
       
    }
// 	welfareAccount
// welfarePaymentList
	public function addWelfareCreditDebit(Request $request)
    {
        //`description`, `type`, `date`, `amount`
        $this->validate(request(),[
            'description' => 'required',
            'type' => 'required',
            'date' => 'required',
            'amount' => 'required',
        ]);

        $welfare=new WelfareAccount;
        $welfare->description =$request->input('description');
        $welfare->type=$request->input('type');
        $welfare->date=$request->input('date');
        $welfare->amount=$request->input('amount');
        $welfare->save();

        // $this->loanAccount();
        $data['welfare_accounts']=WelfareAccount::orderBy('date', 'asc')->get();
        $data['url']="/addwelfarecreditdebit";
        return  view('welfare.welfare_account',$data);

        // echo "cvhb3gfhfd";
    }

    public function welfarePaymentList()
    {
        $data['welfare_payments']=WelfareAccount::orderBy('date', 'asc')->get();;
        $data['url']="/addwelfarecreditdebit";
        return  view('welfare.welfare_payment_list',$data);

    }

    public function deletePayment($id)
    {
        WelfareAccount::where('id',$id)->delete();
        return redirect('/welfarepaylist')->with('info','Deleted Successfully');
    }
}
