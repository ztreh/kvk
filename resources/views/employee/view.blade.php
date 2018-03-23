@include('inc.header')
@include('inc.menu')

</div>
            <!-- /.navbar-static-side -->
        </nav>
        <div id="page-wrapper">
        <div class="graphs">
       <div class="xs">
<h4>Employee Details</h4>
@if($errors->any())
  @foreach($errors->all() as $error)
    <div class="alert alert-danger">
      {{ $error }}
    </div>
  @endforeach
@endif
@if(session('info'))
    <div class="alert alert-success">{{session('info')}}</div>
@endif   
<table class="table" border="5px solid " BORDERCOLOR="#168aec">
  <tr>
    <td align="center">
      <div class="tab-content">
      <form method='post' class="form-horizontal" action='/employeeImageUpload' enctype="multipart/form-data">
        {{ csrf_field() }}
          <div class="form-group">
            <label for="focusedinput" class="col-sm-2 control-label">Image Name</label>
            <div class="col-sm-6">
              <input type="text" class="form-control1" name="image_name"  id="image_name" placeholder="Image Name" />
            </div>
          </div>

          <div class="form-group">
            <label for="focusedinput" class="col-sm-2 control-label">Select file :</label>
            <div class="col-sm-6">
             <input type='file' name='image_file' id='image_file'>
            </div>
          </div>
          <div class="form-group">
            <input type="hidden" name="id" value="@if(!empty($employee)){{$employee->id}} @endif">
            <input type='submit' class='btn btn-info' value='Upload' id='upload'>
          </div>
      </form>
      </div>
    </td>
  </tr>
</table>


<form class="form-horizontal" method="post" >
 <div class="tab-content">
  <div class="tab-pane active" id="horizontal-form">
    <div class="form-group">
      <label for="focusedinput" class="col-sm-2 control-label">Employee Name</label>
      <div class="col-sm-4">@if(!empty($employee)){{$employee->name}} @endif</div>
      <div class="col-sm-4" align="right">
      </div>
    </div>
    <div class="form-group">
      <label for="focusedinput" class="col-sm-2 control-label">Birth Day</label>
      <div class="col-sm-8">@if(!empty($employee)){{$employee->birth_day}} @endif
        
      </div>
    </div>
    <div class="form-group">
      <label for="focusedinput" class="col-sm-2 control-label">Current Address </label>
      <div class="col-sm-8">@if(!empty($employee)){{$employee->address_current}} @endif
      </div>
    </div>
    <div class="form-group">
      <label for="focusedinput" class="col-sm-2 control-label">Temperary Address</label>
      <div class="col-sm-8">@if(!empty($employee)){{$employee->address_temperary}} @endif
      </div>
    </div>
    <div class="form-group">
      <label for="focusedinput" class="col-sm-2 control-label">Telephone No 1</label>
      <div class="col-sm-8">@if(!empty($employee)){{$employee->telephone_no_1}} @endif
      </div>
    </div>
    <div class="form-group">
      <label for="focusedinput" class="col-sm-2 control-label">Telephone No 2</label>
      <div class="col-sm-8">@if(!empty($employee)){{$employee->telephone_no_2}} @endif
      </div>
    </div>
    <div class="form-group">
      <label for="focusedinput" class="col-sm-2 control-label">Telephone No 3</label>
      <div class="col-sm-8">@if(!empty($employee)){{$employee->telephone_no_3}} @endif
      </div>
    </div>  
    <div class="form-group">
      <label for="focusedinput" class="col-sm-2 control-label">Driving License No</label>
      <div class="col-sm-8">@if(!empty($employee)){{$employee->driving_license_no}} @endif
      </div>
    </div>
    <div class="form-group">
      <label for="focusedinput" class="col-sm-2 control-label">NIC No</label>
      <div class="col-sm-8">@if(!empty($employee)){{$employee->nic_no}} @endif
      </div>
    </div>
    <div class="form-group">
    <label for="focusedinput" class="col-sm-2 control-label">Employee Category</label>
      <div class="col-sm-8">
          @foreach($categories->all() as $categories)
          @if(!empty($employee) && $employee->category_id==$categories->id) {{$categories->name}} @endif
          @endforeach
      </div>
    </div>
    <div class="form-group">
    <label for="focusedinput" class="col-sm-2 control-label">Employee Designation</label>
      <div class="col-sm-8">
          @foreach($designations->all() as $designation)
          @if(!empty($employee) && $employee->designation_id==$designation->id) {{$designation->name}} @endif
          @endforeach
      </div>
    </div>
    <div class="form-group">
      <label for="focusedinput" class="col-sm-2 control-label">Date Joined</label>
      <div class="col-sm-8">@if(!empty($employee)){{$employee->date_joined}} @endif
      </div>
    </div>
    <div class="form-group">
      <label for="focusedinput" class="col-sm-2 control-label">Finger Print No</label>
      <div class="col-sm-8">@if(!empty($employee)){{$employee->finger_print_no}} @endif
      </div>
    </div>
    <div class="form-group">
      <label for="focusedinput" class="col-sm-2 control-label">Basic Salary(Rs.)</label>
      <div class="col-sm-8">@if(!empty($employee)){{$employee->basic_salary}} @endif
      </div>
    </div>

    <div class="form-group">
      <label for="focusedinput" class="col-sm-2 control-label">Salary Type</label>
      <div class="col-sm-8">
        @if(!empty($employee) && $employee->employee_salary_type==0) Daily @endif
        @if(!empty($employee) && $employee->employee_salary_type==1) Monthly @endif
      </div>
    </div>
    <div class="form-group">
      <label for="focusedinput" class="col-sm-2 control-label">Monthly Salary</label>
      <div class="col-sm-8">@if(!empty($employee)){{$employee->monthly_salary}} @endif
      </div>
    </div>
    <div class="form-group">
      <label for="focusedinput" class="col-sm-2 control-label">Daily Salary</label>
      <div class="col-sm-8">@if(!empty($employee)){{$employee->per_day_salary}} @endif
      </div>
    </div>
    <div class="form-group">
      <label for="focusedinput" class="col-sm-2 control-label">Work On Time</label>
      <div class="col-sm-8">@if(!empty($employee)){{$employee->work_start_time}} @endif
      </div>
    </div>
    <div class="form-group">
      <label for="focusedinput" class="col-sm-2 control-label">Work Off Time</label>
      <div class="col-sm-8">@if(!empty($employee)){{$employee->work_off_time}} @endif
      </div>
    </div>
    <div class="form-group">
      <label for="focusedinput" class="col-sm-2 control-label">OT Availability</label>
      <div class="col-sm-8">
        @if(!empty($employee) && $employee->ot_availability==0) Not Availabile @endif 
        @if(!empty($employee) && $employee->ot_availability==1) OT Availabile @endif 
      </div>
    </div>
    <div class="form-group">
      <label for="focusedinput" class="col-sm-2 control-label">OT Rate</label>
      <div class="col-sm-8">@if(!empty($employee)){{$employee->ot_rate}} @endif
      </div>
    </div>
    <div class="form-group">
      <label for="focusedinput" class="col-sm-2 control-label">EPF Available</label>
      <div class="col-sm-8">
        @if(!empty($employee) && $employee->epf_availability==0) Not Availabile @endif
        @if(!empty($employee) && $employee->epf_availability==1) EPF Availabile @endif
      </div>
    </div>
    <div class="form-group">
      <label for="focusedinput" class="col-sm-2 control-label">EPF No</label>
      <div class="col-sm-8">@if(!empty($employee)){{$employee->epf_no}} @endif
      </div>
    </div>
    <div class="form-group">
      <label for="focusedinput" class="col-sm-2 control-label">Attendance Incentive</label>
      <div class="col-sm-8">@if(!empty($employee)){{$employee->attendance_incentive}} @endif
      </div>
    </div>
    <div class="form-group">
      <label for="focusedinput" class="col-sm-2 control-label">Allowance Per Day</label>
      <div class="col-sm-8">@if(!empty($employee)){{$employee->allowance_per_day}} @endif
      </div>
    </div>
    <div class="form-group">
      <label for="focusedinput" class="col-sm-2 control-label">Welfare</label>
      <div class="col-sm-8">@if(!empty($employee)){{$employee->welfare}} @endif
      </div>
    </div>
    <div class="form-group">
      <label for="focusedinput" class="col-sm-2 control-label">Qualifications</label>
      <div class="col-sm-8">@if(!empty($employee)){{$employee->qualification}} @endif
      </div>
    </div>
</form>
    @foreach($employee_image->all() as $image)
    <div class="form-group">
      <label for="focusedinput" class="col-sm-2 control-label">@if(!empty($image)){{$image->name}} @endif</label>

      <div class="col-sm-7"><img class="img-responsive"  src="@if(!empty($image)){{'/images/customer_images/'.$image->image_file_name}} @endif" >
      </div>
      <div class="col-sm-1">
        <form id="@if(!empty($image)){{$image->image_file_name}} @endif" action="{{url('employeeimagedel')}}" method="post">
            {{csrf_field()}}
           <input type="hidden" name="emp_id" value="@if(!empty($employee)){{$employee->id}} @endif"/>
           <input type="hidden" name="img_file" value="{{$image->image_file_name}}"/>
           <input type="hidden" name="img_id" value="{{$image->id}}"/>
           <input type="submit" class="btn btn-danger" value="Delete"/>
        </form>
        
      </div>


    </div>
    @endforeach
  </div>
</div> 


  </div>
  </div>
  <div class="copy_layout">
      <p><?php //echo $footer_text; ?></p>
  </div>
  </div>
@include('inc.footer')
