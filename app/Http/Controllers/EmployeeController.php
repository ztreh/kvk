<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Designation;
use App\Employee;
use App\EmployeeImage;
use App\Slip;
use App\Commision_item;
use App\Advance;
use App\Loan;

use Illuminate\Support\Facades\DB;
use File;
use Illuminate\Support\Facades\Storage;
class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employees = DB::table('employees')
            ->join('categories', 'categories.id', '=', 'employees.category_id')
            ->join('designations', 'designations.id', '=', 'employees.designation_id')
            ->select('employees.*', 'categories.name as category_name','designations.name as designation_name')
            ->get();
        $data['employees']=$employees;
        return  view('employee.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['designations']=Designation::all();
        $data['categories']=Category::all();
        $data['title']="Register";
        $data['url']="/employee";
        return  view('employee.form',$data);
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
            'employee_name' => 'required',
            'employee_category' => 'required',
            'employee_designation' => 'required',
            'date_joined' => 'required',
            'finger_print_no' => 'required|unique:employees',
            'basic_salary' => 'required',
            'employee_salary_type' => 'required',
            'work_start_time' => 'required',
            'work_off_time' => 'required',
            'birth_day' => 'required',
        ]);

        $employee=new Employee;
        $employee->name=($request->input('employee_name')!==null) ? $request->input('employee_name') : '' ;
        $employee->birth_day=($request->input('birth_day')!==null) ? $request->input('birth_day') : '' ;
        $employee->address_current=($request->input('address_current')!==null) ? $request->input('address_current')  : '' ;
        
        $employee->address_temperary=($request->input('address_temperary')!==null) ? $request->input('address_temperary')  : '' ;
        $employee->telephone_no_1=($request->input('telephone_no_1')!==null) ? $request->input('telephone_no_1') : '' ;
        $employee->telephone_no_2=($request->input('telephone_no_2')!==null) ? $request->input('telephone_no_2') : '' ;
        $employee->telephone_no_3=($request->input('telephone_no_3')!==null) ? $request->input('telephone_no_3') : '' ;
        $employee->driving_license_no=($request->input('driving_license_no')!==null) ? $request->input('driving_license_no') : '' ;
        $employee->nic_no=($request->input('nic')!==null) ? $request->input('nic') : '' ;
        $employee->category_id=($request->input('employee_category')!==null) ? $request->input('employee_category') : 0 ;
        $employee->designation_id=($request->input('employee_designation')!==null) ? $request->input('employee_designation') : 0 ;
        $employee->date_joined=($request->input('date_joined')!==null) ? $request->input('date_joined') : '' ;
        $employee->finger_print_no=($request->input('finger_print_no')!==null) ? $request->input('finger_print_no') : '' ;
        $employee->basic_salary=($request->input('basic_salary')!==null) ? $request->input('basic_salary')  : '' ;
        $employee->employee_salary_type=($request->input('employee_salary_type')!==null) ? $request->input('employee_salary_type') : '' ;
        $employee->monthly_salary=($request->input('monthly_salary')!==null) ? $request->input('monthly_salary') : 0.00 ;
        $employee->per_day_salary=($request->input('per_day_salary')!==null) ? $request->input('per_day_salary') : 0.00 ;
        $employee->work_start_time=($request->input('work_start_time')!==null) ? $request->input('work_start_time') : '' ;
        $employee->work_off_time=($request->input('work_off_time')!==null) ? $request->input('work_off_time') : '' ;
        $employee->ot_availability=($request->input('ot_availability')!==null) ? $request->input('ot_availability') : '' ;
        $employee->ot_rate=($request->input('ot_rate')!==null) ? $request->input('ot_rate') : 0.00 ;
        $employee->epf_availability=($request->input('epf_availability')!==null) ? $request->input('epf_availability') : '' ;
        $employee->epf_no=($request->input('epf_no')!==null) ? $request->input('epf_no') : '' ;
        $employee->attendance_incentive=($request->input('attendance_incentive')!==null) ? $request->input('attendance_incentive') : 0.00 ;
        $employee->allowance_per_day=($request->input('allowance_per_day')!==null) ? $request->input('allowance_per_day') : 0.00 ;
        $employee->welfare=($request->input('welfare')!==null) ? $request->input('welfare') : 0.00 ;
        $employee->qualification=($request->input('qualification')!==null) ? $request->input('qualification')  : '' ;

        $employee->save();
        return redirect('/employee')->with('info','Employee Registered Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // echo "fhfghfghgh";
        $data['designations']=Designation::all();
        $data['categories']=Category::all();
        $data['employee']=Employee::find($id);
        $data['employee_image']= DB::table('employee_images')
                     ->where('employee_id', '=', $id)
                     ->get();
        $data['url']="/employee/".$data['employee']->id;
        $data['title']="Modify";
        return  view('employee.view',$data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['designations']=Designation::all();
        $data['categories']=Category::all();
        $data['employee']=Employee::find($id);
        $data['url']="/employee/".$data['employee']->id;
        $data['title']="Modify";
        return  view('employee.form',$data);
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
            'employee_name' => 'required',
            'employee_category' => 'required',
            'employee_designation' => 'required',
            'date_joined' => 'required',
            'finger_print_no' => 'required|unique:employees,finger_print_no,'.$id,
            'basic_salary' => 'required',
            'employee_salary_type' => 'required',
            'work_start_time' => 'required',
            'work_off_time' => 'required',
        ]);

        $data['name']=($request->input('employee_name')!==null) ? $request->input('employee_name') : '' ;
        $data['birth_day']=($request->input('birth_day')!==null) ? $request->input('birth_day') : '' ;
        $data['address_current']=($request->input('address_current')!==null) ? $request->input('address_current')  : '' ;
        
        $data['address_temperary']=($request->input('address_temperary')!==null) ? $request->input('address_temperary')  : '' ;
        $data['telephone_no_1']=($request->input('telephone_no_1')!==null) ? $request->input('telephone_no_1') : '' ;
        $data['telephone_no_2']=($request->input('telephone_no_2')!==null) ? $request->input('telephone_no_2') : '' ;
        $data['telephone_no_3']=($request->input('telephone_no_3')!==null) ? $request->input('telephone_no_3') : '' ;
        $data['driving_license_no']=($request->input('driving_license_no')!==null) ? $request->input('driving_license_no') : '' ;
        $data['nic_no']=($request->input('nic')!==null) ? $request->input('nic') : '' ;
        $data['category_id']=($request->input('employee_category')!==null) ? $request->input('employee_category') : 0 ;
        $data['designation_id']=($request->input('employee_designation')!==null) ? $request->input('employee_designation') : 0 ;
        $data['date_joined']=($request->input('date_joined')!==null) ? $request->input('date_joined') : '' ;
        $data['finger_print_no']=($request->input('finger_print_no')!==null) ? $request->input('finger_print_no') : '' ;
        $data['basic_salary']=($request->input('basic_salary')!==null) ? $request->input('basic_salary')  : '' ;
        $data['employee_salary_type']=($request->input('employee_salary_type')!==null) ? $request->input('employee_salary_type') : '' ;
        $data['monthly_salary']=($request->input('monthly_salary')!==null) ? $request->input('monthly_salary') : 0.00 ;
        $data['per_day_salary']=($request->input('per_day_salary')!==null) ? $request->input('per_day_salary') : 0.00 ;
        $data['work_start_time']=($request->input('work_start_time')!==null) ? $request->input('work_start_time') : '' ;
        $data['work_off_time']=($request->input('work_off_time')!==null) ? $request->input('work_off_time') : '' ;
        $data['ot_availability']=($request->input('ot_availability')!==null) ? $request->input('ot_availability') : '' ;
        $data['ot_rate']=($request->input('ot_rate')!==null) ? $request->input('ot_rate') : 0.00 ;
        $data['epf_availability']=($request->input('epf_availability')!==null) ? $request->input('epf_availability') : '' ;
        $data['epf_no']=($request->input('epf_no')!==null) ? $request->input('epf_no') : '' ;
        $data['attendance_incentive']=($request->input('attendance_incentive')!==null) ? $request->input('attendance_incentive') : 0.00 ;
        $data['allowance_per_day']=($request->input('allowance_per_day')!==null) ? $request->input('allowance_per_day') : 0.00 ;
        $data['welfare']=($request->input('welfare')!==null) ? $request->input('welfare') : 0.00 ;
        $data['qualification']=($request->input('qualification')!==null) ? $request->input('qualification')  : '' ;

        Employee::where('id',$id)->update($data);
        return redirect('/employee')->with('info','Employees Modified Successfully');   
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $check_slips=Slip::where('is_paid','=',1)->where('employee_id','=',$id)->get();
        $check_commsions=Commision_item::where('category_or_employee_id','=',$id)->where('status','=',2)->get();
        $check_advances=Advance::where('employee_id','=',$id)->get();
        $check_loan=Loan::where('employee_id','=',$id)->get();
        
        if(count($check_slips)==0 && count($check_commsions)==0 && count($check_advances)==0 && count($check_loan)==0){
            Employee::where('id',$id)->delete();
            return redirect('/employee')->with('info','Employee Deleted Successfully');
            
        }else{
            return redirect('/employee')->with('error_delete',"This Employee can't be deleted"); 

        }

       
    }

    public function uploadImage(Request $request)
    {
        
        $this->validate($request, [
            'image_file' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            'image_name' => 'required'
        ]);

        $image = $request->file('image_file');

        $input['imagename'] = time().'.'.$image->getClientOriginalExtension();

        $destinationPath = public_path('/images/customer_images');
        $image->move($destinationPath, $input['imagename']);

        $employee_image=new EmployeeImage;
        $employee_image->name=($request->input('image_name')!==null) ? $request->input('image_name') : '' ;
        $employee_image->image_file_name=$input['imagename'];
        $employee_image->employee_id=$request->input('id');
        $employee_image->save();
        return redirect("employee/".$request->input('id'))->with('info','Employees Image Uploaded Successfully');   


    }

    public function employeeImageDelete(Request $request)
    {
        
        // 
        if (File::exists(public_path('/images/customer_images/').$request->input('img_file')))
        {
           File::Delete(public_path('/images/customer_images/').$request->input('img_file'));
        }
        EmployeeImage::where('id',$request->input('img_id'))->delete();
        return redirect("employee/".$request->input('emp_id'))->with('info','Image Deleted Successfully'); 
    }
}
