@include('inc.header')
@include('inc.menu')

<script type="text/javascript">
  $(document).ready(function() {
      $('#example').DataTable({
        dom: 'Bfrtip',
        buttons: [
             'csv', 'excel'
        ],
        scrollX: true
      });
  } );
</script>
</nav>
        <div id="page-wrapper">
        <div class="col-md-12 graphs">
     <div class="xs">
<h4>Leave Summary Report</h4>
@if(session('info'))
    <div class="alert alert-success">{{session('info')}}</div>
@endif       
<table id="example" class="display" width="100%" >
    <thead>
      <tr>
        <th rowspan="2">Employee Name</th>
        <th align="center" colspan="2">Annual</th>
        <th align="center" colspan="2">Casual</th>
        <th align="center" colspan="2">Medical</th>
        
      </tr>
      <tr>
        <td><b>Taken</b></td>
        <td><b>Remaining</b></td>
        <td><b>Taken</b></td>
        <td><b>Remaining</b></td>
        <td><b>Taken</b></td>
        <td><b>Remaining</b></td>
      </tr>
    </thead>
    
    <tbody>
      @if(!empty($employees))
      @foreach($employees as $employee)
      @php
        $annual_leaves=getTotalLeaves(now(),$employee->id,1);
        $casual_leaves=getTotalLeaves(now(),$employee->id,2);
        $medical_leaves=getTotalLeaves(now(),$employee->id,3);
      @endphp
      <tr>
        <td>{{$employee->name}}</td>
        <td>{{$annual_leaves}}</td>
        <td>{{(7-$annual_leaves)}}</td>
        <td>{{$casual_leaves}}</td>
        <td>{{(7-$casual_leaves)}}</td>
        <td>{{$medical_leaves}}</td>
        <td>{{(7-$medical_leaves)}}</td>
      </tr>
      @endforeach
      @endif
    </tbody>
     
</table>

<div class="copy_layout">
      <p><?php //echo $footer_text; ?></p>
  </div>
   </div>
@include('inc.footer')
     