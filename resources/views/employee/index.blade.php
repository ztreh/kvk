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
<h4>Employee List</h4>
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
        <td><b>Birth Day</b></td>
        <td><b>Current Address</b></td>
        <td><b>Employee Category</b></td>
        <td><b>Employee Designation</b></td>
        <td><b>Date Joined</b></td>
        <td><b>Finger Print No</b></td>
        <td><b>Basic Salary(Rs.)</b></td>
        <td><b>View</b></td>
        <td><b>Edit</b></td>
        <td><b>Delete</b></td>
      </tr>
    </thead>
    <tbody>
    <?php $count=0; 
    ?>
    @foreach($employees->all() as $employee)
    <?php 
    $count++;
    ?>
      <tr>
          <td>{{ucfirst($employee->name)}}</td>
          <td>{{$employee->birth_day}}</td>
          <td>{{$employee->address_current}}</td>
          <td>{{$employee->category_name}}</td>
          <td>{{$employee->designation_name}}</td>
          <td>{{$employee->date_joined}}</td>
          <td>{{$employee->finger_print_no}}</td>
          <td>{{$employee->basic_salary}}</td>
          <td><a class="btn btn-warning" href='{{ url("employee/{$employee->id}") }}'>View</a></td>
          <td><a class="btn btn-primary" href='{{ url("employee/{$employee->id}/edit/") }}'>Edit</a></td>
          <td>
              <form action="{{url('employee', [$employee->id])}}" method="POST">
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
     