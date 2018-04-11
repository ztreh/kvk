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
      <!-- 'copy', 'csv', 'excel', 'pdf', 'print' -->
<h4>EPF Pay Slip Details  @if(!empty($start_date)){{ "from ".$start_date}} @endif @if(!empty($end_date)){{ "to ". $end_date}} @endif</h4>
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

<table id="example" class="display" width="100%" border="1" >
    <thead>
      <tr>
        <td><b>EPF No</b></td>
        <td><b>Employee Name</b></td>
        <td><b>NIC</b></td>
       <!--  <td><b>Worked Days</b></td>
        <td><b>Basic Salary</b></td>
        <td><b>Budget Allowance</b></td>
        <td><b>Salary For EPF</b></td>
        <td><b>EPF No</b></td> -->
        <td><b>Total EPF</b></td>
        <td><b>EPF 12%</b></td>
        <td><b>EPF 8%</b></td>
        <td><b>ETF 3%</b></td>
        <!-- <td><b>Reimbursment</b></td>
        <td><b>Total Salary</b></td>
        <td><b>Deductions</b></td>
        <td><b>Net Salary</b></td> -->
        <td><b>Signature</b></td>
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
            $net_salary=0;
            
      $slip=$details['slip'];
      if($details['total_worked_days']>0){
        if(($slip->employee_salary_type==0)){
         $total=$slip->per_day_salary*$details['total_worked_days']; 
        }else{
          $total=$slip->monthly_salary; 
        }

        $ot=$details['total_ot_hours']*($slip->ot_rate);
      
        $allowance_total=0;
        if($details['total_worked_days']>25){
          if($slip->employee_salary_type==0){
            $allowance_total=$slip->allowance_per_day*$details['total_worked_days'];
          }else{
            $allowance_total=$slip->allowance_per_day;
          }
        }
        
        $salary_pls_ot_n_allwnc=$total+$ot+$details['total_commision']+$details['other_total_allowances']+$allowance_total;

        $deductions=($details['total_advance']+$details['other_total_deductions']+$slip->welfare+$details['loan_details']);

        $gross_salary=$salary_pls_ot_n_allwnc-$deductions;
        $primary_salary=0;
        if($details['total_leaves']>21){
          $primary_salary=((($slip->basic_salary+$details['budget_allowance'])/25)*$details['total_worked_days']);
          $epf_8=((($slip->basic_salary+$details['budget_allowance'])/25)*$details['total_worked_days'])*(8/100);
          $epf_12=((($slip->basic_salary+$details['budget_allowance'])/25)*$details['total_worked_days'])*(12/100);
          $etf_3=((($slip->basic_salary+$details['budget_allowance'])/25)*$details['total_worked_days'])*(3/100);
        }else{
          $primary_salary=($slip->basic_salary+$details['budget_allowance']);
          $epf_8=($slip->basic_salary+$details['budget_allowance'])*(8/100);
          $epf_12=($slip->basic_salary+$details['budget_allowance'])*(12/100);
          $etf_3=($slip->basic_salary+$details['budget_allowance'])*(3/100);
        }
        $epf_tot=$epf_8+$epf_12;
        if($slip->epf_availability==1){
            $net_salary=$gross_salary-$epf_8;
        }else{
            $net_salary=$gross_salary;
        }
      }
      $reimbersment=$salary_pls_ot_n_allwnc-$primary_salary;
       
          
   ?>
      <tr>  
        <td>{{$employee->epf_no}}</td>
        <td>{{$employee->name}}</td>
        <td>{{$employee->nic_no}}</td>
        <!-- <td>{{$details['total_worked_days']}}</td>
        <td>{{number_format($slip->basic_salary,2)}}</td>
        <td>{{number_format($details['budget_allowance'],2) }} </td>
        <td>{{number_format(($primary_salary),2)}}</td>
        <td>{{$employee->epf_no}}</td> -->
        <td>{{number_format($epf_tot,2)}}</td>
        <td>{{number_format($epf_12,2)}}</td>
        <td>{{number_format(($epf_8),2)}}</td>
        <td>{{number_format($etf_3,2)}}</td>
        <!-- <td>{{number_format($reimbersment,2)}}</td>
        <td>{{number_format($salary_pls_ot_n_allwnc,2)}}</td>
        <td>{{number_format($deductions,2)}}</td>
        <td>{{number_format($net_salary,2)}}</td> -->
        <td></td>
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
     