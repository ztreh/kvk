@include('inc.header')
@include('inc.menu')
<script>
  @include('scripts.start_time')
  @include('scripts.start_date')
  @include('scripts.end_date')
  @include('scripts.end_time')
</script>
</div>
            <!-- /.navbar-static-side -->
        </nav>
        <div id="page-wrapper">
        <div class="graphs">
       <div class="xs">
<h4>{{$title}} Holiday</h4>
@if($errors->any())
  @foreach($errors->all() as $error)
    <div class="alert alert-danger">
      {{ $error }}
    </div>
  @endforeach
@endif
<form class="form-horizontal" method="post" action="{{url($url)}}">
  @if( ! empty($holiday)) {{method_field('PUT')}} @endif
  {{ csrf_field() }}
 <div class="tab-content">
  <div class="tab-pane active" id="horizontal-form">
    <div class="form-group ">
      <label for="focusedinput" class="col-sm-2 control-label">Holiday Type </label>
      <div class="col-sm-8">
        <input type="text" class="form-control1" name=""  id="" placeholder="Holiday Type" value="@if(!empty($holiday)){{'$holiday->'}} @endif"   />
      </div>
    </div>
    <div class="form-group">
      <label for="focusedinput" class="col-sm-2 control-label">Workplace Name</label>
      <div class="col-sm-8">
        <select class="form-control1 js-example-basic-single" name="work_places_id"  id="work_places_id">
          @if(!empty($workplace_salary_session))
              <option value="{{$workplace_salary_session->work_places_id}}" selected="selected">{{$workplace_salary_session->work_places->name }}</option>
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
      </div>
      <div class="col-sm-4">
        <input type="text" class="form-control1" name="start_time"  id="start_time" placeholder="Time" value="@if(!empty($holiday)){{$holiday->start_time}} @endif"   />
      </div>
    </div>
    <div class="form-group ">
      <label for="focusedinput" class="col-sm-2 control-label">To </label>
      <div class="col-sm-4">
        <input type="text" class="form-control1" name="end_date"  id="end_date" placeholder="Date" value="@if(!empty($holiday)){{$holiday->end_date}} @endif"   />
      </div>
      <div class="col-sm-4">
        <input type="text" class="form-control1" name="end_time"  id="end_time" placeholder="Time" value="@if(!empty($holiday)){{$holiday->end_time}} @endif"   />
      </div>
    </div>

    <div class="form-group ">
      <label for="focusedinput" class="col-sm-2 control-label">Status </label>
      <div class="col-sm-8">
        <select class="form-control1"  name="status" id="status">
          <option value="0">Site</option>
          <option value="1">Office</option>
          <option value="2">Both</option>
        </select>
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
