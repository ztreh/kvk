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
<h4>Labour List</h4>
@if(session('info'))
    <div class="alert alert-success">{{session('info')}}</div>
@endif       
<table id="example" class="display" width="100%" >
    <thead>
      <tr>
        <td><b>Labour Name</b></td>
        <td><b>Recommended Person's Name</b></td>
        <td><b>Labour Category</b></td>
        <td><b>Create Date</b></td>
        <td><b>Edit</b></td>
        <td><b>Delete</b></td>
      </tr>
    </thead>
    
    <tbody>
    <?php $count=0; 
    ?>
    @foreach($labours->all() as $labour)
    <?php 
    $count++;
    ?>
      <tr>
          <td>{{(getEmployeeName($labour->employees_id))}}</td>
          <td>{{(getEmployeeName($labour->recomended_employee_id))}}</td>
          <td>@if($labour->is_skill==1){{"Skilled"}}@else{{"Unskilled"}}@endif</td>
          <td>{{$labour->created_at}}</td>
          <td><a class="btn btn-primary" href='{{ url("labour/{$labour->id}/edit/") }}'>Edit</a></td>
          <td>
              <form action="{{url('labour', [$labour->id])}}" method="POST">
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
     