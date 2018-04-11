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
        <td><b>Remarks</b></td>
        <td><b>Create Date</b></td>
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
          <td>{{ucfirst($leave->leaves->name)}}</td>
          <td>{{$leave->employees->name}}</td>
          <td>{{$leave->start_date}}</td>
          <td>{{$leave->end_date}}</td>
          <td>{{$leave->start_time}}</td>
          <td>{{$leave->end_time}}</td>
          <td>{{$leave->remarks}}</td>
          <td>{{$leave->created_at}}</td>
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
     