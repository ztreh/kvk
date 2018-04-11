@include('inc.header')
@include('inc.menu')
<script>
  $(function() {
    $("#date_joined").datepicker();
  });
  $(function() {
    $("#birth_day").datepicker();
  });
  $(function() {
      $("#work_start_time").timepicki({
        show_meridian:false,
        max_hour_value:24,
        min_hour_value:0
      });
  });
  $(function() {
      $("#work_off_time").timepicki({
        show_meridian:false,
        max_hour_value:24,
        min_hour_value:0
      });
  });
  
</script>
<script type="text/javascript">
  function SalaryType(val) {
    if(val.value==1){
      document.getElementById("per_day_salary").value = 0;
      document.getElementById("monthly_salary").disabled = false;
      document.getElementById("per_day_salary").disabled = true;
    }else{
      document.getElementById("monthly_salary").disabled = true;
      document.getElementById("per_day_salary").disabled = false;
      document.getElementById("monthly_salary").value = 0;
    }
   
    // body...
  }
</script>
</div>
            <!-- /.navbar-static-side -->
        </nav>
        <div id="page-wrapper">
        <div class="graphs">
       <div class="xs">
<h4>{{$title}} Employee</h4>
@if($errors->any())
  @foreach($errors->all() as $error)
    <div class="alert alert-danger">
      {{ $error }}
    </div>
  @endforeach
@endif
<form class="form-horizontal" method="post" action="{{url($url)}}">
  @if( ! empty($employee)) {{method_field('PUT')}} @endif
  {{ csrf_field() }}
 <div class="tab-content">
  <div class="tab-pane active" id="horizontal-form">
    <div class="form-group">
      <label for="focusedinput" class="col-sm-2 control-label">Employee Full Name</label>
      <div class="col-sm-8">
        <input type="text" class="form-control1" name="full_name"  id="full_name" placeholder="Employee Name" value="@if(!empty($employee)){{$employee->name}} @endif"   />
      </div>
    </div>
    <div class="form-group">
      <label for="focusedinput" class="col-sm-2 control-label">Employee Name with Initials</label>
      <div class="col-sm-8">
        <input type="text" class="form-control1" name="name_with_ini"  id="name_with_ini" placeholder="Employee Name with Initials" value="@if(!empty($employee)){{$employee->name}} @endif"   />
      </div>
    </div>
    <div class="form-group">
      <label for="focusedinput" class="col-sm-2 control-label">Birth Day</label>
      <div class="col-sm-8">
        <input type="text" class="form-control1" name="dob"  id="dob" placeholder="Birth Day" value="@if(!empty($employee)){{$employee->dob}} @endif"   />
      </div>
    </div>
    <div class="form-group">
      <label for="focusedinput" class="col-sm-2 control-label">Gender</label>
      <div class="col-sm-8">
        <select class="form-control1"  name="gender" id="gender">
          <option value="0" @if(!empty($employee) && $employee->gender==0) selected @endif>Female</option>
          <option value="1" @if(!empty($employee) && $employee->gender==1) selected @endif>Male</option>
        </select>
      </div>
    </div>
    <div class="form-group">
      <label for="focusedinput" class="col-sm-2 control-label">Address</label>
      <div class="col-sm-8">
        <input type="text" class="form-control1" name="address"  id="address" placeholder="Address" value="@if(!empty($employee)){{$employee->address}} @endif"   />
      </div>
    </div>
    <div class="form-group">
      <label for="focusedinput" class="col-sm-2 control-label">Temperary Address</label>
      <div class="col-sm-8">
        <input type="text" class="form-control1" name="address_temperary"  id="address_temperary" placeholder="Temperary Address" value="@if(!empty($employee)){{$employee->address_temperary}} @endif"   />
      </div>
    </div>
    <div class="form-group">
      <label for="focusedinput" class="col-sm-2 control-label">Telephone No</label>
      <div class="col-sm-8">
        <input type="text" class="form-control1" name="tp_home"  id="tp_home" placeholder="Telephone No" value="@if(!empty($employee)){{$employee->tp_home}} @endif"   />
      </div>
    </div>
    <div class="form-group">
      <label for="focusedinput" class="col-sm-2 control-label">Mobile No </label>
      <div class="col-sm-8">
        <input type="text" class="form-control1" name="tp_mobile"  id="tp_mobile" placeholder="Mobile No " value="@if(!empty($employee)){{$employee->tp_mobile}} @endif"   />
      </div>
    </div>
    <div class="form-group">
      <label for="focusedinput" class="col-sm-2 control-label">Telephone No 3</label>
      <div class="col-sm-8">
        <input type="text" class="form-control1" name="telephone_no_3"  id="telephone_no_3" placeholder="Telephone No 3" value="@if(!empty($employee)){{$employee->telephone_no_3}} @endif"   />
      </div>
    </div>  
    <div class="form-group">
      <label for="focusedinput" class="col-sm-2 control-label">Driving License No</label>
      <div class="col-sm-8">
        <input type="text" class="form-control1" name="driving_license_no"  id="driving_license_no" placeholder="Driving License No" value="@if(!empty($employee)){{$employee->driving_license_no}} @endif"   />
      </div>
    </div>
    <div class="form-group">
      <label for="focusedinput" class="col-sm-2 control-label">NIC No</label>
      <div class="col-sm-8">
        <input type="text" class="form-control1" name="nic"  id="nic" placeholder="NIC No" value="@if(!empty($employee)){{$employee->nic_no}} @endif"   />
      </div>
    </div>
    <div class="form-group">
    <label for="focusedinput" class="col-sm-2 control-label">Select Employee Category</label>
      <div class="col-sm-8">
        <select class="form-control1"  name="employee_category" id="employee_category">
          <option value="">Select Employee Category</option>
          @foreach($categories->all() as $categories)
            <option value="{{$categories->id}}" @if(!empty($employee) && $employee->category_id==$categories->id) selected @endif>{{$categories->name}}</option>
          @endforeach
        </select>
      </div>
    </div>
    <div class="form-group">
    <label for="focusedinput" class="col-sm-2 control-label">Select Employee Designation</label>
      <div class="col-sm-8">
        <select class="form-control1"  name="designation_id" id="designation_id">
          <option value="">Select Employee Designation</option>
          @foreach($designations->all() as $designation)
            <option value="{{$designation->id}}" @if(!empty($employee) && $employee->designation_id==$designation->id) selected @endif>{{$designation->name}}</option>
          @endforeach
        </select>
      </div>
    </div>
    <div class="form-group">
      <label for="focusedinput" class="col-sm-2 control-label">Workplace Name</label>
      <div class="col-sm-8">
        <select class="form-control1 js-example-basic-single" name="work_places_id"  id="work_places_id">
          @if(!empty($holiday))
              <option value="{{$holiday->work_places->id}}" selected="selected">{{$holiday->work_places->name }}</option>
          @endif
        </select>
        
        @if ($errors->has('work_places_id'))
            <span class="help-block error_required">
                <strong>Enter Workplace Name</strong>
            </span>
        @endif
      </div>
    </div>
    <div class="form-group">
      <label for="focusedinput" class="col-sm-2 control-label">Date Joined</label>
      <div class="col-sm-8">
        <input type="text" class="form-control1" name="date_joined"  id="date_joined" placeholder="Date Joined" value="@if(!empty($employee)){{$employee->date_joined}} @endif"   />
      </div>
    </div>
    <div class="form-group">
      <label for="focusedinput" class="col-sm-2 control-label">Finger Print No</label>
      <div class="col-sm-8">
        <input type="text" class="form-control1" name="finger_print_no"  id="finger_print_no" placeholder="Finger Print No" value="@if(!empty($employee)){{$employee->finger_print_no}} @endif"   />
      </div>
    </div>
    <div class="form-group">
      <label for="focusedinput" class="col-sm-2 control-label">Basic Salary(Rs.)</label>
      <div class="col-sm-8">
        <input type="text" class="form-control1" name="basic_salary"  id="basic_salary" placeholder="Basic Salary(Rs.)" value="@if(!empty($employee)){{$employee->basic_salary}} @endif"   />
      </div>
    </div>

    <div class="form-group">
      <label for="focusedinput" class="col-sm-2 control-label">Select Salary Type</label>
      <div class="col-sm-8">
        <select class="form-control1"  name="employee_salary_type" id="employee_salary_type" onchange="SalaryType(this)">
          <option value="0" @if(!empty($employee) && $employee->employee_salary_type==0) selected @endif>Daily</option>
          <option value="1" @if(!empty($employee) && $employee->employee_salary_type==1) selected @endif>Monthly</option>
        </select>
      </div>
    </div>
    <div class="form-group">
      <label for="focusedinput" class="col-sm-2 control-label">Monthly Salary</label>
      <div class="col-sm-8">
        <input type="text" class="form-control1" name="monthly_salary"  id="monthly_salary" placeholder="Monthly Salary" value="@if(!empty($employee)){{$employee->monthly_salary}} @endif"   />
      </div>
    </div>
    <div class="form-group">
      <label for="focusedinput" class="col-sm-2 control-label">Daily Salary</label>
      <div class="col-sm-8">
        <input type="text" class="form-control1" name="per_day_salary"  id="per_day_salary" placeholder="Daily Salary" value="@if(!empty($employee)){{$employee->per_day_salary}} @endif"   />
      </div>
    </div>
    <div class="form-group">
      <label for="focusedinput" class="col-sm-2 control-label">Salary Session Type <span class="error_required"><strong>*</strong></span></label>
      <div class="col-sm-8">
        <select class="form-control1 js-example-basic-single" name="salary_session_types_id"  id="salary_session_types_id" >
          @if(!empty($workplace_salary_session))
              <option value="{{$workplace_salary_session->salary_session_types_id}}" selected="selected">{{getColumn('salary__session__types','name','id',$workplace_salary_session->salary_session_types_id) }}</option>
          @endif
        </select>
        
        @if ($errors->has('salary_session_types_id'))
            <span class="help-block error_required">
                <strong>Enter Salary Session Type Name</strong>
            </span>
        @endif
      </div>
    </div>
    <div class="form-group">
      <label for="focusedinput" class="col-sm-2 control-label">Work On Time</label>
      <div class="col-sm-8">
        <input type="text" class="timepicker form-control1 " name="work_start_time"  id="work_start_time" placeholder="Work start time of the employee" value="@if(!empty($employee)){{$employee->work_start_time}} @endif"   />
      </div>
    </div>
    <div class="form-group">
      <label for="focusedinput" class="col-sm-2 control-label">Work Off Time</label>
      <div class="col-sm-8">
        <input type="text" class="form-control1" name="work_off_time"  id="work_off_time" placeholder="Work end time of the employee" value="@if(!empty($employee)){{$employee->work_off_time}} @endif"   />
      </div>
    </div>
    <div class="form-group">
      <label for="focusedinput" class="col-sm-2 control-label">OT Availability</label>
      <div class="col-sm-8">
        <select class="form-control1"  name="ot_availability" id="ot_availability">
          <option value="0" @if(!empty($employee) && $employee->ot_availability==0) selected @endif>Not Availabile</option>
          <option value="1" @if(!empty($employee) && $employee->ot_availability==1) selected @endif>OT Availabile</option>
        </select>
      </div>
    </div>
    <div class="form-group">
      <label for="focusedinput" class="col-sm-2 control-label">OT Rate</label>
      <div class="col-sm-8">
        <input type="text" class="form-control1" name="ot_rate"  id="ot_rate" placeholder="OT Rate" value="@if(!empty($employee)){{$employee->ot_rate}} @endif"   />
      </div>
    </div>
    <div class="form-group">
      <label for="focusedinput" class="col-sm-2 control-label">EPF Available</label>
      <div class="col-sm-8">
        <select class="form-control1"  name="epf_availability" id="epf_availability">
          <option value="0" @if(!empty($employee) && $employee->epf_availability==0) selected @endif>Not Availabile</option>
          <option value="1" @if(!empty($employee) && $employee->epf_availability==1) selected @endif>EPF Availabile</option>
        </select>
      </div>
    </div>
    <div class="form-group">
      <label for="focusedinput" class="col-sm-2 control-label">EPF No</label>
      <div class="col-sm-8">
        <input type="text" class="form-control1" name="epf_no"  id="epf_no" placeholder="EPF No" value="@if(!empty($employee)){{$employee->epf_no}} @endif"   />
      </div>
    </div>
    <div class="form-group">
      <label for="focusedinput" class="col-sm-2 control-label">Attendance Incentive</label>
      <div class="col-sm-8">
      </div>
    </div>
        <input type="hidden" class="form-control1" name="attendance_incentive"  id="attendance_incentive" placeholder="Attendance Incentive" value="@if(!empty($employee)){{$employee->attendance_incentive}} @endif"   />
    <div class="form-group">
      <label for="focusedinput" class="col-sm-2 control-label">Allowance Per Day</label>
      <div class="col-sm-8">
        <input type="text" class="form-control1" name="allowance_per_day"  id="allowance_per_day" placeholder="Allowance Per Day" value="@if(!empty($employee)){{$employee->allowance_per_day}} @endif"   />
      </div>
    </div>
    <div class="form-group">
      <label for="focusedinput" class="col-sm-2 control-label">Welfare</label>
      <div class="col-sm-8">
        <input type="text" class="form-control1" name="welfare"  id="welfare" placeholder="Welfare" value="@if(!empty($employee)){{$employee->welfare}} @endif"   />
      </div>
    </div>
    <div class="form-group">
      <label for="focusedinput" class="col-sm-2 control-label">Qualifications</label>
      <div class="col-sm-8">
        <textarea  name="qualification"  id="qualification"  rows="10" cols="70" >@if(!empty($employee)){{$employee->qualification}} @endif</textarea>
      </div>
    </div>
  </div>
</div> 
             
<div class="panel-footer"> 
  <div class="row">
    <div class="col-sm-8 col-sm-offset-2">
      <input type="submit" class="btn btn-primary" name="register" value="{{$title}} Employee"  />
      <input type="reset" name="reset" class="btn-inverse btn" value="Reset" />
    </div>
  </div>
</div>           

</form>
  </div>
  </div>
  <div class="copy_layout">
      <p><?php //echo $footer_text; ?></p>
  </div>
  </div>
  <script type="text/javascript">
    @include('scripts.workplace_name')
    @include('scripts.salary_session_type_name')
  </script>
@include('inc.footer')
