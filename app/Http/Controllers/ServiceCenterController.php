<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ServiceCenterCommision;
use App\Slip;
use App\ServiceCenterCommisionItem;
use Illuminate\Support\Facades\DB;
class ServiceCenterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['commisions']= DB::table('service_center_commisions')
            ->join('salary_months', 'salary_months.id', '=', 'service_center_commisions.salary_month_id')
            ->select('service_center_commisions.*','salary_months.month','salary_months.year' )
            ->get(); 
       return  view('commision.service_commision',$data);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // echo "fghgfhgfhfgh";
        $data['title']="Register";
        $data['url']="/servicecommision";
        return  view('commision.job_commision',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function validateCommisionDetails(Request $request)
    {
        $this->validate(request(),[
            'job_no' => 'required',
            'amount_of_sale' => 'required',
            'commision_percentage' => 'required',
            'commision_value' => 'required',
            'salary_year_and_month' => 'required',
            'employees_for_commision' => 'required',
        ]);
        
    }
    
    public function store(Request $request)
    {
        $this->validateCommisionDetails($request);

        $commision=new ServiceCenterCommision;
        $commision->job_no=$request->input('job_no');
        $commision->sale_amount=$request->input('amount_of_sale');
        $commision->commition_percentage=$request->input('commision_percentage');
        $commision->commition_value=$request->input('commision_value');
        $dates=getStartAndEndDateOfSalaryMonth($request->input('salary_year_and_month'));
        $commision->salary_month_id=$dates['id'];
        $commision->save();
        $service_center_commision_id=$commision->id;

        if(is_array($request->input('emp_id')) && count($request->input('emp_id'))>0){
           
            foreach ($request->input('emp_id') as $id) {
                $data['commition_percentage']=$request->input('emp_commsion_percentage_'.$id);
                $data['commision_value']=$request->input('commision_value_'.$id);
                $data['employee_id']=$id;
                $data['service_center_commision_id']=$service_center_commision_id;
                $data['created_at']=now();
                $commision_item =  DB::table('service_center_commision_items')->insert(array($data));
            }

        }
       
        return redirect('/servicecommision')->with('info','Commision Registered Successfully'); 
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
        $commisions = DB::table('service_center_commisions')
            ->where('service_center_commisions.id', '=', $id)
            ->join('salary_months', 'salary_months.id', '=', 'service_center_commisions.salary_month_id')
            ->select('service_center_commisions.*','salary_months.month','salary_months.year' )
            ->first();

        $data['commision']=$commisions;
        $data['commision_items']=DB::table('service_center_commision_items') ->where('service_center_commision_id', '=', $id)->get();
        $data['url']="/servicecommision/".$id;
        $data['title']="Modify";
        return  view('commision.job_commision',$data);
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
        $this->validateCommisionDetails($request);
        $dates=getStartAndEndDateOfSalaryMonth($request->input('salary_year_and_month'));
        $data=array('job_no'=>$request->input('job_no'),'sale_amount'=>$request->input('amount_of_sale'),'commition_percentage'=>$request->input('commision_percentage'),'commition_value'=>$request->input('commision_value'),'salary_month_id'=>$dates['id']);

        ServiceCenterCommision::where('id',$id)->update($data);
        $data=array();
        DB::table('service_center_commision_items')->where('service_center_commision_id','=',$id)->delete();
         if(is_array($request->input('emp_id')) && count($request->input('emp_id'))>0){
            foreach ($request->input('emp_id') as $empid) {
                $data['commition_percentage']=$request->input('emp_commsion_percentage_'.$empid);
                $data['commision_value']=$request->input('commision_value_'.$empid);
                $data['employee_id']=$empid;
                $data['service_center_commision_id']=$id;
                $data['created_at']=now();
                $commision_item =  DB::table('service_center_commision_items')->insert(array($data));
            }

        }
        return redirect('/servicecommision')->with('info','Commision Modified Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $commision= ServiceCenterCommision::find($id);
        $slip_exists=Slip::where('salary_month_id','=',$commision->salary_month_id)->where('is_paid','=',1)->get();
        if(count($slip_exists)>0){
            return redirect('/servicecommision')->with('error_delete',' This Commision cannot delete ');
        }else{
            DB::table('service_center_commision_items')->where('service_center_commision_id','=',$id)->delete();
            DB::table('service_center_commisions')->where('id','=',$id)->delete();  
            return redirect('/servicecommision')->with('info','Commision Deleted Successfully');
            
        }
    }
}
