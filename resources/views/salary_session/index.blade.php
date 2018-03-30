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
<h4>Salary Session List</h4>
@if(session('info'))
    <div class="alert alert-success">{{session('info')}}</div>
@endif

@if(session('error_delete'))
    <div class="alert alert-danger">{{session('error_delete')}}</div>
@endif
<table  id="example" class="display" width="100%">
    <thead>
        <tr>
            <td><b>Name</b></td>
            <td><b>Year</b></td>
            <td><b>Month</b></td>
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
    @foreach($salary_sessions->all() as $salary_session)
    <?php 
    $count++;
    ?>
    <tr>
        <td>{{$salary_session->name}}</td>
        <td>{{$salary_session->year}}</td>
        <td>{{date("F", strtotime("2001-" .$salary_session->month. "-01"))}}</td>
        <td>{{$salary_session->start_date}} </td>
        <td>{{$salary_session->end_date}} </td>
        <td>{{$salary_session->created_at}} </td>
        <td><a class="btn btn-primary" href='{{ url("salary_session/{$salary_session->id}/edit/") }}'>Edit</a></td>
        <td>
            <form action="{{url('salary_session', [$salary_session->id])}}" method="POST">
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
      