@include('inc.header')
@include('inc.menu')
<script>
  $(function() {
    $("#start_date").datepicker();
  });
  $(function() {
    $("#end_date").datepicker();
  });
 </script>
</div>
            <!-- /.navbar-static-side -->
        </nav>
        <div id="page-wrapper">
        <div class="graphs">
       <div class="xs">
<h4>{{$title}} Workplace Salary Session</h4>

<form class="form-horizontal" method="post" action="{{url($url)}}">
  @if( ! empty($workplace)) {{method_field('PUT')}} @endif
  {{ csrf_field() }}
 <div class="tab-content">
  <div class="tab-pane active" id="horizontal-form">
   
    <div class="form-group">
      <label for="focusedinput" class="col-sm-2 control-label">Workplace Name <span class="error_required"><strong>*</strong></span></label>
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
    
    <div class="form-group">
      <label for="focusedinput" class="col-sm-2 control-label">Salary Session <span class="error_required"><strong>*</strong></span></label>
      <div class="col-sm-8">
        <select class="form-control1 js-example-basic-single" name="salary_sessions_id"  id="salary_sessions_id" >
          @if(!empty($workplace_salary_session))
              <option value="{{$workplace_salary_session->salary_sessions_id}}" selected="selected">{{getColumn('salary__sessions','name','id',$workplace_salary_session->salary_sessions_id) }}</option>
          @endif
        </select>
        
        @if ($errors->has('salary_sessions_id'))
            <span class="help-block error_required">
                <strong>Enter Salary Session Name</strong>
            </span>
        @endif
      </div>
    </div>

    <div class="form-group">
      <label for="focusedinput" class="col-sm-2 control-label">Salary Session Type <span class="error_required"><strong>*</strong></span></label>
      <div class="col-sm-8">
        <select class="form-control1 js-example-basic-single" name="salary_session_types_id"  id="salary_session_types_id" >
          @if(!empty($workplace_salary_session))
              <option value="{{$workplace_salary_session->salary_session_types_id}}" selected="selected">{{getColumn('salary__session__types','name','id',$workplace_salary_session->salary_session_types_id) }}</option>
          @endif
        </select>
        
        @if ($errors->has('salary_session_types_id'))
            <span class="help-block error_required">
                <strong>Enter Salary Session Type Name</strong>
            </span>
        @endif
      </div>
    </div>

    <div class="form-group ">
      <label for="focusedinput" class="col-sm-2 control-label">Start Date <span class="error_required"><strong>*</strong></span> </label>
      <div class="col-sm-8">
        <input type="text" class="form-control1" name="start_date"  id="start_date" placeholder="Start Date" value="@if(!empty($workplace_salary_session)){{$workplace_salary_session->start_date}} @elseif(!empty(old('start_date'))){{old('start_date')}} @endif"   />
        @if ($errors->has('start_date'))
            <span class="help-block error_required">
                <strong>{{ $errors->first('start_date') }}</strong>
            </span>
        @endif
      </div>
    </div>
    <div class="form-group ">
      <label for="focusedinput" class="col-sm-2 control-label">End Date <span class="error_required"><strong>*</strong></span> </label>
      <div class="col-sm-8">
        <input type="text" class="form-control1" name="end_date"  id="end_date" placeholder="End Date" value="@if(!empty($workplace_salary_session)){{$workplace_salary_session->end_date}} @elseif(!empty(old('end_date'))){{old('end_date')}} @endif"   />
        @if ($errors->has('end_date'))
            <span class="help-block error_required">
                <strong>{{ $errors->first('end_date') }}</strong>
            </span>
        @endif
      </div>
    </div>
  </div>
</div> 
             
<div class="panel-footer"> 
  <div class="row">
    <div class="col-sm-8 col-sm-offset-2">
      <input type="submit" class="btn btn-primary" name="register" value="{{$title}} Workplace Salary Session"  />
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
    @include('scripts.salary_sessions_name')
    @include('scripts.salary_session_type_name')
  </script>
@include('inc.footer')
