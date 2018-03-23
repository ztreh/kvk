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
<h4>Holiday List</h4>
@if(session('info'))
    <div class="alert alert-success">{{session('info')}}</div>
@endif       
<table id="example" class="display" width="100%" >
    <thead>
      <tr>
        <td><b>Holiday Type</b></td>
        <td><b>Employee Name</b></td>
        <td><b>From Date</b></td>
        <td><b>From Time</b></td>
        <td><b>To Date</b></td>
        <td><b>To Time</b></td>
        <td><b>Edit</b></td>
        <td><b>Delete</b></td>
      </tr>
    </thead>
    
    <tbody>
    <?php $count=0; 
    ?>
    @foreach($holidays->all() as $holiday)
    <?php 
    $count++;
    ?>
      <tr>
          <td>{{ucfirst($holiday->name)}}</td>
          <td>{{(getEmployeeName($holiday->employee_id))}}</td>
          <td>{{$holiday->from_date}}</td>
          <td>{{$holiday->from_time}}</td>
          <td>{{$holiday->to_date}}</td>
          <td>{{$holiday->to_time}}</td>
          <td><a class="btn btn-primary" href='{{ url("holiday/{$holiday->id}/edit/") }}'>Edit</a></td>
          <td>
              <form action="{{url('holiday', [$holiday->id])}}" method="POST">
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
     