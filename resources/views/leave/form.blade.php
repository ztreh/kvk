@include('inc.header')
@include('inc.menu')

<script>
  @include('scripts.start_time')
  @include('scripts.start_date')
  @include('scripts.end_date')
  @include('scripts.end_time')

  $( function() {
    $("#name").autocomplete({
      source: '{{url("autocomplete/leaves/2")}}'
    });
  } );
</script>
</div>
            <!-- /.navbar-static-side -->
        </nav>
        <div id="page-wrapper">
        <div class="graphs">
       <div class="xs">
<h4>{{$title}} Leave</h4>
@if($errors->any())
  @foreach($errors->all() as $error)
    <div class="alert alert-danger">
      {{ $error }}
    </div>
  @endforeach
@endif
<form class="form-horizontal" method="post" action="{{url($url)}}">
  {{ csrf_field() }}
  @if( ! empty($leave)) {{method_field('PUT')}} @endif

 <div class="tab-content">
  <div class="tab-pane active" id="horizontal-form">

    <div class="form-group ">
    <label for="focusedinput" class="col-sm-2 control-label">Select Leave Type</label>
      <div class="col-sm-8">
        <input type="text" class="form-control1" name="name"  id="name" placeholder="Leave Type" value="@if(!empty($leave)){{$leave->leaves->name}} @endif"   />
      </div>
    </div>
    
    <div class="form-group">
      <label for="focusedinput" class="col-sm-2 control-label">Employee Name</label>
      <div class="col-sm-8">
        <select class="form-control1 js-example-basic-single" name="employees_id"  id="employees_id">
          @if(!empty($leave))
              <option value="{{$leave->employees->id}}"  selected="selected">{{ $leave->employees->name}}</option>
          @endif
        </select>
      </div>
    </div>
    <div class="form-group ">
      <label for="focusedinput" class="col-sm-2 control-label">From </label>
      <div class="col-sm-4">
        <input type="text" class="form-control1" name="start_date"  id="start_date" placeholder="Date" value="@if(!empty($leave)){{$leave->start_date}} @endif"   />
      </div>
      <div class="col-sm-4">
        <input type="text" class="form-control1" name="start_time"  id="start_time" placeholder="Time" value="@if(!empty($leave)){{$leave->start_time}} @endif"   />
      </div>
    </div>
    <div class="form-group ">
      <label for="focusedinput" class="col-sm-2 control-label">To </label>
      <div class="col-sm-4">
        <input type="text" class="form-control1" name="end_date"  id="end_date" placeholder="Date" value="@if(!empty($leave)){{$leave->end_date}} @endif"   />
      </div>
      <div class="col-sm-4">
        <input type="text" class="form-control1" name="end_time"  id="end_time" placeholder="Time" value="@if(!empty($leave)){{$leave->end_time}} @endif"   />
      </div>
    </div>
    <div class="form-group ">
    <label for="focusedinput" class="col-sm-2 control-label">Remarks</label>
      <div class="col-sm-8">
        <input type="text" class="form-control1" name="remarks"  id="remarks" placeholder="Remarks" value="@if(!empty($leave)){{$leave->remarks}} @endif"   />
      </div>
    </div>
  </div>
</div> 
<div class="panel-footer"> 
  <div class="row">
    <div class="col-sm-8 col-sm-offset-2">
      <input type="submit" class="btn btn-primary" name="register" value="{{$title}} Leave"  />
      <input type="reset" name="reset" class="btn-inverse btn" value="Reset" />
    </div>
  </div>
</div>                 
</form>
  </div>
  </div>
  <div class="copy_layout">
      <p><?php// echo $footer_text; ?></p>
  </div>
  </div>
  <script type="text/javascript">
    $('#employees_id').select2({
        tags: true,
        placeholder: "Select Employee Name",
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
   
  </script>
@include('inc.footer')
