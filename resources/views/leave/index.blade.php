@include('inc.header')
@include('inc.menu')


<script type="text/javascript">

$(function() {
    $("#from").datepicker();
});
$(function() {
    $("#to").datepicker();
});

$(document).ready(function() {
    $('#example').DataTable( );
} );
</script>
</nav>
        <div id="page-wrapper">
        <div class="col-md-12 graphs">
     <div class="xs">
<h4>Leave List</h4>
@if(session('info'))
    <div class="alert alert-success">{{session('info')}}</div>
@endif       
<table id="example" class="display" width="100%" >
    <thead>
      <tr>
        <td><b>Leave Type</b></td>
        <td><b>Employee Name</b></td>
        <td><b>From Date</b></td>
        <td><b>To Date</b></td>
        <td><b>From Time</b></td>
        <td><b>To Time</b></td>
        <td><b>Edit</b></td>
        <td><b>Delete</b></td>
      </tr>
    </thead>
    
    <tbody>
    <?php $count=0; 
    ?>
    @foreach($leaves->all() as $leave)
    <?php 
    $count++;
    ?>
      <tr>
          <td>{{ucfirst($leave->leave_type_name)}}</td>
          <td>{{$leave->employee_name}}</td>
          <td>{{$leave->from_date}}</td>
          <td>{{$leave->to_date}}</td>
          <td>{{$leave->from_time}}</td>
          <td>{{$leave->to_time}}</td>
          <td><a class="btn btn-primary" href='{{ url("leave/{$leave->id}/edit/") }}'>Edit</a></td>
          <td>
              <form action="{{url('leave', [$leave->id])}}" method="POST">
                 {{method_field('DELETE')}}
                 {{csrf_field()}}
                 <input type="submit" class="btn btn-danger" value="Delete"/>
              </form>
          </td>
      </tr>
    @endforeach
    </tbody>
     
</table>

<div class="copy_layout">
      <p><?php //echo $footer_text; ?></p>
  </div>
   </div>
@include('inc.footer')
     