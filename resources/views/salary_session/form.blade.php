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
            var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
            var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();

            $("#year").val(year);
            $("#month").val(parseInt(month)+1);
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
<h4>{{$title}} Salary Session</h4>

<form class="form-horizontal" method="post" action="{{url($url)}}">
  @if( ! empty($salary_session)) {{method_field('PUT')}} @endif
  {{ csrf_field() }}
 <div class="tab-content">
  <div class="tab-pane active" id="horizontal-form">

    <div class="form-group ">
    <label for="focusedinput" class="col-sm-2 control-label">Name <span class="error_required"><strong>*</strong></span></label>
      <div class="col-sm-8">
        <input type="text" class="form-control1"  name="name" id="name" placeholder="Name of the Salary Session" value="@if( ! empty($salary_session)){{$salary_session->name}}@elseif(!empty(old('name'))){{old('name')}} @endif"   />
        @if ($errors->has('name'))
                <span class="help-block error_required">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
            @endif
      </div>
    </div>
    <div class="form-group ">
    <label for="focusedinput" class="col-sm-2 control-label">Select Year and Month <span class="error_required"><strong>*</strong></span></label>
      <div class="col-sm-8">
        <input type="text" class="form-control1"  name="salary_year_and_month" id="salary_year_and_month" placeholder="Select Year and Month" value="@if( ! empty($salary_session)){{date('F', strtotime('2001-'.$salary_session->month.'-01')).' '.$salary_session->year}} @elseif(!empty(old('salary_year_and_month'))){{old('salary_year_and_month')}} @endif"   />
        @if ($errors->has('salary_year_and_month'))
                <span class="help-block error_required">
                    <strong>{{ $errors->first('salary_year_and_month') }}</strong>
                </span>
            @endif
        <input type="hidden" name="year"  id="year" value="@if(!empty(old('year'))){{old('year')}} @endif">
        <input type="hidden" name="month"  id="month" value="@if(!empty(old('month'))){{old('month')}} @endif">
      </div>
    </div>
    <div class="form-group ">
      <label for="focusedinput" class="col-sm-2 control-label">Start Date <span class="error_required"><strong>*</strong></span></label>
      <div class="col-sm-8">
        <input type="text" class="form-control1" name="start_date"  id="start_date" placeholder="Starting date of the salary month" value="@if( ! empty($salary_session)) {{$salary_session->start_date}} @elseif(!empty(old('start_date'))){{old('start_date')}} @endif"   />
        @if ($errors->has('start_date'))
                <span class="help-block error_required">
                    <strong>{{ $errors->first('start_date') }}</strong>
                </span>
            @endif
      </div>
    </div>
    <div class="form-group ">
      <label for="focusedinput" class="col-sm-2 control-label">End Date <span class="error_required"><strong>*</strong></span></label>
      <div class="col-sm-8">
        <input type="text" class="form-control1" name="end_date"  id="end_date" placeholder="Ending date of the salary month" value="@if( ! empty($salary_session)) {{$salary_session->end_date}} @elseif(!empty(old('end_date'))){{old('end_date')}} @endif"   />
        @if ($errors->has('end_date'))
                <span class="help-block error_required">
                    <strong>{{ $errors->first('end_date') }}</strong>
                </span>
            @endif
      </div>
    </div>
   
    <div class="form-group ">
      <label for="focusedinput" class="col-sm-2 control-label">Salary Session For <span class="error_required"><strong>*</strong></span></label>
      <div class="col-sm-8">
        <input  type="radio" name="status" value="0" {{ (isset($salary_session) && $salary_session->status == '0') || old('status')== '0' ? 'checked' : '' }}> <span class="control-label">Office</span> &nbsp;
        <input type="radio" name="status" value="1" {{ (isset($salary_session) && $salary_session->status == '1') || old('status')== '1'  ? 'checked' : '' }} ><span class="control-label">Site</span> &nbsp; 
        @if ($errors->has('status'))
                <span class="help-block error_required">
                    <strong>"Salary Session For" is required</strong>
                </span>
            @endif
      </div>
    </div>


  </div>
</div> 
             
<div class="panel-footer"> 
  <div class="row">
    <div class="col-sm-8 col-sm-offset-2">
      <input type="submit" class="btn btn-primary" name="register" value="{{$title}} Salary Session"  />
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