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
<h4>Service Center Commision List</h4>
@if(session('info'))
    <div class="alert alert-success">{{session('info')}}</div>
@endif 
@if(session('error_delete'))
    <div class="alert alert-danger">{{session('error_delete')}}</div>
@endif  

<table id="example" class="display" width="100%" >
    <thead>
      <tr>
        <td><b>Job No</b></td>
        <td><b>Commision Percentage</b></td>
        <td><b>Sale Amount</b></td>
        <td><b>Salary Month</b></td>
        <td><b>Edit</b></td>
        <td><b>Delete</b></td>
      </tr>
    </thead>
    
    <tbody>
    <?php $count=0; 
    ?>
    @foreach($commisions->all() as $commision)
    <?php 
    $count++;
    ?>
      <tr>
          <td>{{ucfirst($commision->job_no)}}</td>
          <td>{{$commision->commition_percentage}}%</td>
          <td>{{$commision->sale_amount}}</td>
          <td>{{date("F", strtotime("2001-" .$commision->month. "-01")).' '.$commision->year}}</td>
          <td><a class="btn btn-primary" href='{{ url("servicecommision/{$commision->id}/edit/") }}'>Edit</a></td>
          <td>
              <form action="{{url('servicecommision', [$commision->id])}}" method="POST">
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
     