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
<h4>Designation List</h4>
@if(session('info'))
    <div class="alert alert-success">{{session('info')}}</div>
@endif 
@if(session('error_delete'))
    <div class="alert alert-danger">{{session('error_delete')}}</div>
@endif  

<table id="example" class="display" width="100%" >
    <thead>
      <tr>
        <td><b>Designation</b></td>
        <td><b>Edit</b></td>
        <td><b>Delete</b></td>
      </tr>
    </thead>
    
    <tbody>
    <?php $count=0; 
    ?>
    @foreach($designations->all() as $designation)
    <?php 
    $count++;
    ?>
      <tr>
          <td>{{ucfirst($designation->name)}}</td>
          <td><a class="btn btn-primary" href='{{ url("designation/{$designation->id}/edit/") }}'>Edit</a></td>
          <td>
              <form action="{{url('designation', [$designation->id])}}" method="POST">
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
     