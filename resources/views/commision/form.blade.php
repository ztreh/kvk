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

   $(document).ready(function() {
    $("#category_commsions").click(function(){
      setCategoryCommision();
    });
  });

   $(document).ready(function() {
    $("#commision_value").click(function(){
      setCommsionVal();
    });
  });
  
  function setCommsionVal(){
    var value_of_a_commision=parseInt($('#amount_of_sale').val())*(parseInt($('#commision_percentage').val())/100);
      $('#commision_value').val(value_of_a_commision.toFixed(2));
    // onblur='calEmployeeCommision(this,"+key+","+emp_key+")' 
  }

  function deleteEmployee(emp){
    // alert(emp);
    var element = document.getElementById(emp);
    element.parentNode.removeChild(element);
  }
  
  function setCategoryCommision() {
     // alert($('#category_for_commision').val());

  var numberOfCategory= String($('#category_for_commision').val());
  var sal_month=$('#salary_year_and_month').val();
  // document.getElementById("employee_commisions").innerHTML = numberOfEmployees;

  $.ajax({
    type:"get",
    url: "{{url('getCategoryNames')}}",
    dataType: 'json', 
    data:{numberOfCategory:numberOfCategory,sal_month:sal_month},
    success: function(result){
        var cat_name=result.cat_name;
        var emp_name=result.cat_emp_name;
        var workDays=result.cat_emp_worked_days;
        var totworkDays=result.cat_tot_worked_days;
        var html="";
        var wrkHTML="";
        for (var key in cat_name) {

        if (cat_name.hasOwnProperty(key)) {
          html+="<div class='form-group'>";
          html+="<h5 for='focusedinput' align='center' class='col-sm-2 '>"+cat_name[key]+"</h5>";
          html+=" <div class='col-sm-4'>";
          html+="<input type='text' class='form-control1' name='category_percentage_"+key+"'  id='category_percentage_"+key+"' placeholder='Commision Percentage' value='' onblur='calCategoryCommision(this,"+key+")' /></div>";
          html+="<div class='col-sm-4'>"
          html+="<input type='text' class='form-control1' name='catcommision_value_"+key+"'  id='catcommision_value_"+key+"' placeholder='Commision Value' value=''   /><input type='hidden'  name='cat_id[]'  id='cat_id'  value='"+key+"' />";
          html+="</div>";
          // html+="";
          // html+="";
          html+="</div>";
          for (var emp_key in emp_name[key]) {
            if (emp_name[key].hasOwnProperty(emp_key)) {
              html+="<div class='form-group' id='"+key+emp_key+"'>";
              html+="<label for='focusedinput' class='col-sm-2 control-label'>"+emp_name[key][emp_key]+"</label>";
              html+=" <div class='col-sm-2'>";
              html+="<input type='text' class='form-control1' disabled name='worked_days_"+key+"_"+emp_key+"' title='worked days'  id='worked_days_"+key+"_"+emp_key+"' placeholder='Commision Percentage' value='"+workDays[key][emp_key]+"'  /><input type='hidden'  name='worked_days"+key+emp_key+"' id='worked_days"+key+emp_key+"' value='"+workDays[key][emp_key]+"'  /></div>";
              
              html+=" <div class='col-sm-2'>";
              html+="<span title='worked days'>"+workDays[key][emp_key]+"/"+totworkDays[key]+"</span></div>";
              
              html+="<div class='col-sm-2'>"
              html+="<input type='text' class='form-control1' name='empcommision_value_"+key+"_"+emp_key+"'  id='empcommision_value_"+key+"_"+emp_key+"' placeholder='Commision Value' value=''   />";
              html+="</div>";
              html+="<div class='col-sm-2'>"
              html+="<input type='button' class='btn btn-danger' name='delete'  onclick='deleteEmployee("+key+emp_key+")'  value='Delete'   /><input type='hidden'  name='cat_id"+key+"[]'  id='cat_id'  value='"+emp_key+"' />";
              html+="</div>";
              // html+="";
              // html+="";
              html+="</div>";

            }

          } 
            wrkHTML+="<input type='hidden' name='wrkDay_"+key+"' id='wrkDay_"+key+"'    value='"+totworkDays[key]+"'   />";
        }
      }
        document.getElementById("div_category_commisions").innerHTML = html;
        document.getElementById("div_category_total_wrk_days").innerHTML = wrkHTML;
    }}); 
   }

   function calCategoryCommision(element,key) {
    
      
    var commision_value=parseInt($('#commision_value').val())*((element.value)/100);
    $('#catcommision_value_'+key).val(commision_value.toFixed(2));
    
    var emp_ids=document.querySelectorAll("[id^=empcommision_value_"+key+"]");
    var total_work_days=0;
    for (x = 0 ; x < emp_ids.length ; x++){
      var myname = emp_ids[x].getAttribute("id");
      var work_days=myname.split('value_');
      total_work_days+=parseInt($('#worked_days_'+work_days['1']).val());
    }
   
    for (x = 0 ; x < emp_ids.length ; x++){

     var myname = emp_ids[x].getAttribute("id");
     var wrk=myname.split('value_');
    
      var commision_value=parseInt($('#catcommision_value_'+key).val())*parseInt($('#worked_days_'+wrk['1']).val())/total_work_days;
      $('#'+myname).val(commision_value.toFixed(2));
      
    }
  }

  function calEmployeeCommision(element,key,subkey) {
    // alert("commision_value for "+$('#catcommision_value_'+key).val());
    var total_work_days=$('#wrkDay_'+key).val();
    var emp_work_days=$('#worked_days_'+subkey).val();
   
    var commision_value=(emp_work_days/total_work_days)*parseInt($('#catcommision_value_'+key).val());
      
    $('#empcommision_value_'+subkey).val(commision_value.toFixed(2));
    
  }

  
</script>
</div>
            <!-- /.navbar-static-side -->
        </nav>
        <div id="page-wrapper">
        <div class="graphs">
       <div class="xs">
<h4>{{$title}} Total Commision</h4>
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
      <label for="focusedinput" class="col-sm-2 control-label">Employee Category for Commision</label>

      <div class="col-sm-7">
        <select class="form-control1 js-example-basic-multiple" name="category_for_commision[]"  id="category_for_commision" multiple="multiple" >
          @if(!empty($commision_category))
            @foreach($commision_category as $items)
              <option value="{{$items->designation_id}}"  selected="selected">{{ getColumn('designations','name','id',$items->designation_id)}}</option>
            @endforeach
          @endif
        </select>
      </div>
      <div class="col-sm-1">
        <input type="button"  class="btn btn-primary" id="category_commsions" name="category_commsions" value="Category Commision"   />
      </div>
    </div>
    <div id="div_category_commisions" name="div_category_commisions">
      @if(!empty($commision_category))
        @foreach($commision_category as $items)
      <div class='form-group'>
        <h5 for='focusedinput' align='center' class='col-sm-2 '>{{ getColumn('designations','name','id',$items->designation_id)}}</h5>
        <div class='col-sm-4'>
          <input type='text' class='form-control1' name='category_percentage_{{$items->designation_id}}'  id='category_percentage_{{$items->designation_id}}' placeholder='Commision Percentage' value='{{$items->commision_percentage}}' onblur='calCategoryCommision(this,{{$items->designation_id}})' />
        </div>
        <div class='col-sm-4'>
          <input type='text' class='form-control1' name='catcommision_value_{{$items->designation_id}}'  id='catcommision_value_{{$items->designation_id}}' placeholder='Commision Value' value='{{$items->commision_value}}'   />
          <input type='hidden'  name='cat_id[]'  id='cat_id'  value='{{$items->designation_id}}' />
        </div>
       
      </div>
       @if(!empty($commision_category_item))
        @foreach($commision_category_item as $catitem) 
          @if($catitem->commision_category_id==$items->id)        
          <div class='form-group' id='{{$items->designation_id.$catitem->employee_id}}'>
            <label for='focusedinput' class='col-sm-2 control-label'>{{getColumn('employees','name','id',$catitem->employee_id)}}</label>
            <div class='col-sm-2'>
              <input type='text' class='form-control1' disabled name='worked_days_{{$items->designation_id}}_{{$catitem->employee_id}}' title='worked days'  id='worked_days_{{$items->designation_id}}_{{$catitem->employee_id}}' placeholder='Commision Percentage' value='{{$catitem->worked_days}}'  />
              <input type='hidden'  name='worked_days{{$items->designation_id.$catitem->employee_id}}' id='worked_days{{$items->designation_id.$catitem->employee_id}}' value='{{$catitem->worked_days}}'  />
            </div>

            <div class='col-sm-2'>
              <span title='worked days'>{{$catitem->worked_days}}
              </span>
            </div>

            <div class='col-sm-2'>
              <input type='text' class='form-control1' name='empcommision_value_{{$items->designation_id}}_{{$catitem->employee_id}}'  id='empcommision_value_{{$items->designation_id}}_{{$catitem->employee_id}}' placeholder='Commision Value' value='{{$catitem->commision_value}}'   />
            </div>
            <div class='col-sm-2'>
              <input type='button' class='btn btn-danger' name='delete'  onclick='deleteEmployee({{$items->designation_id.$catitem->employee_id}})'  value='Delete'   /><input type='hidden'  name='cat_id{{$items->designation_id}}[]'  id='cat_id'  value='{{$catitem->employee_id}}' />
            </div>
          </div>
          @endif
          @endforeach
        @endif
      @endforeach
    @endif
    </div>

    <div id="div_category_total_wrk_days" name="div_category_total_wrk_days">
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
