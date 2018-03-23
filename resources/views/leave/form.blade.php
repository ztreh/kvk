@include('inc.header')
@include('inc.menu')
<script>
  $(function() {
    $("#from_date").datepicker();
  });
  $(function() {
    $("#to_date").datepicker();
  });
  
</script>
<script type="text/javascript">
    $( function() {
    $( "#employee_name" ).autocomplete({
      source: '{{url("searchempname")}}'
    });
  } );
</script>
<script type="text/javascript">
  
 
  $(function() {
    $("#to_time").timepicki({
      show_meridian:false,
      max_hour_value:24,
      min_hour_value:0
    });
  });
  $(function() {
    $("#from_time").timepicki({
      show_meridian:false,
      max_hour_value:24,
      min_hour_value:0
    });
  });
</script>
</div>
            <!-- /.navbar-static-side -->
        </nav>
        <div id="page-wrapper">
        <div class="graphs">
       <div class="xs">
<h4>{{$title}} Leave</h4>
@if($errors->any())
  @foreach($errors->all() as $error)
    <div class="alert alert-danger">
      {{ $error }}
    </div>
  @endforeach
@endif
<form class="form-horizontal" method="post" action="{{url($url)}}">
  {{ csrf_field() }}
  @if( ! empty($leave)) {{method_field('PUT')}} @endif

 <div class="tab-content">
  <div class="tab-pane active" id="horizontal-form">

    <div class="form-group ">
    <label for="focusedinput" class="col-sm-2 control-label">Select Leave Type</label>
      <div class="col-sm-8">
        <select class="form-control1"  name="leave_type" id="leave_type">
          <option value="">Select Leave Type</option>
          @foreach($leavetypes->all() as $leavetype)
          
          <option value="{{$leavetype->id}}" @if(!empty($leave) && $leave->leave_type_id==$leavetype->id) selected @endif>{{$leavetype->name}}</option>
          @endforeach

        </select>
      </div>
    </div>
    <div class="form-group ">
      <label for="focusedinput" class="col-sm-2 control-label">Employee Name</label>
      <div class="col-sm-8">
        <input type="text" class="form-control1" name="employee_name"  id="employee_name" placeholder="Name of the employee" value="@if(!empty($employee_name)){{$employee_name->name}} @endif"   />
      </div>
    </div>
    <div class="form-group ">
      <label for="focusedinput" class="col-sm-2 control-label">From </label>
      <div class="col-sm-4">
        <input type="text" class="form-control1" name="from_date"  id="from_date" placeholder="Date" value="@if(!empty($leave)){{$leave->from_date}} @endif"   />
      </div>
      <div class="col-sm-4">
        <input type="text" class="form-control1" name="from_time"  id="from_time" placeholder="Time" value="@if(!empty($leave)){{$leave->from_time}} @endif"   />
      </div>
    </div>
    <div class="form-group ">
      <label for="focusedinput" class="col-sm-2 control-label">To </label>
      <div class="col-sm-4">
        <input type="text" class="form-control1" name="to_date"  id="to_date" placeholder="Date" value="@if(!empty($leave)){{$leave->to_date}} @endif"   />
      </div>
      <div class="col-sm-4">
        <input type="text" class="form-control1" name="to_time"  id="to_time" placeholder="Time" value="@if(!empty($leave)){{$leave->to_time}} @endif"   />
      </div>
    </div>
  </div>
</div> 
<div class="panel-footer"> 
  <div class="row">
    <div class="col-sm-8 col-sm-offset-2">
      <input type="submit" class="btn btn-primary" name="register" value="{{$title}} Leave"  />
      <input type="reset" name="reset" class="btn-inverse btn" value="Reset" />
    </div>
  </div>
</div>                 
</form>
  </div>
  </div>
  <div class="copy_layout">
      <p><?php// echo $footer_text; ?></p>
  </div>
  </div>
@include('inc.footer')
