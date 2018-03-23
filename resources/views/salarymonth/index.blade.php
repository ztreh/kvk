@include('inc.header')
@include('inc.menu')

<script type="text/javascript">
    $(document).ready(function(){
        $("#year").autocomplete({
        source:'autocomplete_salary_year.php',
        minLength:1
        });
    });

    $(document).ready(function() {
        $('#example').DataTable();
    });    
</script>

</nav>
        <div id="page-wrapper">
        <div class="col-md-12 graphs">
       <div class="xs">
<h4>Salary Month List</h4>
@if(session('info'))
    <div class="alert alert-success">{{session('info')}}</div>
@endif

@if(session('error_delete'))
    <div class="alert alert-danger">{{session('error_delete')}}</div>
@endif
<table  id="example" class="display" width="100%">
    <thead>
        <tr>
            <td><b>Year</b></td>
            <td><b>Month</b></td>
            <td><b>Start Date</b></td>
            <td><b>End Date</b></td>
            <td><b>Budget Allowance</b></td>
            <td><b>Edit</b></td>
            <td><b>Delete</b></td>
        </tr>
    </thead>
    <tbody>
        
    <?php $count=0; 
    ?>
    @foreach($salarymonths->all() as $salarymonth)
    <?php 
    $count++;
    ?>
    <tr>
        <td>{{$salarymonth->year}}</td>
        <td>{{date("F", strtotime("2001-" .$salarymonth->month. "-01"))}}</td>
        <td>{{$salarymonth->start_date}} </td>
        <td>{{$salarymonth->end_date}} </td>
        <td>{{$salarymonth->budget_allowance}} </td>
        <td><a class="btn btn-primary" href='{{ url("salarymonth/{$salarymonth->id}/edit/") }}'>Edit</a></td>
        <td>
            <form action="{{url('salarymonth', [$salarymonth->id])}}" method="POST">
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
      