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
<h4>Workplace List</h4>
@if(session('info'))
    <div class="alert alert-success">{{session('info')}}</div>
@endif       
<table id="example" class="display" width="100%" >
    <thead>
      <tr>
        <td><b>Workplace Name</b></td>
        <td><b>Address</b></td>
        <td><b>Mobile Number</b></td>
        <td><b>Telephone Number</b></td>
        <td><b>Start Date</b></td>
        <td><b>End Date</b></td>
        <td><b>Created Date</b></td>
        <td><b>Edit</b></td>
        <td><b>Delete</b></td>
      </tr>
    </thead>
    
    <tbody>
    <?php $count=0; 
    ?>
    @foreach($workplaces->all() as $workplace)
    <?php 
    $count++;
    ?>
      <tr>
          <td>{{$workplace->name}}</td>
          <td>{{$workplace->address}}</td>
          <td>{{$workplace->tp_mobile}}</td>
          <td>{{$workplace->tp_land}}</td>
          <td>{{$workplace->start_date}}</td>
          <td>{{$workplace->end_date}}</td>
          <td>{{$workplace->created_at}}</td>
          <td><a class="btn btn-primary" href='{{ url("workplace/{$workplace->id}/edit/") }}'>Edit</a></td>
          <td>
              <form action="{{url('workplace', [$workplace->id])}}" method="POST">
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
      <p></p>
  </div>
   </div>
@include('inc.footer')
     