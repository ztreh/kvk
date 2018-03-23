@include('inc.header')
@include('inc.menu')
<script>
  $(function() {
    $( "#salary_year_and_month" ).datepicker({
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
  $(function() {
    $("#start_date").datepicker({
      beforeShow: function(input, inst) {
        $('#ui-datepicker-div').removeClass('hide-calendar');
      } 
    });
  });
  $(function() {
    $("#end_date").datepicker({
      beforeShow: function(input, inst) {
        $('#ui-datepicker-div').removeClass('hide-calendar');
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
<h4>{{$title}} Salary Month</h4>
@if($errors->any())
  @foreach($errors->all() as $error)
    <div class="alert alert-danger">
      {{ $error }}
    </div>
  @endforeach
@endif
<form class="form-horizontal" method="post" action="{{url($url)}}">
  @if( ! empty($salarymonth)) {{method_field('PUT')}} @endif
  {{ csrf_field() }}
 <div class="tab-content">
  <div class="tab-pane active" id="horizontal-form">

    <div class="form-group ">
    <label for="focusedinput" class="col-sm-2 control-label">Select Year and Month</label>
      <div class="col-sm-8">
        <input type="text" class="form-control1"  name="salary_year_and_month" id="salary_year_and_month" placeholder="Select Year and Month" value="@if( ! empty($salarymonth)){{date('F', strtotime('2001-'.$salarymonth->month.'-01')).' '.$salarymonth->year}} @endif"   />
      </div>
    </div>
    <div class="form-group ">
      <label for="focusedinput" class="col-sm-2 control-label">Start Date</label>
      <div class="col-sm-8">
        <input type="text" class="form-control1" name="start_date"  id="start_date" placeholder="Starting date of the salary month" value="@if( ! empty($salarymonth)) {{$salarymonth->start_date}} @endif"   />
      </div>
    </div>
    <div class="form-group ">
      <label for="focusedinput" class="col-sm-2 control-label">End Date</label>
      <div class="col-sm-8">
        <input type="text" class="form-control1" name="end_date"  id="end_date" placeholder="Ending date of the salary month" value="@if( ! empty($salarymonth)) {{$salarymonth->end_date}} @endif"   />
      </div>
    </div>
  </div>
</div> 
             
<div class="panel-footer"> 
  <div class="row">
    <div class="col-sm-8 col-sm-offset-2">
      <input type="submit" class="btn btn-primary" name="register" value="{{$title}} Salary Month"  />
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
      </div>
      <!-- /#page-wrapper -->
   </div>
    <!-- /#wrapper -->
<!-- Nav CSS -->
<link href="{{url('css/custom.css')}}" rel="stylesheet">
<!-- Metis Menu Plugin JavaScript -->
<script src="{{url('js/metisMenu.min.js')}}"></script>
<script src="{{url('js/custom.js')}}"></script>
</body>
</html>