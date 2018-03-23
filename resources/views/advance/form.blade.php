@include('inc.header')
@include('inc.menu')
<script type="text/javascript">
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
</script>
</div>
            <!-- /.navbar-static-side -->
        </nav>
        <div id="page-wrapper">
        <div class="graphs">
       <div class="xs">
<h4>{{$title}} advance</h4>
@if($errors->any())
  @foreach($errors->all() as $error)
    <div class="alert alert-danger">
      {{ $error }}
    </div>
  @endforeach
@endif


<form class="form-horizontal" method="post" action="{{url($url)}}">
  @if( ! empty($advance)) {{method_field('PUT')}} @endif
  {{ csrf_field() }}
 <div class="tab-content">
  <div class="tab-pane active" id="horizontal-form">
    
    <div class="form-group">
      <label for="focusedinput" class="col-sm-2 control-label">Advance Amount </label>
      <div class="col-sm-8">
        <input type="text" class="form-control1" name="advance_amount"  id="advance_amount" placeholder="Advance Amount" value="@if(!empty($advance)){{$advance->advance_amount}} @endif"   />
      </div>
    </div>
    
    
    <div class="form-group">
      <label for="focusedinput" class="col-sm-2 control-label">Salary Month</label>
      <div class="col-sm-8">
        <input type="text" class="form-control1" name="salary_year_and_month"  id="salary_year_and_month" placeholder="Salary Month for the advance" value='@if(!empty($salary_month)){{ date("F", strtotime("2001-" .$salary_month->month. "-01"))." ".$salary_month->year  }} @endif'   />
      </div>
    </div>
    <div class="form-group">
      <label for="focusedinput" class="col-sm-2 control-label">Employee Name </label>
      <div class="col-sm-8">
        <select class="form-control1 js-example-basic-single" name="employee_name"  id="employee_name" >
          @if(!empty($advance))<option value="{{$advance->employee_id}}"  selected="selected">{{getColumn('employees','name','id',$advance->employee_id)." ".getColumn('employees','nic_no','id',$advance->employee_id) }}</option>@endif
        </select>
      </div>
    </div>
  </div>
</div> 
             
<div class="panel-footer"> 
  <div class="row">
    <div class="col-sm-8 col-sm-offset-2">
      <input type="submit" class="btn btn-primary" name="register" value="{{$title}} Advance"  />
      <input type="reset" name="reset" class="btn-inverse btn" value="Reset" />
    </div>
  </div>
</div>           

</form>

<script>
  $('#employee_name').select2({
       tags: true,
      placeholder: "Select Employee Name ",
      minimumInputLength: 1,
      ajax: {
          url: '{{url("emplist")}}',
          dataType: 'json',
          data: function (params) {
              return {
                  q: $.trim(params.term)
              };
          },
          processResults: function (data) {
              return {
                  results: data
              };
          },
          cache: true
      }
  });

  
    </script>
  </div>
  </div>
  <div class="copy_layout">
      <p><?php //echo $footer_text; ?></p>
  </div>
  </div>
@include('inc.footer')
