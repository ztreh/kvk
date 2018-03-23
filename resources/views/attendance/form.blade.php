@include('inc.header')
@include('inc.menu')

<script type="text/javascript">
  $(function() {
    $( "#salary_month" ).datepicker({
      changeMonth: true,
      changeYear: true,
      dateFormat: 'MM yy',
      onClose: function(dateText, inst) { 
            $(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, 1));
        },
      beforeShow: function(input, inst) {
        $('#ui-datepicker-div').addClass('hide-calendar');
      }  
    });
  });
</script>
</div>
            <!-- /.navbar-static-side -->
        </nav>
        <div id="page-wrapper">
        <div class="graphs">
       <div class="xs">
<h4>Mark Attendance</h4>
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

<form class="form-horizontal" action="{{url($url)}}" method="post" enctype="multipart/form-data">
{{ csrf_field() }}
 <div class="tab-content">
  <div class="tab-pane active" id="horizontal-form">
    <div class="form-group ">
    <label for="focusedinput" class="col-sm-2 control-label">Select Salary Month</label>
      <div class="col-sm-8">
        <input type="text" class="form-control1"  name="salary_month" id="salary_month" placeholder="Select Year and Month" value=""   />
      </div>
    </div>
   
    <div class="form-group ">
    <label for="focusedinput" class="col-sm-2 control-label">Attendance File</label>
      <div class="col-sm-8">
        <input type="file" class="btn btn-primary" id="attendance_file" name="attendance_file" >
      </div>
    </div>
    
  </div>
</div> 

<div class="panel-footer"> 
  <div class="row">
    <div class="col-sm-8 col-sm-offset-2">
      <input type="submit" class="btn btn-primary" name="register" value="Mark Attendance"  />
      <input type="reset" name="reset" class="btn-inverse btn" value="Reset" />
    </div>
  </div>
</div>                   

</form>
  </div>
  </div>
  <div class="copy_layout">
      <p><?php  //echo $footer_text; ?></p>
  </div>
  </div>
@include('inc.footer')
