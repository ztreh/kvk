@include('inc.header')
@include('inc.menu')
<script type="text/javascript">
  $(function() {
    $( "#salary_year_and_month" ).datepicker({
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
<script>
  $(document).ready(function() {
    $("#commision_value").click(function(){
      setCommsionVal();
    });
  });
  $(document).ready(function() {
    $("#total_amount_to_pay").click(function(){
      setVal();
    });
  });

  $(document).ready(function() {
    $("#calculate_commsions").click(function(){
      setEmployeeCommision();
    });
  });

function setCommsionVal(){
  var value_of_a_commision=parseInt($('#amount_of_sale').val())*(parseInt($('#commision_percentage').val())/100);
    $('#commision_value').val(value_of_a_commision.toFixed(2));
   
}
function calCommision(element) {
  // alert(element.id+" "+element.value);
  var commision_value=parseInt($('#commision_value').val())*((element.value)/100);
  $('#commision_value_'+element.id).val(commision_value.toFixed(2));

}

function setEmployeeCommision(){
  // alert($('#employees_for_commision').val());
  var numberOfEmployees= String($('#employees_for_commision').val());
  // document.getElementById("employee_commisions").innerHTML = numberOfEmployees;

  $.ajax({
    type:"get",
    url: "{{url('getEmployeeNames')}}",
    dataType: 'json', 
    data:{numberOfEmployees:numberOfEmployees},
    success: function(result){
      // JSON.stringify(result)
        // alert(Object.keys(result));
        // alert(Object.values(result));
        var html="";
        for (var key in result) {
        if (result.hasOwnProperty(key)) {
          html+="<div class='form-group'>";
          html+="<label for='focusedinput' class='col-sm-2 control-label'>"+result[key]+"</label>";
          html+=" <div class='col-sm-4'>";
          html+="<input type='text' class='form-control1' name='emp_commsion_percentage_"+key+"'  id='"+key+"' placeholder='Commision Percentage' value='' onblur='calCommision(this)' /><input type='hidden'  name='emp_id[]'  id='emp_id'  value='"+key+"' /></div>";
          
          html+="<div class='col-sm-4'>"
          html+="<input type='text' class='form-control1' name='commision_value_"+key+"'  id='commision_value_"+key+"' placeholder='Commision Value' value=''   />";
          html+="</div>";
          // html+="";
          // html+="";
          html+="</div>";
          
            
        }
      }
        document.getElementById("employee_commisions").innerHTML = html;
    }}); 
}
   
</script>
</div>
            <!-- /.navbar-static-side -->
        </nav>
        <div id="page-wrapper">
        <div class="graphs">
       <div class="xs">
<h4>{{$title}} Service Center Commision</h4>
@if($errors->any())
  @foreach($errors->all() as $error)
    <div class="alert alert-danger">
      {{ $error }}
    </div>
  @endforeach
@endif


<form class="form-horizontal" method="post" action="{{url($url)}}">
  @if( ! empty($commision)) {{method_field('PUT')}} @endif
  {{ csrf_field() }}
 <div class="tab-content">
  <div class="tab-pane active" id="horizontal-form">
    <?php 
    if(!empty($commision)){
      $month=$commision->month;
      $year=$commision->year;
    }
    ?>
    <div class="form-group">
      <label for="focusedinput" class="col-sm-2 control-label">Salary Month</label>
      <div class="col-sm-8">
        <input type="text" class="form-control1" name="salary_year_and_month"  id="salary_year_and_month" placeholder="Salary Month for the Commision" value="@if(!empty($commision)){{  date("F", strtotime("2001-".$month."-01")).' '.$year  }} @endif"   />
      </div>
    </div>
    <div class="form-group">
      <label for="focusedinput" class="col-sm-2 control-label">Job No</label>
      <div class="col-sm-8">
        <input type="text" class="form-control1" name="job_no"  id="job_no" placeholder="Job No" value="@if(!empty($commision)){{$commision->job_no}} @endif"   />
      </div>
    </div>
    <div class="form-group">
      <label for="focusedinput" class="col-sm-2 control-label">Total Amount of the Sale</label>
      <div class="col-sm-8">
        <input type="text" class="form-control1" name="amount_of_sale"  id="amount_of_sale" placeholder="Total Amount of the Sale" value="@if(!empty($commision)){{$commision->sale_amount}} @endif"   />
      </div>
    </div>
    <div class="form-group">
      <label for="focusedinput" class="col-sm-2 control-label">Commision Percentage</label>
      <div class="col-sm-6" style="display: inline">
        <input type="text" class="form-control1" name="commision_percentage"  id="commision_percentage" placeholder="Commision Percentage" value="@if(!empty($commision)){{$commision->commition_percentage}} @endif"   />
      </div><label for="focusedinput" class="col-sm-1 control-label">%</label>
    </div>

    <div class="form-group">
      <label for="focusedinput" class="col-sm-2 control-label">Commision Value</label>
      <div class="col-sm-8">
        <input type="text" class="form-control1" name="commision_value"  id="commision_value" placeholder="Commision Value" value="@if(!empty($commision)){{$commision->commition_value}} @endif"   />
      </div>
    </div>
    
    <div class="form-group">
      <label for="focusedinput" class="col-sm-2 control-label">Employee Names for Commision</label>
      <div class="col-sm-6">
        <select class="form-control1 js-example-basic-multiple" name="employees_for_commision[]"  id="employees_for_commision" multiple="multiple" >
          @if(!empty($commision_items))
            @foreach($commision_items as $items)
              <option value="{{$items->employee_id}}"  selected="selected">{{getColumn('employees','name','id',$items->employee_id) }}</option>
            @endforeach
          @endif
        </select>
      </div>
      <div class="col-sm-1">
        <input type="button"  class="btn btn-primary" id="calculate_commsions" name="calculate_commsions" value="Calculate Commision"   />
      </div>
    </div>
    <div id="employee_commisions" name="employee_commisions">
    @if(!empty($commision_items)) 
       @foreach($commision_items as $items)
        <div class='form-group'>
          <label for='focusedinput' class='col-sm-2 control-label'>{{getColumn('employees','name','id',$items->employee_id) }}</label>
           <div class='col-sm-4'>
          <input type='text' class='form-control1' name='emp_commsion_percentage_{{$items->employee_id}}'  id='{{$items->employee_id}}' placeholder='Commision Percentage' value='{{$items->commition_percentage}}' onblur='calCommision(this)' />
          <input type='hidden'  name='emp_id[]'  id='emp_id'  value='{{$items->employee_id}}' />
        </div>
          
        <div class='col-sm-4'>
          <input type='text' class='form-control1' name='commision_value_{{$items->employee_id}}'  id='commision_value_{{$items->employee_id}}' placeholder='Commision Value' value='{{$items->commision_value}}'   />
          </div>
        </div>       


       @endforeach 
    @endif

    </div>

  </div>
</div> 
             
<div class="panel-footer"> 
  <div class="row">
    <div class="col-sm-8 col-sm-offset-2">
      <input type="submit" class="btn btn-primary" name="register" value="{{$title}} Commision"  />
      <input type="reset" name="reset" class="btn-inverse btn" value="Reset" />
    </div>
  </div>
</div>           

</form>

<script>
  $('#employees_for_commision').select2({
      tags: true,
      placeholder: "Select Employee Names for Commision",
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

  $('#category_for_commision').select2({
      placeholder: "Select Employee Names for Commision",
      minimumInputLength: 1,
      ajax: {
          url: '{{url("deslist")}}',
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
      <p><?php //echo $footer_text; ?></p>
  </div>
  </div>
@include('inc.footer')
