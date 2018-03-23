@include('inc.header')
@include('inc.menu')

<!-- extends('layouts.app') -->
</nav>
        <div id="page-wrapper">
        <div class="graphs">
        <div style="position:absolute;  bottom:0; width:100%;" class="copy">
            <p align="center"><?php //echo $footer_text; ?></p>
        </div>
        </div>
       </div>
      <!-- /#page-wrapper -->
   </div>
    <!-- /#wrapper -->
    <!-- Bootstrap Core JavaScript -->
    <!--<script src="js/bootstrap.min.js"></script>-->
</body>
</html>

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
