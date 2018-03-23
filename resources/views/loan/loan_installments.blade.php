@include('inc.header')
@include('inc.menu')


<script type="text/javascript">

$(function() {
    $("#from").datepicker();
});
$(function() {
    $("#to").datepicker();
});

$(document).ready(function() {
    $('#example').DataTable( );
} );
</script>
</nav>
        <div id="page-wrapper">
        <div class="col-md-12 graphs">
     <div class="xs">
<h4>Loan Installment Details</h4>
@if(session('info'))
    <div class="alert alert-success">{{session('info')}}</div>
@endif 

<div>
  <table class="table">
    <tr>
      <td><b>Loan Type :   {{getColumn('loan_types','name','id',$loan->loan_type_id)}}</b></td>
    </tr>
    <tr>
      <td><b>Employee Name : {{getColumn('employees','name','id',$loan->employee_id)}}</b></td>
    </tr>
    <tr>
      <td><b>Loan Interest : {{number_format($loan->loan_interest,2)}}%</b></td>
    </tr>
    <tr>
      <td><b>Loan Total Amount : {{number_format($loan->loan_amount,2)}}</b></td>
    </tr>
    <tr>
      <td><b>Payment Start Date : {{$loan->payment_start_date}}</b></td>
    </tr>
  </table>
</div>      
<table id="example" class="display" width="100%" >
    <thead>
      <tr>
        <td><b>No</b></td>
        <td align="center"><b>Salary Month</b></td>
        <td><b>Amount</b></td>
        <td><b>Paid</b></td>
        <td><b>Balance</b></td>
        <td><b>Date to be paid </b></td>
      </tr>
    </thead>
    
    <tbody>
    <?php $count=0; 
    ?>
    @foreach($loan_installments->all() as $loan)
    <?php 
    $count++;
    ?>
      <tr> 
          <td>{{$loan->installment_no}}</td>
          <td align="center">@if($loan->salary_month_id==0){{"-"}} @else{{$loan->salary_month_id}} @endif</td>
          <td>{{$loan->installment_amount}}</td>
          <td>{{$loan->paid_amount}}</td>
          <td>{{$loan->balance_amount}}</td>
          <td>{{$loan->pay_date}}</td>
      </tr>
    @endforeach
    </tbody>
     
</table>

<div class="copy_layout">
      <p><?php //echo $footer_text; ?></p>
  </div>
   </div>
@include('inc.footer')
     