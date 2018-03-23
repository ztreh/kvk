@include('inc.header')
@include('inc.menu')
<script>
  $(function() {
    $("#payment_start_date").datepicker();
  });

  $(document).ready(function() {
    $("#value_of_a_installment").click(function(){
      setVal();
    });
  });

  $(document).ready(function() {
    $("#total_amount_to_pay").click(function(){
      setVal();
    });
  });

function setVal(){
  var value_of_a_installment=0;
  var total_amount_to_pay=0;
  if($('#loan_type').val()!=3){
    var value_of_a_installment=(parseInt($('#loan_amount').val())+parseInt($('#loan_amount').val())*(parseInt($('#loan_interest').val())/100))/parseInt($('#number_of_installment').val());
    var total_amount_to_pay=(parseInt($('#loan_amount').val())+parseInt($('#loan_amount').val())*(parseInt($('#loan_interest').val())/100));
    $('#value_of_a_installment').val(value_of_a_installment.toFixed(2));
    $('#total_amount_to_pay').val(total_amount_to_pay.toFixed(2)) ;
  }
  
}
   
</script>


</div>
            <!-- /.navbar-static-side -->
        </nav>
        <div id="page-wrapper">
        <div class="graphs">
       <div class="xs">
<h4>{{$title}} Loan</h4>
@if($errors->any())
  @foreach($errors->all() as $error)
    <div class="alert alert-danger">
      {{ $error }}
    </div>
  @endforeach
@endif
<form class="form-horizontal" method="post" action="{{url($url)}}">
  {{ csrf_field() }}
  @if( ! empty($loan)) {{method_field('PUT')}} @endif

 <div class="tab-content">
  <div class="tab-pane active" id="horizontal-form">

    <div class="form-group ">
    <label for="focusedinput" class="col-sm-2 control-label">Select Loan Type</label>
      <div class="col-sm-8">
        <select class="form-control1"  name="loan_type" id="loan_type">
          <option value="">Select Loan Type</option>
          @foreach($loan_types->all() as $loan_type)
          
          <option value="{{$loan_type->id}}" @if(!empty($loan) && $loan->loan_type_id==$loan_type->id) selected @endif>{{$loan_type->name}}</option>
          @endforeach

        </select>
      </div>
    </div>
    <div class="form-group">
      <label for="focusedinput" class="col-sm-2 control-label">Employee Name </label>
      <div class="col-sm-8">
        <select class="form-control1 js-example-basic-single" name="employee_name"  id="employee_name" >
          <option value="@if(!empty($loan)){{$loan->employee_id}}@endif"  selected="selected">@if(!empty($loan)){{getColumn('employees','name','id',$loan->employee_id)." ".getColumn('employees','nic_no','id',$loan->employee_id) }}@endif</option>
        </select>
      </div>
    </div>

    <div class="form-group">
      <label for="focusedinput" class="col-sm-2 control-label">Loan Amount </label>
      <div class="col-sm-8">
        <input type="text" class="form-control1" name="loan_amount"  id="loan_amount" placeholder="Loan Amount" value="@if(!empty($loan)){{$loan->loan_amount}} @endif"   />
      </div>
    </div>


    <div class="form-group">
      <label for="focusedinput" class="col-sm-2 control-label">Number of Installments </label>
      <div class="col-sm-8">
        <input type="text" class="form-control1" name="number_of_installment"  id="number_of_installment" placeholder="Number of Installments" value="@if(!empty($loan)){{$loan->num_of_installments}} @endif"   />
      </div>
    </div>
    <div class="form-group">
      <label for="focusedinput" class="col-sm-2 control-label">Loan Interest Percentage</label>
      <div class="col-sm-8">
        <input type="text" class="form-control1" name="loan_interest"  id="loan_interest" placeholder="Percentage of the loan interest " value="@if(!empty($loan)){{$loan->loan_interest}} @endif"   />
      </div>
    </div>
    
    <div class="form-group">
      <label for="focusedinput" class="col-sm-2 control-label">Value of a installment </label>
      <div class="col-sm-8">
        <input type="text" class="form-control1" name="value_of_a_installment"  id="value_of_a_installment" placeholder="Value of an installment" value="@if(!empty($loan)){{$loan->value_of_a_installment}} @endif"   />
      </div>
    </div>
   
    <div class="form-group">
      <label for="focusedinput" class="col-sm-2 control-label">Total Amount To Pay</label>
      <div class="col-sm-8">
        <input type="text" class="form-control1" name="total_amount_to_pay"  id="total_amount_to_pay" placeholder="Total Amount To Pay" value="@if(!empty($loan)){{($loan->value_of_a_installment)*($loan->num_of_installments)}} @endif"   />
      </div>
    </div>

    <div class="form-group">
      <label for="focusedinput" class="col-sm-2 control-label">Payments Start Date</label>
      <div class="col-sm-8">
        <input type="text" class="form-control1" name="payment_start_date"  id="payment_start_date" placeholder="Payments Start Date" value="@if(!empty($loan)){{$loan->payment_start_date}} @endif"   />
      </div>
    </div>


    <div class="form-group">
      <label for="focusedinput" class="col-sm-2 control-label">Other Details of Loan</label>
      <div class="col-sm-8">
        <textarea  name="other_details"  id="other_details"  rows="10" cols="70" >@if(!empty($loan)){{$loan->other_details}} @endif</textarea>
      </div>
    </div>
   
  </div>
</div> 
<div class="panel-footer"> 
  <div class="row">
    <div class="col-sm-8 col-sm-offset-2">
      <input type="submit" class="btn btn-primary" name="register" value="{{$title}} Loan"  />
      <input type="reset" name="reset" class="btn-inverse btn" value="Reset" />
    </div>
  </div>
</div>                 
</form>
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
  </div>
  </div>
  <div class="copy_layout">
      <p><?php// echo $footer_text; ?></p>
  </div>
  </div>
@include('inc.footer')
