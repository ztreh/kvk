@include('inc.header')
@include('inc.menu')
<script>
  @include('scripts.start_date')
  @include('scripts.end_date')
</script>
</div>
            <!-- /.navbar-static-side -->
        </nav>
        <div id="page-wrapper">
        <div class="graphs">
       <div class="xs">
<h4>{{$title}} Workplace</h4>
<!-- @if($errors->any())
  @foreach($errors->all() as $error)
    <div class="alert alert-danger">
      {{ $error }}
    </div>
  @endforeach
@endif -->
<form class="form-horizontal" method="post" action="{{url($url)}}">
  @if( ! empty($workplace)) {{method_field('PUT')}} @endif
  {{ csrf_field() }}
 <div class="tab-content">
  <div class="tab-pane active" id="horizontal-form">
   
    <div class="form-group">
      <label for="focusedinput" class="col-sm-2 control-label">Workplace Name <span class="error_required"><strong>*</strong></span></label>
      <div class="col-sm-8">
        <input type="text" class="form-control1" name="name"  id="name" placeholder="Name of the Workplace" value="@if(!empty($workplace)){{$workplace->name}} @elseif(!empty(old('name'))){{old('name')}} @endif"   />
        @if ($errors->has('name'))
                <span class="help-block error_required">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
            @endif
      </div>
    </div>
    
    <div class="form-group">
      <label for="focusedinput" class="col-sm-2 control-label">Address <span class="error_required"><strong>*</strong></span></label>
      <div class="col-sm-8">
        <input type="text" class="form-control1" name="address"  id="address" placeholder="Address" value="@if(!empty($workplace)){{$workplace->address}} @elseif(!empty(old('address'))){{old('address')}} @endif"   />
        @if ($errors->has('address'))
            <span class="help-block error_required">
                <strong>{{ $errors->first('address') }}</strong>
            </span>
        @endif
      </div>
    </div>

    <div class="form-group">
      <label for="focusedinput" class="col-sm-2 control-label">Mobile Number</label>
      <div class="col-sm-8">
        <input type="text" class="form-control1" name="tp_mobile"  id="tp_mobile" placeholder="Mobile Number" value="@if(!empty($workplace)){{$workplace->tp_mobile}} @elseif(!empty(old('tp_mobile'))){{old('tp_mobile')}} @endif"   />
        @if ($errors->has('tp_mobile'))
            <span class="help-block error_required">
                <strong>{{ $errors->first('tp_mobile') }}</strong>
            </span>
        @endif
      </div>
    </div>
    
    <div class="form-group">
      <label for="focusedinput" class="col-sm-2 control-label">Telephone Number</label>
      <div class="col-sm-8">
        <input type="text" class="form-control1" name="tp_land"  id="tp_land" placeholder="Telephone Number" value="@if(!empty($workplace)){{$workplace->tp_land}} @elseif(!empty(old('tp_land'))){{old('tp_land')}} @endif"   />
        @if ($errors->has('tp_land'))
            <span class="help-block error_required">
                <strong>{{ $errors->first('tp_land') }}</strong>
            </span>
        @endif
      </div>
    </div>

    <div class="form-group ">
      <label for="focusedinput" class="col-sm-2 control-label">Start Date <span class="error_required"><strong>*</strong></span> </label>
      <div class="col-sm-8">
        <input type="text" class="form-control1" name="start_date"  id="start_date" placeholder="Start Date" value="@if(!empty($workplace)){{$workplace->start_date}} @elseif(!empty(old('start_date'))){{old('start_date')}} @endif"   />
        @if ($errors->has('start_date'))
            <span class="help-block error_required">
                <strong>{{ $errors->first('start_date') }}</strong>
            </span>
        @endif
      </div>
    </div>
    <div class="form-group ">
      <label for="focusedinput" class="col-sm-2 control-label">End Date </label>
      <div class="col-sm-8">
        <input type="text" class="form-control1" name="end_date"  id="end_date" placeholder="End Date" value="@if(!empty($workplace)){{$workplace->end_date}} @elseif(!empty(old('end_date'))){{old('end_date')}} @endif"   />
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
      <input type="submit" class="btn btn-primary" name="register" value="{{$title}} Workplace"  />
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
@include('inc.footer')
