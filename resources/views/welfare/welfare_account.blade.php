@include('inc.header')
@include('inc.menu')
<script type="text/javascript">
  
  $(function() {
    $("#date").datepicker();
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
<h4>Welfare Account</h4>
@if($errors->any())
  @foreach($errors->all() as $error)
    <div class="alert alert-danger">
      {{ $error }}
    </div>
  @endforeach
@endif
@include('accounts.manage_account')

<table class="table" border="1" id="example">
  <thead>
    <tr>
      <td colspan="3" align="center">
        <b>Credit</b>
      </td>
      <td colspan="3" align="center">
        <b>Dedit</b>
      </td>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td><b>Date</b></td>
      <td><b>Description</b></td>
      <td><b>Amount</b></td>
      <td><b>Date</b></td>
      <td><b>Description</b></td>
      <td><b>Amount</b></td>
    </tr>
    @php
      $credit_total=0;
      $debit_total=0;
    @endphp
    @foreach($welfare_accounts as $welfare)  
     <tr>
      @if($welfare->type==1)
        @php
          $credit_total+=$welfare->amount;
        @endphp
      <td>{{$welfare->date}}</td>
      <td>{{$welfare->description}}</td>
      <td>{{number_format($welfare->amount,2)}}</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      @elseif($welfare->type==2)
        @php
          $debit_total+=$welfare->amount;
        @endphp
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>{{$welfare->date}}</td>
      <td>{{$welfare->description}}</td>
      <td>{{number_format($welfare->amount,2)}}</td>
      @endif
    </tr>  
    @endforeach
    <tr>
      <td >&nbsp;</td>
      <td >&nbsp;</td>
      <td >&nbsp;</td>
      <td >&nbsp;</td>
      <td >&nbsp;</td>
      <td >&nbsp;</td>
    </tr>
      @if($credit_total>$debit_total)
        
       
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>{{"C/F"}}<?php echo ' ('.date('Y-m-d').')';?></td>
        <td>{{number_format($credit_total-$debit_total,2)}}</td>
      </tr>
      <tr>
        <td>{{date('Y-m-d')}}</td>
        <td>{{'Total'}}</td>
        <td>{{number_format($credit_total,2)}}</td>
        <td>{{date('Y-m-d')}}</td>
        <td>{{'Total'}}</td>
        <td>{{number_format($credit_total,2)}}</td>
       
      </tr>
      @elseif($credit_total<$debit_total)
       
       <tr>
        <td>&nbsp;</td>
        <td>{{"C/F "}}<?php echo ' ('.date('Y-m-d').')';?></td>
        <td>{{number_format($debit_total-$credit_total,2)}}</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>{{date('Y-m-d')}}</td>
        <td>{{'Total'}}</td>
        <td>{{number_format($debit_total,2)}}</td>
        <td>{{date('Y-m-d')}}</td>
        <td>{{'Total'}}</td>
        <td>{{number_format($debit_total,2)}}</td>
      </tr>
      @elseif($credit_total==$debit_total)
        
      <tr>
        <td>&nbsp;</td>
        <td>{{"C/F "}}<?php echo ' ('.date('Y-m-d').')';?></td>
        <td>{{number_format($debit_total-$credit_total,2)}}</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>{{date('Y-m-d')}}</td>
        <td>{{'Total'}}</td>
        <td>{{number_format($debit_total,2)}}</td>
        <td>{{date('Y-m-d')}}</td>
        <td>{{'Total'}}</td>
        <td>{{number_format($debit_total,2)}}</td>
      </tr>
      @endif

   
   
     <!-- <tr>
      <td colspan="6">{{$credit_total}}</td>
    </tr>
    <tr>
      <td colspan="6">{{$debit_total}}</td>
    </tr>   -->
  </tbody>

</table>



<div class="copy_layout">
      <p><?php //echo $footer_text; ?></p>
  </div>
   </div>
@include('inc.footer')
     