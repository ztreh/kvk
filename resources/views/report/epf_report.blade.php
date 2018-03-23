@include('inc.header')
@include('inc.menu')

<script type="text/javascript">
  $(document).ready(function() {
      $('#example').DataTable({
        dom: 'Bfrtip',
        buttons: [
             'csv', 'excel','pdf'
        ],
        

      });
  } );
</script>
</nav>
        <div id="page-wrapper">
        <div class="col-md-12 graphs">
     <div class="xs" >
<h4>EPF Payment Summary</h4>
@if(!empty($years))
<div class="row" style="padding: 20px">
  <form action="{{url('epfetfreport')}}" method="post">
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
<div style="overflow: scroll;">
<table id="example" class="display" width="100%" border="2" >
    <thead>
      <tr>
        <th rowspan="3">Employee Name</th>
        <th rowspan="3">Employee NIC</th>
        <th rowspan="3">Employee EPF No</th>
        @if(!empty($salarymonths))

          @php
          $count_col_span=count($salarymonths)
          @endphp
            <th colspan="{{($count_col_span)*4}}" >EPF/ETF Payment Summary</th>
        @endif
      </tr>

      <tr>
        @if(!empty($salarymonths))
          @foreach($salarymonths as $salarymonth)
            <th colspan="4" >{{$salarymonth->year.' '.date("F", strtotime("2001-" .$salarymonth->month. "-01"))}}</th>
          @endforeach
        @endif
      </tr>
      <tr>
        @if(!empty($salarymonths))
          @foreach($salarymonths as $salarymonth)
            <th>EPF(8%)</th>
            <th>EPF(12%)</th>
            <th>EPF Total</th>
            <th>ETF(3%)</th>
          @endforeach
        @endif
      </tr>
    </thead>
    
   @php
     $monthly_epf8_total=array();
     $monthly_epf12_total=array();
     $monthly_tot_epf_total=array();
     $monthly_etf_total=array();
     @endphp
     <tbody>
       @if(!empty($employees))
       @foreach($employees as $employee)
       <tr>
         <td>{{$employee->name}}</td>
         <td>{{$employee->nic_no}}</td>
         <td>{{$employee->epf_no}}</td>
          @if(!empty($salarymonths))
           @foreach($salarymonths as $salarymonth)
           @php
           
            $epf8=0;
            $epf12=0;
            $etf3=0;
            $total_epf=0;
            $details=getWorkedDetails($employee,$salarymonth->id,$salarymonth->start_date,$salarymonth->end_date);

            if($details['total_worked_days']>0){
              $salary_for_epf=(($employee->basic_salary+$details['budget_allowance'])/25)*$details['total_worked_days'];

              $epf8=$salary_for_epf*(8/100);
              $epf12=$salary_for_epf*(12/100);
              $etf3=$salary_for_epf*(3/100);
              $total_epf=$epf8+$epf12;

            }

            if(isset($monthly_epf8_total[$salarymonth->id])){
              $monthly_epf8_total[$salarymonth->id]+=$epf8;
            }else{
              $monthly_epf8_total[$salarymonth->id]=$epf8;
            }
            
            if(isset($monthly_epf12_total[$salarymonth->id])){
              $monthly_epf12_total[$salarymonth->id]+=$epf12;
            }else{
              $monthly_epf12_total[$salarymonth->id]=$epf12;
            }
             
            if(isset($monthly_tot_epf_total[$salarymonth->id])){
              $monthly_tot_epf_total[$salarymonth->id]+=$total_epf;
            }else{
              $monthly_tot_epf_total[$salarymonth->id]=$total_epf;
            }
             
            if(isset($monthly_etf_total[$salarymonth->id])){
              $monthly_etf_total[$salarymonth->id]+=$etf3;
             }else{
              $monthly_etf_total[$salarymonth->id]=$etf3;

            }
             
           @endphp

         <td>{{number_format($epf8,2)}}</td>
         <td>{{number_format($epf12,2)}}</td>
         <td>{{number_format($total_epf,2)}}</td>
         <td>{{number_format($etf3,2)}}</td>
           @endforeach
         @endif
       </tr>
       @endforeach
       @endif
     </tbody>
      <tfoot>
        
         <td></td>
         <td></td>
         <td></td>
         @if(!empty($salarymonths))
           @foreach($salarymonths as $salarymonth)
            @php
              $epf8=0;
              $epf12=0;
              $etf3=0;
              $total_epf=0;
             
             if(isset($monthly_epf8_total[$salarymonth->id])){
              $epf8= $monthly_epf8_total[$salarymonth->id];
             }
             if(isset($monthly_epf12_total[$salarymonth->id])){
              $epf12= $monthly_epf12_total[$salarymonth->id];
             }
             if(isset($monthly_tot_epf_total[$salarymonth->id])){
              $total_epf= $monthly_tot_epf_total[$salarymonth->id];
             }
             if(isset($monthly_etf_total[$salarymonth->id])){
              $etf3= $monthly_etf_total[$salarymonth->id];
             }
           @endphp
             <th>{{number_format($epf8,2)}}</th>
             <th>{{number_format($epf12,2)}}</th>
             <th>{{number_format($total_epf,2)}}</th>
             <th>{{number_format($etf3,2)}}</th>
           @endforeach
         @endif
        
      </tfoot>
</table>
</div>

<div class="copy_layout">
      <p><?php //echo $footer_text; ?></p>
  </div>
   </div>
@include('inc.footer')
     