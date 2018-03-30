@include('inc.header')
@include('inc.menu')
<script type="text/javascript">
$(document).ready(function() {
    $('#example').DataTable( );
} );
</script>
</div>
            <!-- /.navbar-static-side -->
        </nav>
        <div id="page-wrapper">
        <div class="graphs">
       <div class="xs">
<h4>{{$title}} Device</h4>
@if(session('info'))
    <div class="alert alert-success">{{session('info')}}</div>
@endif 
<form class="form-horizontal" method="post" action="{{url($url)}}">
  @if( ! empty($dvc)) {{method_field('PUT')}} @endif
  {{ csrf_field() }}
 <div class="tab-content">
  <div class="tab-pane active" id="horizontal-form">
    <div class="form-group">
      <label for="focusedinput" class="col-sm-2 control-label">Device Name</label>
      <div class="col-sm-8">
        <input type="text" class="form-control1" name="name"  id="name" placeholder="Device Name" value="@if(!empty($dvc)){{$dvc->name}} @endif"   />
        @if ($errors->has('name'))
            <span class="help-block error_required">
                <strong>{{$errors->first('name')}}</strong>
            </span>
        @endif
      </div>
    </div>
    <div class="form-group">
      <label for="focusedinput" class="col-sm-2 control-label">Workplace Name</label>
      <div class="col-sm-8">
        <select class="form-control1 js-example-basic-single" name="work_places_id"  id="work_places_id">
          @if(!empty($dvc))
              <option value="{{$dvc->work_places_id}}" selected="selected">{{$dvc->work_places->name }}</option>
          @endif
        </select>
        @if ($errors->has('work_places_id'))
            <span class="help-block error_required">
                <strong>{{"Workplace is required"}}</strong>
            </span>
        @endif
      </div>
    </div>
  </div>
</div> 
             
<div class="panel-footer"> 
  <div class="row">
    <div class="col-sm-8 col-sm-offset-2">
      <input type="submit" class="btn btn-primary" name="register" value="{{$title}} Device"  />
      <input type="reset" name="reset" class="btn-inverse btn" value="Reset" />
    </div>
  </div>
</div>           

</form>

<table id="example" class="display" width="100%" >
    <thead>
      <tr>
        <td><b>Device Name</b></td>
        <td><b>Workplace Name</b></td>
        <td><b>Create Date</b></td>
        <td><b>Edit</b></td>
        <td><b>Delete</b></td>
      </tr>
    </thead>
    
    <tbody>
    <?php $count=0; 
    ?>
    @if(!empty($devices))
    @foreach($devices->all() as $device)
    <?php 
    $count++;
    ?>
      <tr>
          <td>{{ucfirst($device->name)}}</td>
          <td>{{ucfirst($device->work_places->name)}}</td>
          <td>{{($device->created_at)}}</td>
          <td><a class="btn btn-primary" href='{{ url("device/{$device->id}/edit/") }}'>Edit</a></td>
          <td>
              <form action="{{url('device', [$device->id])}}" method="POST">
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
