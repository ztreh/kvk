@include('inc.header')
@include('inc.menu')
<script>
  @include('scripts.start_time')
  @include('scripts.start_date')
  @include('scripts.end_date')
  @include('scripts.end_time')

  $( function() {
    $("#name").autocomplete({
      source: '{{url("autocomplete/holidays/2")}}'
    });
  } );
</script>
</div>
            <!-- /.navbar-static-side -->
        </nav>
        <div id="page-wrapper">
        <div class="graphs">
       <div class="xs">
<h4>{{$title}} Holiday</h4>

<form class="form-horizontal" method="post" action="{{url($url)}}">
  @if( ! empty($holiday)) {{method_field('PUT')}} @endif
  {{ csrf_field() }}
 <div class="tab-content">
  <div class="tab-pane active" id="horizontal-form">
    <div class="form-group ">
      <label for="focusedinput" class="col-sm-2 control-label">Holiday Type </label>
      <div class="col-sm-8">
        <input type="text" class="form-control1" name="name"  id="name" placeholder="Holiday Type" value="@if(!empty($holiday)){{$holiday->holidays->name}} @endif"   />
        @if ($errors->has('name'))
            <span class="help-block error_required">
                <strong>Holiday Type is required</strong>
            </span>
        @endif
      </div>
    </div>
    <div class="form-group">
      <label for="focusedinput" class="col-sm-2 control-label">Workplace Name</label>
      <div class="col-sm-8">
        <select class="form-control1 js-example-basic-single" name="work_places_id"  id="work_places_id">
          @if(!empty($holiday))
              <option value="{{$holiday->work_places->id}}" selected="selected">{{$holiday->work_places->name }}</option>
          @endif
        </select>
        
        @if ($errors->has('work_places_id'))
            <span class="help-block error_required">
                <strong>Enter Workplace Name</strong>
            </span>
        @endif
      </div>
    </div>
    <div class="form-group ">
      <label for="focusedinput" class="col-sm-2 control-label">From </label>
      <div class="col-sm-4">
        <input type="text" class="form-control1" name="start_date"  id="start_date" placeholder="Date" value="@if(!empty($holiday)){{$holiday->start_date}} @endif"   />
        @if ($errors->has('start_date'))
            <span class="help-block error_required">
                <strong>{{$errors->first('start_date') }}</strong>
            </span>
        @endif
      </div>
      <div class="col-sm-4">
        <input type="text" class="form-control1" name="start_time"  id="start_time" placeholder="Time" value="@if(!empty($holiday)){{$holiday->start_time}} @endif"   />
         @if ($errors->has('start_time'))
            <span class="help-block error_required">
                <strong>{{$errors->first('start_time') }}</strong>
            </span>
        @endif
      </div>
    </div>
    <div class="form-group ">
      <label for="focusedinput" class="col-sm-2 control-label">To </label>
      <div class="col-sm-4">
        <input type="text" class="form-control1" name="end_date"  id="end_date" placeholder="Date" value="@if(!empty($holiday)){{$holiday->end_date}} @endif"   />
        @if ($errors->has('end_date'))
            <span class="help-block error_required">
                <strong>{{$errors->first('end_date') }}</strong>
            </span>
        @endif
      </div>
      <div class="col-sm-4">
        <input type="text" class="form-control1" name="end_time"  id="end_time" placeholder="Time" value="@if(!empty($holiday)){{$holiday->end_time}} @endif"   />
        @if ($errors->has('end_time'))
            <span class="help-block error_required">
                <strong>{{$errors->first('end_time') }}</strong>
            </span>
        @endif
      </div>
    </div>

    <div class="form-group ">
      <label for="focusedinput" class="col-sm-2 control-label">Status </label>
      <div class="col-sm-8">
        <select class="form-control1"  name="status" id="status">
          <option value="0" @if(!empty($holiday) && $holiday->status==0) selected @endif >Site</option>
          <option value="1" @if(!empty($holiday) && $holiday->status==1) selected @endif >Office</option>
          <option value="2" @if(!empty($holiday) && $holiday->status==2) selected @endif >Both</option>
        </select>
        @if ($errors->has('status'))
            <span class="help-block error_required">
                <strong>{{$errors->first('status') }}</strong>
            </span>
        @endif
      </div>
    </div>
  </div>
</div> 
             
<div class="panel-footer"> 
  <div class="row">
    <div class="col-sm-8 col-sm-offset-2">
      <input type="submit" class="btn btn-primary" name="register" value="{{$title}} Holiday"  />
      <input type="reset" name="reset" class="btn-inverse btn" value="Reset" />
    </div>
  </div>
</div>           

</form>
  </div>
  </div>
  <div class="copy_layout">
      <p></p>
  </div>
  </div>
  <script type="text/javascript">
    @include('scripts.workplace_name')
  </script>
@include('inc.footer')
