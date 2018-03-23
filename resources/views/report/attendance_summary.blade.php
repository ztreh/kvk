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
<h4>Attendance Summary Report</h4>
@if(!empty($years))
<div class="row" style="padding: 20px">
  <form action="{{url('attendancereport')}}" method="post">
    {{ csrf_field() }}
    <div class="form-group">
      <label for="focusedinput" class="col-sm-2 control-label">Select Year </label>
      <div class="col-sm-8">
        <select class="form-control1" name="year"  id="year" onchange="this.form.submit()">
        @foreach($years as $y)
          <option value="{{$y->year}}" @if(!empty($search_year) && $y->year==$search_year) selected @endif>{{$y->year}}</option>
        @endforeach
        </select>
      </div>
    </div>
  </form>
</div>
@endif
@if(session('info'))
    <div class="alert alert-success">{{session('info')}}</div>
@endif       
<table id="example" class="display" width="100%" >
    <thead>
      <tr>
        <th rowspan="2">Employee Name</th>
        @if(!empty($salarymonths))
          @foreach($salarymonths as $salarymonth)
            <th colspan="2">{{$salarymonth->year.' '.date("F", strtotime("2001-" .$salarymonth->month. "-01")).' ('.count(getDatesFromRange($salarymonth->start_date,$salarymonth->end_date)).')'}}</th>
          @endforeach
        @endif
      </tr>

      <tr>
        @if(!empty($salarymonths))
          @foreach($salarymonths as $salarymonth)
            <th>Worked Days</th>
            <th>Leaves</th>
          @endforeach
        @endif
      </tr>

    </thead>
    
    <tbody>
      @if(!empty($employees))
      @foreach($employees as $employee)
      <tr>
        <td>{{$employee->name}}</td>
        @if(!empty($salarymonths))
          @foreach($salarymonths as $salarymonth)
          @php
            $details=totWorkedDaysDetails($employee,$salarymonth->id,$salarymonth->end_date); 

          @endphp
            <td><b>{{$details['total_worked_days']}}</b></td>
            <td><b>{{$details['total_leaves']}}</b></td>
            
          @endforeach
        @endif
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
     