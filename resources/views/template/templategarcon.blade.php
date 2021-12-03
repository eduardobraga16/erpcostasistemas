<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="{{url('assets/css/bootstrap.min.css')}}">
        <link rel="stylesheet" href="{{url('assets/css/style.css')}}">
        <script src="{{url('assets/js/jquery.min.js')}}"></script>
        <script src="{{url('assets/js/bootstrap.min.js')}}"></script>
        
        <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
        <title>PDV Costa Sistemas</title>

        <script>
			var base_url ="<?php echo $base_url = url('/'); ?>";
		</script>

    </head>

    <body>


<div class="loud">
<div class="loadinging">
</div>
<div class="loadingingimg">
	<div class="loadingingimgimg">

		<div class='c-loader'></div>
	</div>
</div>
</div>

<?php 
if(isset($_SERVER['PATH_INFO'])){
    $url_atual = $_SERVER['PATH_INFO'];
    $slugs = explode("/", $url_atual);
}
if($slugs[1] == 'garcon' || $slugs[1] == 'cardapio'){}else{ ?>
	
<div class="col-12">
	<nav class="navbar navbar-expand-lg navbar-light bg-light">
	  <div class="container-fluid">
			<a class="nav-link" style="color:#fff" aria-current="page" href="javascript:history.back()"><i class="fas fa-arrow-left"></i></a>
	  </div>
	</nav>
</div>

<?php } ?>



		<div class="container">
			<div class="row justify-content-md-center">
				<div class="col-md-2"></div>
				<div class="col-md-10">
		    		@yield('content')
		    	</div>

	    	</div>
    	</div>

    	<script src="{{url('assets/js/functions.js')}}"></script>
    </body>
</html>
