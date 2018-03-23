@include('inc.header')
@include('inc.menu')

</div>
            <!-- /.navbar-static-side -->
        </nav>
        <div id="page-wrapper">
        <div class="graphs">
       <div class="xs">
<h4>{{$title}} Slip</h4>
@if($errors->any())
  @foreach($errors->all() as $error)
    <div class="alert alert-danger">
      {{ $error }}
    </div>
  @endforeach
@endif
  {{ csrf_field() }}
  @if( ! empty($leave)) {{method_field('PUT')}} @endif

 <div class="tab-content">
  <div class="tab-pane active" id="horizontal-form">
  	@if(!empty($allowances) && count($allowances)>0)
    <h5>Allowances</h5>
    <table class="table">
    	<thead>
    		<tr>
    			<th>Description</th>
    			<th>Amount</th>
    			<th>Action</th>
    		</tr>
    	</thead>
    	<tbody>
    		@foreach($allowances as $allowance)
    		<tr>
    			<td>{{$allowance->description}}</td>
    			<td>{{$allowance->amount}}</t>
    			<td><a class="btn btn-danger" href='{{ url("deletefeature/$employee_id/$salary_month_id/$allowance->id") }}'>Delete</a></t>
    		</tr>
    		@endforeach
    	</tbody>
    </table>
    @endif
  	@if(!empty($deductions) && count($deductions)>0)

  	<h5>Deductions</h5>
    <table class="table">
    	<thead>
    		<tr>
    			<th>Description</th>
    			<th>Amount</th>
    			<th>Action</th>
    		</tr>
    	</thead>
    	<tbody>
    		@foreach($deductions as $deduction)
    		<tr>
    			<td>{{$deduction->description}}</td>
    			<td>{{$deduction->amount}}</t>
    			<td><a class="btn btn-danger" href='{{ url("deletefeature/$employee_id/$salary_month_id/$deduction->id") }}'>Delete</a></t>
    		</tr>
    		@endforeach
    	</tbody>
    </table>
    @endif

<form class="form-horizontal" method="post" action="{{url($url)}}">
  {{ csrf_field() }}
    <h5>Loan Payments</h5>
   	<div class="form-group ">
      <label for="focusedinput" class="col-sm-2 control-label">Loan Pay Total</label>
      <div class="col-sm-4">
        <input type="text" class="form-control1" name="loan_amount_to_pay"  id="loan_amount_to_pay" placeholder="Loan installment total to be paid up to this month" value="@if(!empty($loan_details)){{$loan_details}} @endif"   />
      </div>
      <div class="col-sm-4 col-sm-offset-2">
      	<input type="submit" class="btn btn-primary" name="register" value="{{$title}} Loan Payment"  />
      </div>
      
    </div>
</form>

    
    
  </div>
</div> 
<!-- <div class="panel-footer"> 
  <div class="row">
  </div>
</div>  -->                
  </div>
  </div>
  <div class="copy_layout">
      <p><?php// echo $footer_text; ?></p>
  </div>
  </div>
@include('inc.footer')
