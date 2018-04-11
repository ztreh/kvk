@include('inc.header')
@include('inc.menu')

</div>
            <!-- /.navbar-static-side -->
        </nav>
        <div id="page-wrapper">
        <div class="graphs">
       <div class="xs">
<h4>{{$title}} advance</h4>
<form class="form-horizontal" method="post" action="{{url($url)}}">
  @if( ! empty($advance)) {{method_field('PUT')}} @endif
  {{ csrf_field() }}
 <div class="tab-content">
  <div class="tab-pane active" id="horizontal-form">
    
    <div class="form-group">
      <label for="focusedinput" class="col-sm-2 control-label">Advance Amount </label>
      <div class="col-sm-8">
        <input type="text" class="form-control1" name="advance_amount"  id="advance_amount" placeholder="Advance Amount" value="@if(!empty($advance)){{$advance->advance_amount}} @endif"   />
        @if ($errors->has('advance_amount'))
            <span class="help-block error_required">
                <strong>{{ $errors->first('advance_amount') }}</strong>
            </span>
        @endif
      </div>
    </div>
    <div class="form-group">
      <label for="focusedinput" class="col-sm-2 control-label">Workplace Salary Session <span class="error_required"><strong>*</strong></span></label>
      <div class="col-sm-8">
        <select class="form-control1 js-example-basic-single" name="salary_session_work_places_id"  id="salary_session_work_places_id">
          @if(!empty($advance))
              <option value="{{$advance->salary_session_work_places_id}}" selected="selected">{{$advance->salary_session_work_place_details }}</option>
          @endif
        </select>
        
        @if ($errors->has('salary_session_work_places_id'))
                <span class="help-block error_required">
                    <strong>Enter Workplace  Salary Session </strong>
                </span>
            @endif
      </div>
    </div>


    <div class="form-group">
      <label for="focusedinput" class="col-sm-2 control-label">Employee Name </label>
      <div class="col-sm-8">
        <select class="form-control1 js-example-basic-single" name="employees_id"  id="employees_id" >
          @if(!empty($advance))<option value="{{$advance->employees_id}}"  selected="selected">{{$advance->employee_name }}</option>@endif
        </select>
        @if ($errors->has('employees_id'))
            <span class="help-block error_required">
                <strong>Employee Name is required </strong>
            </span>
        @endif
      </div>
    </div>
  </div>
</div> 
             
<div class="panel-footer"> 
  <div class="row">
    <div class="col-sm-8 col-sm-offset-2">
      <input type="submit" class="btn btn-primary" name="register" value="{{$title}} Advance"  />
      <input type="reset" name="reset" class="btn-inverse btn" value="Reset" />
    </div>
  </div>
</div>           

</form>

<script>
  $('#employees_id').select2({
      tags: true,
      placeholder: "Select Employee Name ",
      minimumInputLength: 1,
      ajax: {
          url: '{{url("autocomplete/employees/1")}}',
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

  @include('scripts.workplace_salary_session')
  
    </script>
  </div>
  </div>
  <div class="copy_layout">
      <p></p>
  </div>
  </div>
@include('inc.footer')
