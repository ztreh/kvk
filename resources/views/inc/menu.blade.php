            <!--<div class="navbar-default sidebar" role="navigation" style="max-height: 700px; overflow-y: scroll; position:fixed">-->
            <div class="navbar-default sidebar" style="max-height: 500px; overflow-y: scroll; position:fixed">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                       @if(Auth::user()->user_type!="Accountant") 
                        <li>
                            <a href="#"><i class="fa fa-hand-o-right nav_icon"></i>Salary Month Management<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="{{url('/salarymonth/create')}}">Register New Salary Month</a>
                                </li>
                                <li>
                                    <a href="{{url('/salarymonth')}}">Salary Month List</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-hand-o-right nav_icon"></i>Holiday Management<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="{{url('/holiday/create')}}">Register New Holiday</a>
                                </li>
                                <li>
                                    <a href="{{url('/holiday')}}">Holiday List</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-hand-o-right nav_icon"></i>Device Management<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="{{url('/device/create')}}">Register New Device</a>
                                </li>
                               
                            </ul>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-hand-o-right nav_icon"></i>Designation Management<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="{{url('/designation/create')}}">Register New Designation</a>
                                </li>
                                <li>
                                    <a href="{{url('/designation')}}">Designation List</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-hand-o-right nav_icon"></i>Workplace Management<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="{{url('/workplace/create')}}">Register New Workplace</a>
                                </li>
                                <li>
                                    <a href="{{url('/workplace')}}">Workplace List</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-hand-o-right nav_icon"></i>Employee Management<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="{{url('/employee/create')}}">Register New Employee</a>
                                </li>
                                <li>
                                    <a href="{{url('/employee')}}">Employee List</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-hand-o-right nav_icon"></i>Labour Management<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="{{url('/labour/create')}}">Register New Labour</a>
                                </li>
                                <li>
                                    <a href="{{url('/labour')}}">Labour List</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-hand-o-right nav_icon"></i>Leave Management<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="{{url('/leave/create')}}">Register New Leave</a>
                                </li>
                                <li>
                                    <a href="{{url('/leave')}}">Leave List</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-hand-o-right nav_icon"></i>Attendance Management<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="{{url('attendance/create')}}">Mark Attendance</a>
                                </li>
                                <li>
                                    <a href="{{url('viewattendance')}}">View Attendance</a>
                                </li>
                                
                            </ul>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-hand-o-right nav_icon"></i>Commision Management<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="{{url('commision/create')}}">Add Total Commision Details</a>
                                </li>
                                <li>
                                    <a href="{{url('servicecommision/create')}}">Add Service Center Commision Details</a>
                                </li>
                                <li>
                                    <a href="{{url('commision')}}">Commision List</a>
                                </li>
                                <li>
                                    <a href="{{url('servicecommision')}}">Service Center Commision List</a>
                                </li>
                                
                            </ul>
                        </li>

                        <li>
                            <a href="#"><i class="fa fa-hand-o-right nav_icon"></i>Advance Management<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="{{url('advance/create')}}">Add Advance Details</a>
                                </li>
                                <li>
                                    <a href="{{url('advance')}}">Advance List</a>
                                </li>
                                
                            </ul>
                        </li>

                        <li>
                            <a href="#"><i class="fa fa-hand-o-right nav_icon"></i>Loan Management<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="{{url('loan/create')}}">Add Loan Details</a>
                                </li>
                                <li>
                                    <a href="{{url('loan')}}">Loan List</a>
                                </li>
                                
                            </ul>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-hand-o-right nav_icon"></i>Pay Slip Management<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="{{url('viewfreelanceslips')}}">Freelance Payment</a>
                                </li>
                                <li>
                                    <a href="{{url('viewslips')}}">Slips Payment</a>
                                </li>
                                <li>
                                    <a href="{{url('viewepfslips')}}">EPF Slips Payment</a>
                                </li>
                                <li>
                                    <a href="{{url('viewepfreport')}}">EPF Report</a>
                                </li>
                                
                            </ul>
                        </li>
                        @endif
                        @if(Auth::user()->user_type!="Office Staff") 
                        <li>
                            <a href="#"><i class="fa fa-hand-o-right nav_icon"></i>Loan Account  Management<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="{{url('loanaccount')}}">Main Account</a>
                                </li>
                                
                                <li>
                                    <a href="{{url('loanpaylist')}}">Main Account Payment List</a>
                                </li>
                                
                            </ul>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-hand-o-right nav_icon"></i>Welfare Account  Management<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="{{url('welfareaccount')}}">Welfare Account</a>
                                </li>
                                
                                <li>
                                    <a href="{{url('welfarepaylist')}}">Welfare Payment List</a>
                                </li>
                                
                            </ul>
                        </li>
                        @endif
                        @if(Auth::user()->user_type!="Accountant") 

                        <li>
                            <a href="#"><i class="fa fa-hand-o-right nav_icon"></i>Reports<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="{{url('epfetfreport')}}">EPF/ETF Report </a>
                                </li>
                                <li>
                                    <a href="{{url('freelancepayreport')}}">Freelance Payment Summary Report</a>
                                </li>
                                <li>
                                    <a href="{{url('advancepayreport')}}">Advance Payment Summary Report </a>
                                </li>
                                <li>
                                    <a href="{{url('attendancereport')}}">Attendance Summary Report</a>
                                </li>
                                <li>
                                    <a href="{{url('leavereport')}}">Leave Summary Report</a>
                                </li>
                                <li>
                                    <a href="{{url('loanreport')}}">Loan Summary Report</a>
                                </li>
                                <li>
                                    <a href="{{url('monthlysalaryreport')}}">Monthly Salary Summary Report</a>
                                </li>
                            </ul>
                        </li>
                        @endif
                    </ul>
                </div>
            </div>