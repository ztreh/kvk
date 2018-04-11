@include('inc.header')
@include('inc.menu')
<script>
  $(function() {
    $("#from_date").datepicker();
  });
  $(function() {
    $("#to_date").datepicker();
  });

   $(function() {
    $("#to_time").timepicki({
      show_meridian:false,
      max_hour_value:24,
      min_hour_value:0
    });
  });
  $(function() {
    $("#from_time").timepicki({
      show_meridian:false,
      max_hour_value:24,
      min_hour_value:0
    });
  });

   $( function() {
    $( "#employee_name" ).autocomplete({
      source: '{{url("autocomplete/employees/2")}}'
    });
  } );
 </script>
</div>
            <!-- /.navbar-static-side -->
        </nav>
        <div id="page-wrapper">
        <div class="graphs">
       <div class="xs">
<h4>{{$title}} Labour</h4>
@if($errors->any())
  @foreach($errors->all() as $error)
    <div class="alert alert-danger">
      {{ $error }}
    </div>
  @endforeach
@endif
<form class="form-horizontal" method="post" action="{{url($url)}}">
  @if( ! empty($labour)) {{method_field('PUT')}} @endif
  {{ csrf_field() }}
 <div class="tab-content">
  <div class="tab-pane active" id="horizontal-form">
    <div class="form-group">
      <label for="focusedinput" class="col-sm-2 control-label">Employee Name</label>
      <div class="col-sm-8">
        <select class="form-control1 js-example-basic-single" name="employee_name"  id="employee_name">
          @if(!empty($labour))
              <option value="{{$labour->employees_id}}"  selected="selected">{{getColumn('employees','name','id',$labour->employees_id) }}</option>
          @endif
        </select>
      </div>
    </div>
    <div class="form-group">
          <label  class="col-sm-2 control-label">Labour Category</label>
          <div class="col-sm-8">
            <select name="labour_category" class="form-control1" required="">
              <option value="1" @if(!empty($labour) && $labour->is_skill==1) {{"selected"}} @endif>Skilled</option>
              <option value="0" @if(!empty($labour) && $labour->is_skill==0) {{"selected"}} @endif>Unskilled</option>
            </select>
          </div>
        </div>
          <div class="form-group">
            <label  class="col-sm-2 control-label">Expected Rate</label>
            <div class="col-sm-8">
              <input class="form-control1" id="expected_rate_per_day"  name="expected_rate_per_day" placeholder="Expected Rate Per Day" value="@if(!empty($labour)){{$labour->expected_rate}}@endif" type="text">
              <!-- @if ($errors->has('contact_person_name'))
                    <span class="help-block">
                        <strong>{{ $errors->first('contact_person_name') }}</strong>
                    </span>
                @endif -->
            </div>
          </div>
        <div class="form-group ">
          <label  class="col-sm-2 control-label">If skilled mark relevant</label>
          <div class="col-sm-8">
            @if(!empty($skills))
              @foreach($skills as $skill)
                  <div >
                    <label>
                      <input type="checkbox" name="skill_list[]" value="{{$skill->id}}" @if(!empty($labour_skill)) 
                      @foreach($labour_skill as $ls)
                        @if($ls->skill_id == $skill->id)
                          {{"checked"}} 
                        @endif
                      @endforeach
                      @endif >
                      {{$skill->name}}
                    </label>
                  </div>
                @endforeach
              @endif
          </div>
        </div>
      <div col-sm-12 >
        <h4>Recommended Person Details</h4>
      </div>
        <div class="form-group">
          <label for="focusedinput" class="col-sm-2 control-label">Contact Person  Name</label>
          <div class="col-sm-8">
            <select class="form-control1 js-example-basic-single" name="contact_person_name"  id="contact_person_name">
              @if(!empty($labour) && isset($labour->recomended_employee_id) && $labour->recomended_employee_id>0)
                  <option value="{{$labour->recomended_employee_id}}"  selected="selected">{{getColumn('employees','name','id',$labour->recomended_employee_id) }}</option>
              @endif
            </select>
          </div>
        </div>
  </div>
</div> 
             
<div class="panel-footer"> 
  <div class="row">
    <div class="col-sm-8 col-sm-offset-2">
      <input type="submit" class="btn btn-primary" name="register" value="{{$title}} Labour"  />
      <input type="reset" name="reset" class="btn-inverse btn" value="Reset" />
    </div>
  </div>
</div>           

</form>
  </div>
  </div>
  <div class="copy_layout">
      <p><?php //echo $footer_text; ?></p>
  </div>
  </div>
  <script type="text/javascript">
    $('#employee_name').select2({
        tags: true,
        placeholder: "Select Employee Names for Commision",
        minimumInputLength: 1,
        ajax: {
            url: '{{url("autocomplete/emplist")}}',
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
    $('#contact_person_name').select2({
        tags: true,
        placeholder: "Select Contact Person Names ",
        minimumInputLength: 1,
        ajax: {
            url: '{{url("autocomplete/emplist")}}',
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
@include('inc.footer')
