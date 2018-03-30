@include('inc.header')
@include('inc.menu')
</div>
            <!-- /.navbar-static-side -->
        </nav>
        <div id="page-wrapper">
        <div class="graphs">
       <div class="xs">
<h4>{{$title}} Salary Session Type</h4>
@if(session('info'))
    <div class="alert alert-success">{{session('info')}}</div>
@endif
<form class="form-horizontal" method="post" action="{{url($url)}}">
  @if( ! empty($salary_session_type)) {{method_field('PUT')}} @endif
  {{ csrf_field() }}
 <div class="tab-content">
  <div class="tab-pane active" id="horizontal-form">

    <div class="form-group ">
    <label for="focusedinput" class="col-sm-2 control-label">Name <span class="error_required"><strong>*</strong></span></label>
      <div class="col-sm-8">
        <input type="text" class="form-control1"  name="name" id="name" placeholder="Name of the Salary Session" value="@if( ! empty($salary_session_type)){{$salary_session_type->name}}@elseif(!empty(old('name'))){{old('name')}} @endif"   />
        @if ($errors->has('name'))
                <span class="help-block error_required">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
            @endif
      </div>
    </div>
    </div>
  </div>
</div> 
             
<div class="panel-footer"> 
  <div class="row">
    <div class="col-sm-8 col-sm-offset-2">
      <input type="submit" class="btn btn-primary" name="register" value="{{$title}} Salary Session Type"  />
      <input type="reset" name="reset" class="btn-inverse btn" value="Reset" />
    </div>
  </div>
</div>           

</form>

<table id="example" class="display" width="100%" >
    <thead>
      <tr>
        <td><b>Salary Session Type</b></td>
        <td><b>Create Date</b></td>
        <td><b>Edit</b></td>
        <td><b>Delete</b></td>
      </tr>
    </thead>
    
    <tbody>
    <?php $count=0; 
    ?>
    @if(!empty($salary_session_types))
    @foreach($salary_session_types->all() as $salary_session_type)
    <?php 
    $count++;
    ?>
      <tr>
          <td>{{ucfirst($salary_session_type->name)}}</td>
          <td>{{($salary_session_type->created_at)}}</td>
          <td><a class="btn btn-primary" href='{{ url("salary_session_type/{$salary_session_type->id}/edit/") }}'>Edit</a></td>
          <td>
              <form action="{{url('salary_session_type', [$salary_session_type->id])}}" method="POST">
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
      </div>
      <!-- /#page-wrapper -->
   </div>
    <!-- /#wrapper -->
<!-- Nav CSS -->
<link href="{{url('css/custom.css')}}" rel="stylesheet">
<!-- Metis Menu Plugin JavaScript -->
<script src="{{url('js/metisMenu.min.js')}}"></script>
<script src="{{url('js/custom.js')}}"></script>
</body>
</html>