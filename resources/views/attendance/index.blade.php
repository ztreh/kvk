@include('inc.header')
@include('inc.menu')

<script type="text/javascript">
     $(function() {
        $("#entry_date").datepicker();
      });

    $(function() {
      $("#entry_time").timepicki({
        show_meridian:false,
        max_hour_value:24,
        min_hour_value:0
      });
    });
</script>
<script type="text/javascript">
$(document).ready(function() {
    $('#example').DataTable( {
        "scrollX": true
    });
} );
</script>
</nav>
        <div id="page-wrapper">
        <div class="col-md-12 graphs">
     <div class="xs">
<h4>Attendance Details  @if(!empty($start_date)){{ "from ".$start_date}} @endif @if(!empty($end_date)){{ "to ". $end_date}} @endif</h4>

@if(session('info'))
    <div class="alert alert-success">{{session('info')}}</div>
@endif 
<form class="form-horizontal" action="{{url($url)}}" method="post" enctype="multipart/form-data">
{{ csrf_field() }}
 <div class="tab-content">
  <div class="tab-pane active" id="horizontal-form">
    @include('common.workplace_salary_month')
  </div>
</div> 

<div class="panel-footer"> 
  <div class="row">
    <div class="col-sm-8 col-sm-offset-2">
      <input type="submit" class="btn btn-primary" name="submit" value="View Attendance"  />
    </div>
  </div>
</div>                   

</form>

@if(!empty($salary_month))

<div  style="padding: 30px">
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal" style="float: right;">Add Attendance</button>
</div>



<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add Attendance</h4>
      </div>
      <div class="modal-body">
        <form  method="post" class="form-horizontal" action="{{url($url_add_manual_attendance)}}">
      {{ csrf_field() }}
            <div class="form-group">
                <label class="col-xs-3 control-label">Employee Name</label>
                <div class="col-xs-5">
                    <select class="form-control1 js-example-basic-single" name="employee_name"  id="employee_name" required>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-3 control-label">Date</label>
                <div class="col-xs-5">
                    <input type="text" class="col-sm-4 form-control1" name="entry_date"  id="entry_date" placeholder="Date" value=""  required />
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-3 control-label">Time</label>
                <div class="col-xs-5">
                    <input type="text" class="col-sm-4 timepicker form-control1 " name="entry_time"  id="entry_time" placeholder="Time" value="" required  />
                </div>
            </div>
            <div class="form-group">
                <div class="col-xs-5 col-xs-offset-3">
                    <input type="hidden" name="salary_month_id" id="salary_month_id" value="@if(!empty($salary_month)){{$salary_month_id}}  @endif" />
                    <input type="hidden" name="salary_month" id="salary_month" value="@if(!empty($salary_month)){{$salary_month}}  @endif" />
                    <button type="submit" class="btn btn-primary">Mark Attendance</button>
                </div>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>





<table id="example" class="display" width="100%" border="1" >
    <thead>
      <tr>
        <td><b>Employee Name</b></td>
        @if(!empty($workdays))
          @foreach($workdays as $day)
          <td><b>{{$day}}</b></td>
          @endforeach
        @endif
      </tr>
    </thead>
    
    <tbody>
    <?php $count=0; 
    ?>
    @if(!empty($employees))
    @foreach($employees as $employee)
    <?php 
    $count++;
    ?>
      <tr>
          <td>{{$employee->name}}</td>
          @if(!empty($workdays))
          @foreach($workdays as $day)
          <td><b>{{getAttendanceEntries($employee,$day,$end_date,1)}}</b></td>
          @endforeach
        @endif
      </tr>
      @endforeach
    @endif
    </tbody>
     
</table>
 @endif

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
<div class="copy_layout">
      <p><?php //echo $footer_text; ?></p>
  </div>
   </div>
@include('inc.footer')
     