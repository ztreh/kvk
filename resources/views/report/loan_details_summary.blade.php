@include('inc.header')
@include('inc.menu')

<script type="text/javascript">
  $(document).ready(function() {
      $('#example').DataTable({
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
<h4>Loan Summary Report</h4>
@if(session('info'))
    <div class="alert alert-success">{{session('info')}}</div>
@endif       
<table id="example" class="display" width="100%" >
    <thead>
      <tr>
        <th rowspan="2">Employee Name</th>
        <th align="center" colspan="9">Loan Details</th>
      </tr>
      <tr>
        <td><b>Loan Type</b></td>
        <!-- <td><b>Create Date</b></td> -->
        <td><b>Payment Start</b></td>
        <!-- <td><b>Payments End</b></td> -->
        <td><b>Value of a Installment</b></td>
        <td><b>Loan  Interest</b></td>
        <td><b>Total Amount</b></td>
        <td><b>Paid Amount</b></td>
        <td><b>Balance To Paid</b></td>
      </tr>
    </thead>
    
    <tbody>
      @if(!empty($loans))
      @php
        $total_amount=0;
        $total_balance_to_paid=0;
        $total_paid_amount=0;
      @endphp
      @foreach($loans as $loan)
      <tr>
        <td>{{getColumn('employees','name','id',$loan->employee_id)}}</td>
        
        <td>{{getColumn('loan_types','name','id',$loan->loan_type_id)}}</td>
        <!-- <td></td> -->
        <td>{{$loan->payment_start_date}}</td>
        <!-- <td></td> -->
        <td>{{number_format($loan->value_of_a_installment,2)}}</td>
        <td>{{number_format($loan->loan_interest,2).'%'}}</td>
        <td>{{number_format(($loan->value_of_a_installment)*($loan->num_of_installments),2)}}</td>
        <td>@if(isset($loan_payments[$loan->id])){{number_format($loan_payments[$loan->id],2)}}@else {{""}}@endif</td>
        <td>@if(isset($loan_payments[$loan->id])){{number_format(($loan->value_of_a_installment)*($loan->num_of_installments)-$loan_payments[$loan->id],2)}}@else {{""}}@endif</td>
      </tr>
      @php
        $total_amount+=($loan->value_of_a_installment)*($loan->num_of_installments);
        if(isset($loan_payments[$loan->id])){
          $total_paid_amount+=$loan_payments[$loan->id];
          $total_balance_to_paid+=($loan->value_of_a_installment)*($loan->num_of_installments)-$loan_payments[$loan->id];

        }else{
          $total_balance_to_paid+=0;
          $total_paid_amount+=($loan->value_of_a_installment)*($loan->num_of_installments)-0;

        }
      @endphp
      @endforeach
      @endif
    </tbody>
    <tfoot>
      <tr>
        <td></td>
        <td></td>
        <td></td>
        <!-- <td></td>
        <td></td> -->
        <td></td>
        <td></td>
        <td><b>{{number_format($total_amount,2)}}</b></td>
        <td><b>{{number_format($total_paid_amount,2)}}</b></td>
        <td><b>{{number_format($total_balance_to_paid,2)}}</b></td>
      </tr>
    </tfoot>
</table>

<div class="copy_layout">
      <p><?php //echo $footer_text; ?></p>
  </div>
   </div>
@include('inc.footer')
     