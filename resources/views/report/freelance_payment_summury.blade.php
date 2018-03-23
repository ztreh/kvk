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
<h4>Freelance Payment Summary</h4>
@if(!empty($years))
<div class="row" style="padding: 20px">
  <form action="{{url('freelancepayreport')}}" method="post">
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

          @php
          $count_col_span=count($salarymonths)
          @endphp
            <th colspan="{{$count_col_span}}" >Total Freelance Payment</th>
        @endif
      </tr>

      <tr>
        @if(!empty($salarymonths))
          @foreach($salarymonths as $salarymonth)
            <th>{{$salarymonth->year.' '.date("F", strtotime("2001-" .$salarymonth->month. "-01"))}}</th>
          @endforeach
        @endif
      </tr>
        
    </thead>
    
   @php
     $monthly_salary_total=array();
     @endphp
     <tbody>
       @if(!empty($employees))
       @foreach($employees as $employee)
       <tr>
         <td>{{$employee->name}}</td>
          @if(!empty($salarymonths))
           @foreach($salarymonths as $salarymonth)
           @php
            $net_salary=0;
            $details=getWorkedDetails($employee,$salarymonth->id,$salarymonth->start_date,$salarymonth->end_date);

            if($details['total_worked_days']>0){
             if(($employee->employee_salary_type==0)){
               $total=$employee->per_day_salary*$details['total_worked_days']; 
              }else{
                $total=$employee->monthly_salary; 
              }
              $total_salary=$total+($details['total_ot_hours']*($employee->ot_rate))+$details['total_commision']+$details['other_total_allowances'];
              
              $total_deductions=$details['total_advance']+$details['other_total_deductions'];
              
              $net_salary=$total_salary-$total_deductions;

            }

             if(isset($monthly_salary_total[$salarymonth->id])){
               $monthly_salary_total[$salarymonth->id]+=$net_salary;
             }else{
               $monthly_salary_total[$salarymonth->id]=$net_salary;

             }
           @endphp

         <td>{{number_format($net_salary,2)}}</td>
           @endforeach
         @endif
       </tr>
       @endforeach
       @endif
     </tbody>
      <tfoot>
         <td></td>
         @if(!empty($salarymonths))
           @foreach($salarymonths as $salarymonth)
            @php
             $net_salary=0;
             if(isset($monthly_salary_total[$salarymonth->id])){
              $net_salary= $monthly_salary_total[$salarymonth->id];
             }
           @endphp
             <th>{{number_format($net_salary,2)}}</th>
           @endforeach
         @endif
      </tfoot>
     
</table>

<div class="copy_layout">
      <p><?php //echo $footer_text; ?></p>
  </div>
   </div>
@include('inc.footer')
     