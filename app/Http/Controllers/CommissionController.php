<?php

namespace App\Http\Controllers;
use App\Designation;
use App\Employee;
use App\SalaryMonth;
use App\Slip;
use App\Commision;
use App\CommisionCategory;
use App\CommisionCategoryItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $commisions = DB::table('commisions')
            ->join('salary_months', 'salary_months.id', '=', 'commisions.salary_month_id')
            ->select('commisions.*','salary_months.month','salary_months.year' )
            ->get();
      
        $data['commisions']=$commisions;
        return  view('commision.index',$data);

    }

    public function getEmployeeNames(Request $request)
    {
        $emp_id_array=explode(",",$request->numberOfEmployees );
        $emp_name_array=Employee::select('id','name')->get();
        $emp_data_array=array();
        foreach ($emp_name_array as $emp) {
            if(in_array($emp->id, $emp_id_array)){
                $emp_data_array[$emp->id] =$emp->name;
            }
        }

        return \Response::json($emp_data_array);
    }

    public function getCategoryNames(Request $request)
    {
        $cat_id_array=explode(",",$request->numberOfCategory );
        $cat_name_array=Designation::select('id','name')->get();
        $salary_month=$request->sal_month;
        $dates=getStartAndEndDateOfSalaryMonth($salary_month);
        $cat_data_array=array();
        $emp_name_array=array();
        $emp_worked_days_array=array();
        $emp_totworked_days_array=array();
        foreach ($cat_name_array as $cat) {
            if(in_array($cat->id, $cat_id_array)){
                $cat_data_array[$cat->id] =$cat->name;
                $employees=Employee::where('designation_id',$cat->id)->get();
                $total_worked_days=0;
                foreach ($employees as $emp) {
                   $emp_name_array[$cat->id][$emp->id]=$emp->name;
                   $detail=totWorkedDaysDetails($emp,$dates['id'],$dates['end_date'])['total_worked_days'];
                   $emp_worked_days_array[$cat->id][$emp->id]=$detail;
                   $total_worked_days+=$detail;
                }

                $emp_totworked_days_array[$cat->id]=$total_worked_days;
               
            }
        }
        $data['cat_name']=$cat_data_array;
        $data['cat_emp_name']=$emp_name_array;
        $data['cat_emp_worked_days']=$emp_worked_days_array;
        $data['cat_tot_worked_days']=$emp_totworked_days_array;
        return \Response::json($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
   
    public function create()
    {
        $data['title']="Register";
        $data['url']="/commision";
        return  view('commision.form',$data);
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
            'amount_of_sale' => 'required',
            'commision_percentage' => 'required',
            'salary_year_and_month' => 'required',
            'category_for_commision' => 'required',
        ]);
        
    }
    public function store(Request $request)
    {
        $this->validateCommisionDetails($request);
        
        $dates=getStartAndEndDateOfSalaryMonth($request->input('salary_year_and_month'));
        $commision=new Commision;
        $commision->commition_percentage=$request->input('commision_percentage');
        $commision->commition_value=$request->input('commision_value');
        $commision->sale_amount=$request->input('amount_of_sale');
        $commision->salary_month_id=$dates['id'];
        $commision->created_at=now();
        $commision->save();
        $commision_id=$commision->id;
        
        if(is_array($request->input('category_for_commision')) && count($request->input('category_for_commision'))>0){
            foreach ($request->input('category_for_commision') as $key => $value) {
                $commision_category=new CommisionCategory;
                $commision_category->commision_id=$commision_id;
                $commision_category->designation_id=$value;
                $commision_category->commision_percentage=$request->input('category_percentage_'.$value);
                $commision_category->commision_value=$request->input('catcommision_value_'.$value);
                $commision_category->created_at=now();
                $commision_category->save();
                $commision_category_id=$commision_category->id;
                
                if(is_array($request->input('cat_id'.$value)) && count($request->input('cat_id'.$value))>0){
                    foreach ($request->input('cat_id'.$value) as $emp) {
                         
                        $commision_category_item=new CommisionCategoryItem;
                        $commision_category_item->employee_id= $emp;
                        $commision_category_item->commision_category_id= $commision_category_id;
                        $commision_category_item->worked_days= $request->input("worked_days".$value.$emp);
                        $commision_category_item->commision_value= $request->input("empcommision_value_".$value."_".$emp);
                        $commision_category_item->created_at= now();
                        $commision_category_item->save();

                    }
                    
                }
            }
           
       }
        return redirect('/commision')->with('info','Commision Registered Successfully');
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
        $commisions = DB::table('commisions')
            ->where('commisions.id', '=', $id)
            ->join('salary_months', 'salary_months.id', '=', 'commisions.salary_month_id')
            ->select('commisions.*','salary_months.month','salary_months.year' )
            ->first();

        $data['commision']=$commisions;
        $data['commision_category']=DB::table('commision_categories') ->where('commision_id', '=', $id)->get();

        // print_r($data['commision_category']);
        $data['commision_category_item']=DB::table('commision_category_items') 
            ->join('commision_categories', 'commision_categories.id', '=', 'commision_category_items.commision_category_id') 
            ->where('commision_categories.commision_id', '=', $id)
            ->select('commision_category_items.*','commision_categories.id')
            ->get();
        
        $data['url']="/commision/".$id;
        $data['title']="Modify";
        return  view('commision.form',$data);
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

        
        $commision_data=array('commition_percentage'=>$request->input('commision_percentage'),'commition_value'=>$request->input('commision_value'),'sale_amount'=>$request->input('amount_of_sale'),'salary_month_id'=>$dates['id'],'updated_at'=>now());
        Commision::where('id',$id)->update($commision_data);


        if(is_array($request->input('category_for_commision')) && count($request->input('category_for_commision'))>0){
            //commision_categories find --- delete their items
            $commision_category=CommisionCategory::where('commision_id','=',$id)->get();
            foreach ($commision_category as $com) {
                DB::table('commision_category_items')->where('commision_category_id','=',$com->id)->delete();
            }
            DB::table('commision_categories')->where('commision_id','=',$id)->delete();
            

            foreach ($request->input('category_for_commision') as $key => $value) {
                $commision_category=new CommisionCategory;
                $commision_category->commision_id=$id;
                $commision_category->designation_id=$value;
                $commision_category->commision_percentage=$request->input('category_percentage_'.$value);
                $commision_category->commision_value=$request->input('catcommision_value_'.$value);
                $commision_category->created_at=now();
                $commision_category->save();
                $commision_category_id=$commision_category->id;
                
                if(is_array($request->input('cat_id'.$value)) && count($request->input('cat_id'.$value))>0){
                    foreach ($request->input('cat_id'.$value) as $emp) {
                        $commision_category_item=new CommisionCategoryItem;
                        $commision_category_item->employee_id= $emp;
                        $commision_category_item->commision_category_id= $commision_category_id;
                        $commision_category_item->worked_days= $request->input("worked_days".$value.$emp);
                        $commision_category_item->commision_value= $request->input("empcommision_value_".$value."_".$emp);
                        $commision_category_item->created_at= now();
                        $commision_category_item->save();

                    }
                    
                }
            }
        }
        
        return redirect('/commision')->with('info','Commision Registered Successfully'); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $commision= Commision::find($id);
        $slip_exists=Slip::where('salary_month_id','=',$commision->salary_month_id)->where('is_paid','=',1)->get();
        if(count($slip_exists)>0){
            return redirect('/commision')->with('error_delete',' This Commision cannot delete ');

        }else{
            $commision_category=CommisionCategory::where('commision_id','=',$id)->get();
            foreach ($commision_category as $com) {
                DB::table('commision_category_items')->where('commision_category_id','=',$com->id)->delete();
            }
            DB::table('commision_categories')->where('commision_id','=',$id)->delete();
             
            Commision::where('id',$id)->delete();
            return redirect('/commision')->with('info','Commision Deleted Successfully');
            
        }
    }
}
