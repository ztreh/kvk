<!DOCTYPE HTML>
<html>
<head>
<title>{{ config('app.name', 'Laravel') }}</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta charset="utf-8">
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
 <!-- Bootstrap Core CSS -->
<link href="{{url('css/bootstrap.min.css')}}" rel='stylesheet' type='text/css' />
<!-- Custom CSS -->
<link href="{{url('css/style.css')}}" rel='stylesheet' type='text/css' />
<!-- Graph CSS -->
<link href="{{url('css/lines.css')}}" rel='stylesheet' type='text/css' />
<link href="{{url('css/fullcalendar.css')}}" rel='stylesheet' type='text/css' />

<link href="{{url('css/jquery.datetimepicker.css')}}" rel='stylesheet' type='text/css' />

<link href="{{url('css/jquery.timepicker.css')}}" rel='stylesheet' type='text/css' />
<link href="{{url('css/timepicki.css')}}" rel='stylesheet' type='text/css' />
<link href="{{url('css/jquery.dataTables.min.css')}}" rel='stylesheet' type='text/css' />
<link href="{{url('css/select2.min.css')}}" rel='stylesheet' type='text/css' />
<link href="{{url('css/buttons.dataTables.min.css')}}" rel='stylesheet' type='text/css' />


<link href="{{asset('css/font-awesome.css')}}" rel="stylesheet"> 
<link href="{{url('css/wickedpicker.min.css')}}" rel="stylesheet"> 
<!-- jQuery -->

<style type="text/css">
#scrolltable { margin-top: 20px; height: 400px; overflow: auto; }
#scrolltable th div { position: absolute; margin-top: -20px; }
</style>
<script src="{{url('js/jquery.min.js')}}"></script>
<!----webfonts--->
<link href='//fonts.googleapis.com/css?family=Roboto:400,100,300,500,700,900' rel='stylesheet' type='text/css'>
<!---//webfonts--->    
<!-- Nav CSS -->
<link href="{{url('css/custom.css')}}" rel="stylesheet">
<!-- Metis Menu Plugin JavaScript -->
<script src="{{url('js/metisMenu.min.js')}}"></script>
<script src="{{url('js/custom.js')}}"></script>
<!-- Graph JavaScript -->
<script src="{{url('js/d3.v3.js')}}"></script>
<script src="{{url('js/rickshaw.js')}}"></script>
<script src="{{url('js/bootstrap.min.js')}}"></script>
<script src="{{url('js/jquery.dataTables.min.js')}}"></script>

<script src="{{url('js/moment.min.js')}}"></script>
<script src="{{url('js/fullcalendar.min.js')}}"></script>
<script type="javascript" src="{{url('js/wickedpicker.min.js')}}"></script>


<script src="{{url('js/jquery.datetimepicker.js')}}"></script>
<script src="{{url('js/timepicki.js')}}"></script>
<script src="{{url('js/select2.min.js')}}"></script>

<link rel="stylesheet" href="{{url('css/jquery-ui.css')}}" />
<!--<script type="text/javascript" src="js/jquery.min.js"></script>-->
<!--<script src="js/jquery-1.9.1.js"></script>-->
<script src="{{url('js/jquery-ui.js')}}"></script>
<!--<link rel="stylesheet" href="css/style1.css" />-->


<script src="{{url('js/jquery.timepicker.js')}}"></script>

</head>
<body>
<SCRIPT src="{{url('js/wz_tooltip.js')}}" type=text/javascript></SCRIPT>
<div id="wrapper">
     <!-- Navigation -->
        <nav class="top1 navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="">{{ config('app.name', 'Laravel') }}</a>
            </div>
            <!-- /.navbar-header -->
            <!-- Right Side Of Navbar -->
            <ul class="nav navbar-nav navbar-right">
                <!-- Authentication Links -->
                @guest
                    <li><a href="{{ route('login') }}">Login</a></li>
                    <!-- <li><a href="{{ route('register') }}">Register</a></li> -->
                @else
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle avatar" data-toggle="dropdown">
                            {{ Auth::user()->name }}
                        </a>

                        <ul class="dropdown-menu">
                            <li class="m_2">
                                <a href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                    Logout
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </li>
                        </ul>
                    </li>
                @endguest
            </ul>



          <!--   <ul class="nav navbar-nav navbar-right">
			    <li class="dropdown">
	        		<a href="#" class="dropdown-toggle avatar" data-toggle="dropdown"><img src="images/1.png"><!--<span class="badge">9</span>--></a>
	        		<!-- <ul class="dropdown-menu">
						<?php if(isset($_SESSION['u_id']) && $_SESSION['u_id']>0){?>
						<li class="m_2"><a href="logout.php"><i class="fa fa-lock"></i> Logout</a></li>
						<?php }else{?>	
						<li class="m_2"><a href="login.php"><i class="fa fa-lock"></i> Login</a></li>	
						<?php } ?>
	        		</ul>
	      		</li> -->
			<!-- </ul> --> 