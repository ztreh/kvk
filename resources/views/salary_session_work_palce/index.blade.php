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
<h4>Workplace Salary Session List</h4>
@if(session('info'))
    <div class="alert alert-success">{{session('info')}}</div>
@endif

@if(session('error_delete'))
    <div class="alert alert-danger">{{session('error_delete')}}</div>
@endif
<table  id="example" class="display" width="100%">
    <thead>
        <tr>
            <td><b>Workplace</b></td>
            <td><b>Salary Session</b></td>
            <td><b>Salary Session Type</b></td>
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
    @foreach($workplace_salary_sessions->all() as $salary_session)
    <?php 
    $count++;
    ?>
    <tr>
        <td>{{$salary_session->work_places->name}}</td>
        <td>{{getColumn('salary__sessions','name','id',$salary_session->salary_sessions_id)}}</td>
        <td>{{getColumn('salary__session__types','name','id',$salary_session->salary_session_types_id)}}</td>
        <td>{{$salary_session->start_date}} </td>
        <td>{{$salary_session->end_date}} </td>
        <td>{{$salary_session->created_at}} </td>
        <td><a class="btn btn-primary" href='{{ url("workplace_salary_session/{$salary_session->id}/edit/") }}'>Edit</a></td>
        <td>
            <form action="{{url('workplace_salary_session', [$salary_session->id])}}" method="POST">
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
      