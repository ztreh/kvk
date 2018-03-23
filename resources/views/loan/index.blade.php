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
<h4>Loan List</h4>
@if(session('info'))
    <div class="alert alert-success">{{session('info')}}</div>
@endif  
@if(session('error_delete'))
    <div class="alert alert-danger">{{session('error_delete')}}</div>
@endif  

<table id="example" class="display" width="100%" >
    <thead>
      <tr>
        <td><b>Loan Type</b></td>
        <td><b>Employee Name</b></td>
        <td><b>Loan Amount</b></td>
        <td><b>Number of Installments</b></td>
        <td><b>Loan Interest Percentage</b></td>
        <td><b>Value of a installment</b></td>
        <td><b>Total Amount To Pay</b></td>
        <td><b>Payments Start Date</b></td>
        <td><b>Print</b></td>
        <td><b>Edit</b></td>
        <td><b>Delete</b></td>
      </tr>
    </thead>
    
    <tbody>
    <?php $count=0; 
    ?>
    @foreach($loans->all() as $loan)
    <?php 
    $count++;
    ?>
      <tr>
          <td>{{getColumn('loan_types','name','id',$loan->loan_type_id)}}</td>
          <td>{{getColumn('employees','name','id',$loan->employee_id)}}</td>
          <td>{{number_format($loan->loan_amount,2)}}</td>
          <td>{{$loan->num_of_installments}}</td>
          <td>{{number_format($loan->loan_interest,2)}}</td>
          <td>{{number_format($loan->value_of_a_installment,2)}}</td>
          <td>{{number_format(($loan->value_of_a_installment)*($loan->num_of_installments),2)}}</td>
          <td>{{$loan->payment_start_date}}</td>
         <!--  <td><a class="btn btn-warning" href='{{ url("loan/{$loan->id}") }}'>View</a></td> -->
         <td><a class="btn btn-warning" href='{{ url("loan/{$loan->id}") }}'>Print</a></td>
          <td><a class="btn btn-primary" href='{{ url("loan/{$loan->id}/edit/") }}'>Edit</a></td>
          <td>
              <form action="{{url('loan', [$loan->id])}}" method="POST">
                 {{method_field('DELETE')}}
                 {{csrf_field()}}
                 <input type="submit" class="btn btn-danger" value="Delete"/>
              </form>
          </td>
      </tr>
    @endforeach
    </tbody>
     
</table>

<div class="copy_layout">
      <p><?php //echo $footer_text; ?></p>
  </div>
   </div>
@include('inc.footer')
     