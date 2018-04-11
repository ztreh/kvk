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
<h4>Pay Slip Details  @if(!empty($start_date)){{ "from ".$start_date}} @endif @if(!empty($end_date)){{ "to ". $end_date}} @endif</h4>
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
        <td><b>Over 24/25 Days</b></td>
        <td><b>Allowance Per Day</b></td>
        <td><b>Allowance Total</b></td>
        <td><b>Other Allowances</b></td>
        <td><b>Total Salary</b></td>
        <td><b>Advance</b></td>
        <td><b>Loan</b></td>
        <td><b>Other Deductions</b></td>
        <td><b>Welfare</b></td>
        <td><b>Gross Salary</b></td>
        <td><b>8% E.P.F.</b></td>
        <td><b>12% E.P.F.</b></td>
        <td><b>Total E.P.F.</b></td>
        <td><b>3% E.T.F.</b></td>
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
   ?>
   <?php //print_r($details['slip']);
   // echo $details['slip']->is_paid;
   ?>
      <tr>  <!-- salary_month_id, start_date,end_date -->
        <td>{{$employee->name}}</td>
        <td>{{$details['total_worked_days']}}</td>
        <td>{{number_format($details['slip']->per_day_salary,2)}}</td>
        
        @php 
        if(($details['slip']->employee_salary_type==0)){
         $total=$details['slip']->per_day_salary*$details['total_worked_days']; 
        }else{
          $total=$details['slip']->monthly_salary; 
        }
        @endphp
        <td>{{number_format($total,2) }} </td>
        <td>{{number_format($details['total_ot_hours'],2)}}</td>
        <td>{{$details['slip']->ot_rate}}</td>
        <td>{{number_format($details['total_ot_hours']*($details['slip']->ot_rate),2)}}</td>
        <td>{{number_format($details['total_commision'],2)}}</td>
        <td>{{number_format(($details['slip']->per_day_salary+$details['slip']->allowance_per_day),2)}}</td>
        <td>{{number_format(($details['slip']->allowance_per_day),2)}}</td>
        
        @php 
          $allowance_total=0;
          if($details['total_worked_days']>25){
            if($details['slip']->employee_salary_type==0){
              $allowance_total=$details['slip']->allowance_per_day*$details['total_worked_days'];
            }else{
              $allowance_total=$details['slip']->allowance_per_day;
            }

          }
         @endphp
        <td>{{number_format($allowance_total,2)}}</td>
        <td>{{number_format($details['other_total_allowances'],2)}}</td>
        <td>{{number_format($total+($details['total_ot_hours']*($details['slip']->ot_rate))+$details['total_commision']+$details['other_total_allowances']+$allowance_total,2)}}</td>
        <td>{{number_format($details['total_advance'],2)}}</td>
        <td>{{number_format($details['loan_details'],2)}}</td>
        <td>{{number_format($details['other_total_deductions'],2)}}</td>
        <td>{{number_format(($details['slip']->welfare),2)}}</td>
        @php
        $gross_salary=($total+$allowance_total+($details['total_ot_hours']*($details['slip']->ot_rate))+$details['total_commision']+$details['other_total_allowances'])-($details['total_advance']+$details['other_total_deductions']+$details['slip']->welfare+$details['loan_details']);

        @endphp
        <td>{{number_format($gross_salary,2)}}</td>
        @php
        if($details['slip']->epf_availability==1){
          if($details['total_leaves']>21){
            $epf_8=((($details['slip']->basic_salary+$details['budget_allowance'])/25)*$details['total_worked_days'])*(8/100);
            $epf_12=((($details['slip']->basic_salary+$details['budget_allowance'])/25)*$details['total_worked_days'])*(12/100);
            $etf_3=((($details['slip']->basic_salary+$details['budget_allowance'])/25)*$details['total_worked_days'])*(3/100);
          }else{
            $epf_8=($details['slip']->basic_salary+$details['budget_allowance'])*(8/100);
            $epf_12=($details['slip']->basic_salary+$details['budget_allowance'])*(12/100);
            $etf_3=($details['slip']->basic_salary+$details['budget_allowance'])*(3/100);
          }
          $epf_tot=$epf_8+$epf_12;
          $net_salary=$gross_salary-$epf_8;

        }else{
          $epf_8=0;
          $epf_12=0;
          $etf_3=0;
          $epf_tot=$epf_8+$epf_12;
          $net_salary=$gross_salary;

        }
        
        @endphp
        <td>{{number_format($epf_8,2)}}</td>
        <td>{{number_format($epf_12,2)}}</td>
        <td>{{number_format($epf_tot,2)}}</td>
        <td>{{number_format($etf_3,2)}}</td>
        <td>{{number_format($net_salary,2)}}</td>
        <td></td>
        <td>
          <?php
            $slip=$details['slip'];
          ?>
        @if($details['slip_status']==0)
          <a class="btn btn-warning" href='{{ url("editslip/$employee->id/$salary_month_id") }}'>EDIT</a>
        </br>
          <a class="btn btn-primary" href='{{ url("markpaid/$employee->id/$salary_month_id/1") }}'>Mark As Paid</a>
        @else
          <a class="btn btn-primary" href='{{ url("markpaid/$employee->id/$salary_month_id/0") }}'>Mark As Not Paid</a>
        @endif
        </br>
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
     