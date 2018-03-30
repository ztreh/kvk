@include('inc.header')
@include('inc.menu')
<script type="text/javascript">
$(document).ready(function() {
    $('#example').DataTable( );
} );
$(function() {
    $("#start_time").timepicki({
      show_meridian:false,
      max_hour_value:24,
      min_hour_value:0
    });
});
$(function() {
    $("#end_time").timepicki({
      show_meridian:false,
      max_hour_value:24,
      min_hour_value:0
    });
});

$( function() {
  $( "#name" ).autocomplete({
    source: '{{url("timeslotname")}}'
  });
} );
</script>

</div>
            <!-- /.navbar-static-side -->
        </nav>
        <div id="page-wrapper">
        <div class="graphs">
       <div class="xs">
<h4>{{$title}} Time Slot</h4>

@if(session('info'))
    <div class="alert alert-success">{{session('info')}}</div>
@endif 
<form class="form-horizontal" method="post" action="{{url($url)}}">
  @if( ! empty($timeslot)) {{method_field('PUT')}} @endif
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
      <label for="focusedinput" class="col-sm-2 control-label">Time Slot Name<span class="error_required"><strong>*</strong></span></label>
      <div class="col-sm-8">
        <input type="text" class="form-control1" name="name"  id="name" placeholder="Time Slot Name" value="@if(!empty($timeslot)){{$timeslot->name}} @endif"   />
        @if ($errors->has('name'))
            <span class="help-block error_required">
                <strong>{{$errors->first('name')}}</strong>
            </span>
        @endif
      </div>
    </div>
    <div class="form-group">
      <label for="focusedinput" class="col-sm-2 control-label">Start Time<span class="error_required"><strong>*</strong></span></label>
      <div class="col-sm-8">
        <input type="text" class="form-control1" name="start_time"  id="start_time" placeholder="Start Time" value="@if(!empty($timeslot)){{$timeslot->start_time}} @endif"   />
        @if ($errors->has('start_time'))
            <span class="help-block error_required">
                <strong>{{$errors->first('start_time')}}</strong>
            </span>
        @endif
      </div>
    </div>
    <div class="form-group">
      <label for="focusedinput" class="col-sm-2 control-label">End Time<span class="error_required"><strong>*</strong></span></label>
      <div class="col-sm-8">
        <input type="text" class="form-control1" name="end_time"  id="end_time" placeholder="End Time" value="@if(!empty($timeslot)){{$timeslot->end_time}} @endif" />
        @if ($errors->has('end_time'))
            <span class="help-block error_required">
                <strong>{{$errors->first('end_time')}}</strong>
            </span>
        @endif
      </div>
    </div>
    <div class="form-group">
      <label for="focusedinput" class="col-sm-2 control-label">Status<span class="error_required"><strong>*</strong></span></label>
      <div class="col-sm-8">
        <select class="form-control1" name="status"  id="status">
          <option value="1" @if(!empty($timeslot)) selected @endif>Active</option>
          <option value="0" @if(!empty($timeslot)) selected @endif>Inactive</option>
        </select>
       
        @if ($errors->has('status'))
            <span class="help-block error_required">
                <strong>{{$errors->first('status')}}</strong>
            </span>
        @endif
      </div>
    </div>
  </div>
</div> 
             
<div class="panel-footer"> 
  <div class="row">
    <div class="col-sm-8 col-sm-offset-2">
      <input type="submit" class="btn btn-primary" name="register" value="{{$title}} Time Slot"  />
      <input type="reset" name="reset" class="btn-inverse btn" value="Reset" />
    </div>
  </div>
</div>           

</form>

<table id="example" class="display" width="100%" >
    <thead>
      <tr>
        <td><b>Name</b></td>
        <td><b>Create Date</b></td>
        <td><b>Edit</b></td>
        <td><b>Delete</b></td>
      </tr>
    </thead>
    
    <tbody>
    <?php $count=0; 
    ?>
    @if(!empty($timeslots))
    @foreach($timeslots->all() as $timeslot)
    <?php 
    $count++;
    ?>
      <tr>
          <td>{{ucfirst($timeslot->name)}}</td>
          <td>{{($timeslot->created_at)}}</td>
          <td><a class="btn btn-primary" href='{{ url("timeslot/{$timeslot->id}/edit/") }}'>Edit</a></td>
          <td>
              <form action="{{url('timeslot', [$timeslot->id])}}" method="POST">
                 {{method_field('DELETE')}}
                 {{csrf_field()}}
                 <input type="submit" class="btn btn-danger" value="Delete"/>
              </form>
          </td>
      </tr>
    @endforeach
    @endif
    </tbody>
     
</table>
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
