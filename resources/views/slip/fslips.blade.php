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

<script type="text/javascript">
$(document).ready(function() {
    $('#example').DataTable( {
        dom: 'Bfrtip',
        buttons: [
             'csv', 'excel'
        ],
        scrollX: true
    });
} );
</script>
</nav>
        <div id="page-wrapper">
        <div class="col-md-12 graphs">
     <div class="xs">
<h4>Freelance Pay Slip @if(!empty($start_date)){{ "from ".$start_date}} @endif @if(!empty($end_date)){{ "to ". $end_date}} @endif</h4>
@if($errors->any())
  @foreach($errors->all() as $error)
    <div class="alert alert-danger">
      {{ $error }}
    </div>
  @endforeach
@endif
@if(session('info'))
    <div class="alert alert-success">{{Session::get('success')}}</div>
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
      <input type="submit" class="btn btn-primary" name="submit" value="View Slips"  />
    </div>
  </div>
</div>                   

</form>

@if(!empty($salary_month))
@include('slip.add_slip_features')

<table id="example" class="display" width="100%" border="1" >
    <thead>
      <tr>
        <td><b>Employee Name</b></td>
        <td><b>Worked Days</b></td>
        <td><b>Salary Per Day</b></td>
        <td><b>Total Amount</b></td>
        <td><b>OT Hours</b></td>
        <td><b>OT Pay Per Day</b></td>
        <td><b>OT Amount</b></td>
        <td><b>Commisions</b></td>
        <td><b>Other Allowances</b></td>
        <td><b>Total Salary</b></td>
        <td><b>Advance</b></td>
        <td><b>Other Deductions</b></td>
        <td><b>Net Salary</b></td>
        <td><b>Signature</b></td>
        <td><b>Action</b></td>
        
      </tr>
    </thead>
<!-- //GET salary month
    //salary month start to end loop
    // collect on && off entries
    // check nopay leaves and holidays
    // get total worked day

    //get ot hours
    //check if commisions exists for employee +++
    // check  loan exists for employee-->


    <tbody>
   
    @if(!empty($employees))
    @foreach($employees as $employee)
   <?php
   $details=getWorkedDetails($employee,$salary_month_id,$start_date,$end_date);
   $slip=$details['slip'];
   ?>
      <tr>  <!-- salary_month_id, start_date,end_date -->
        <td>{{$employee->name}}</td>
        <td>{{$details['total_worked_days']}}</td>
        <td>{{number_format($slip->per_day_salary,2)}}</td>
        @php 
        if(($slip->employee_salary_type==0)){
         $total=$slip->per_day_salary*$details['total_worked_days']; 
        }else{
          $total=$slip->monthly_salary; 
        }
        @endphp
        <td>{{number_format($total,2) }} </td>
        <td>{{number_format($details['total_ot_hours'],2)}}</td>
        <td>{{$slip->ot_rate}}</td>
        <td>{{number_format($details['total_ot_hours']*($slip->ot_rate),2)}}</td>
        <td>{{number_format($details['total_commision'],2)}}</td>
        <td>{{number_format($details['other_total_allowances'],2)}}</td>
        @php
        $total_salary=$total+($details['total_ot_hours']*($slip->ot_rate))+$details['total_commision']+$details['other_total_allowances'];
        $total_deductions=$details['total_advance']+$details['other_total_deductions'];
        $net_salary=$total_salary-$total_deductions;
        @endphp
        <td>{{number_format($total_salary,2)}}</td>
        <td>{{number_format($details['total_advance'],2)}}</td>
        <td>{{number_format($details['other_total_deductions'],2)}}</td>
        <td>{{number_format($net_salary,2)}}</td>
        <td></td>
        <td>
        @if($details['slip_status']==0)
          <a class="btn btn-warning" href='{{ url("editslip/$employee->id/$salary_month_id") }}'>EDIT</a>
        
        </br>
          <a class="btn btn-primary" href='{{ url("markpaid/$employee->id/$salary_month_id/1") }}'>Mark As Paid</a>
        @else
          <a class="btn btn-primary" href='{{ url("markpaid/$employee->id/$salary_month_id/0") }}'>Mark As Not Paid</a>
        @endif
        <a class="btn btn-warning" href='{{ url("printslip/$employee->id/$salary_month_id") }}'>PRINT</a>
         </td>
      </tr>
      @endforeach
    @endif
    </tbody>
     
</table>
 @endif
 <script type="text/javascript">

$('#employee_name').select2({
      tags: true,
      placeholder: "Select Employee Name for ",
      width: '230px',
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
     