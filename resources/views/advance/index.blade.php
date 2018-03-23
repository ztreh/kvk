@include('inc.header')
@include('inc.menu')


<script type="text/javascript">
$(document).ready(function() {
    $('#example').DataTable( );
} );
</script>
</nav>
        <div id="page-wrapper">
        <div class="col-md-12 graphs">
     <div class="xs">
<h4>Advance List</h4>
@if(session('info'))
    <div class="alert alert-success">{{session('info')}}</div>
@endif 
@if(session('error_delete'))
    <div class="alert alert-danger">{{session('error_delete')}}</div>
@endif 

<table id="example" class="display" width="100%" >
    <thead>
      <tr>
        <td><b>Employee Name</b></td>
        <td><b>Salary Month</b></td>
        <td><b>Advance Amount</b></td>
        <td><b>Create Date</b></td>
        <td><b>Print</b></td>
        <td><b>Edit</b></td>
        <td><b>Delete</b></td>
      </tr>
    </thead>
    
    <tbody>
    <?php $count=0; 
    ?>
    @foreach($advances->all() as $advance)
    <?php 
    $count++;
    ?>
      <tr>
          <td>{{getColumn('employees','name','id',$advance->employee_id)." ".getColumn('employees','nic_no','id',$advance->employee_id)  }}</td>
          <td>{{date("F", strtotime("2001-" .$advance->month. "-01")).' '.$advance->year}}</td>
          <td>{{($advance->advance_amount)}}</td>
          <td>{{($advance->created_at)}}</td>
          <td><a class="btn btn-warning" href='{{ url("advance/{$advance->id}") }}'>Print</a></td>
          <td><a class="btn btn-primary" href='{{ url("advance/{$advance->id}/edit/") }}'>Edit</a></td>
          <!-- <i class="fa fa-edit"></i><i class="fa fa-print"></i> -->
          <td>
              <form action="{{url('advance', [$advance->id])}}" method="POST">
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
     