@include('inc.header')
@include('inc.menu')


<script type="text/javascript">
$(document).ready(function() {
    $('#example').DataTable( );
} );
</script>
</nav>
        <div id="page-wrapper">
        <div class="col-md-12 graphs">
     <div class="xs">
<h4>Welfare Account Manage</h4>
@if(session('info'))
    <div class="alert alert-success">{{session('info')}}</div>
@endif 

<table id="example" class="display" width="100%" >
    <thead>
      <tr>
        <td><b>Date</b></td>
        <td><b>Description</b></td>
        <td><b>Credit/Debit</b></td>
        <td><b>Amount</b></td>
        <td><b>Delete</b></td>
      </tr>
    </thead>
    
    <tbody>
    <?php $count=0; 
    ?>
    @foreach($welfare_payments->all() as $welfare_payment)
    <?php 
    $count++;
    ?>
      <tr>
          <td>{{ucfirst($welfare_payment->date)}}</td>
          <td>{{$welfare_payment->description}}</td>
          <td>@if($welfare_payment->type==1) {{'Credit'}} @elseif($welfare_payment->type==2) {{'Debit'}}  @endif </td>
          <td>{{$welfare_payment->amount}}</td>
          <td>
            @if($welfare_payment->status==0)
                <form action="{{url('welfarepaydelete', [$welfare_payment->id])}}" method="POST">
                 <!-- {{method_field('DELETE')}} -->
                 {{csrf_field()}}
                 <input type="submit" class="btn btn-danger" value="Delete"/>
              </form>
            @else

            {{"-"}}

            @endif

              
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
     