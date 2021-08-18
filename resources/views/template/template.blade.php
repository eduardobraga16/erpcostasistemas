<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="{{url('assets/css/bootstrap.min.css')}}">
        <link rel="stylesheet" href="{{url('assets/css/style.css')}}">
        <script src="{{url('assets/js/jquery.min.js')}}"></script>
        <script src="{{url('assets/js/jquery.mask.min.js')}}"></script>
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


<div class="col-12">
	<nav class="navbar navbar-expand-lg navbar-light bg-light">
	  <div class="container-fluid">
	  	
	    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
	      <span class="navbar-toggler-icon"></span>
	    </button>

	    <div class="collapse navbar-collapse menu-topo" id="navbarSupportedContent">
			<ul class="navbar-nav me-auto mb-2 mb-lg-0">
			<li class="nav-item">
			  <a class="nav-link" aria-current="page" href="{{url('home')}}">Página Inicial</a>
			</li>
			</ul>

			<ul class="navbar-nav float-end">
		      <li class="nav-item">
		          <a class="nav-link" href="{{url('logout')}}">Sair</a>
		      </li>
		    </ul>
	      
	    </div>
	  </div>
	</nav>
</div>




<div class="col-2">
	<div class="m-lateral">
		<div class="menu-lateral">

			<?php 
			if(isset($_SERVER['PATH_INFO'])){
		        $url_atual = $_SERVER['PATH_INFO'];
		        $slugs = explode("/", $url_atual);
		    }
			?>
			
			<center><a class="navbar-brand" href="#"><img class="img-logo" src="{{url('assets/img/logo.png')}}" width="200px"></a></center>

			<ul class="nav flex-column">

			<li class="nav-item">
				<a href="{{url('pdv')}}" class="nav-link navbar-toggler <?php if($slugs[1] == 'pdv'){echo 'ativado';} ?>"><i class="fas fa-cart-plus"></i> PDV</a>
			</li>

			<li class="nav-item">
			    <a class="nav-link navbar-toggler dropdown-toggle <?php if($slugs[1] == 'caixas' || $slugs[1] == 'vendas'){echo 'ativado';} ?>" aria-current="page" href="#" data-bs-toggle="collapse" data-bs-target="#navbarSubMenu6" aria-controls="navbarSubMenu6" aria-expanded="false" aria-label="Toggle navigation"><i class="fas fa-hand-holding-usd"></i> Operações Caixa</a>
			    <div class="submenu-tg">
				    <div class="navbarSubMenu <?php if($slugs[1] == 'caixas' || $slugs[1] == 'vendas'){echo 'show';}else{echo 'collapse';} ?>" id="navbarSubMenu6">
				    	<a href="{{url('vendas')}}">Vendas</a>
				    	<a href="{{url('caixas')}}">Abertura/Fechamento</a>
				    </div>
				</div>
			</li>

			<li class="nav-item">
			    <a class="nav-link navbar-toggler dropdown-toggle <?php if($slugs[1] == 'movimentacoes'){echo 'ativado';} ?>" aria-current="page" href="#" data-bs-toggle="collapse" data-bs-target="#navbarSubMenu7" aria-controls="navbarSubMenu7" aria-expanded="false" aria-label="Toggle navigation"><i class="fas fa-hand-holding-usd"></i> Movimentações</a>
			    <div class="submenu-tg">
				    <div class="navbarSubMenu <?php if($slugs[1] == 'movimentacoes'){echo 'show';}else{echo 'collapse';} ?>" id="navbarSubMenu7">
				    	<!--<a href="{{url('movimentacoes')}}">Listar Movimentações</a>-->
				    	<a href="{{url('movimentacoes/create?tipo=e')}}">Reforço</a>
				    	<a href="{{url('movimentacoes/create?tipo=s')}}">Sangria</a>
				    </div>
				</div>
			</li>

			  <li class="nav-item">
			    <a class="nav-link navbar-toggler dropdown-toggle <?php if($slugs[1] == 'produtos'){echo 'ativado';} ?>" aria-current="page" href="#" data-bs-toggle="collapse" data-bs-target="#navbarSubMenu1" aria-controls="navbarSubMenu1" aria-expanded="false" aria-label="Toggle navigation"><i class="fas fa-box-open"></i> Produtos</a>
			    <div class="submenu-tg">
				    <div class="navbarSubMenu <?php if($slugs[1] == 'produtos'){echo 'show';}else{echo 'collapse';} ?>" id="navbarSubMenu1">
				    	<a href="{{url('produtos')}}">Listar Todos</a>
				    	<a href="{{url('produtos/create')}}">Cadastrar Novo</a>
				    </div>
				</div>
			  </li>

			  <li class="nav-item">
			    <a class="nav-link navbar-toggler dropdown-toggle <?php if($slugs[1] == 'relatorios'){echo 'ativado';} ?>" aria-current="page" href="#" data-bs-toggle="collapse" data-bs-target="#navbarSubMenu2" aria-controls="navbarSubMenu2" aria-expanded="false" aria-label="Toggle navigation"><i class="fas fa-book"></i> Relatórios</a>
			   <div class="submenu-tg">
				    <div class="navbarSubMenu <?php if($slugs[1] == 'relatorios'){echo 'show';}else{echo 'collapse';} ?>" id="navbarSubMenu2">
				    	<a href="{{url('relatorios/vendas')}}">Vendas</a>
				    	<a href="{{url('relatorios/vendasitens')}}">Vendas Itens</a>
				    	<a href="{{url('relatorios/movimentacoes')}}">Movimentações</a>
				    	<a href="{{url('relatorios/caixas')}}">Caixas</a>
				    </div>
				</div>
			  </li>

			  <li class="nav-item">
			    <a class="nav-link navbar-toggler dropdown-toggle <?php if($slugs[1] == 'funcionarios'){echo 'ativado';} ?>" aria-current="page" href="#" data-bs-toggle="collapse" data-bs-target="#navbarSubMenu3" aria-controls="navbarSubMenu3" aria-expanded="false" aria-label="Toggle navigation"><i class="fas fa-user-friends"></i> Funcionários</a>
			    <div class="submenu-tg">
				    <div class="navbarSubMenu <?php if($slugs[1] == 'funcionarios'){echo 'show';}else{echo 'collapse';} ?>" id="navbarSubMenu3">
				    	<a href="{{url('funcionarios')}}">Listar Todos</a>
				    	<a href="{{url('funcionarios/create')}}">Cadastrar Novo</a>
				    </div>
				</div>
			  </li>

			  <li class="nav-item">
			    <a class="nav-link navbar-toggler dropdown-toggle <?php if($slugs[1] == 'mesas'){echo 'ativado';} ?>" aria-current="page" href="#" data-bs-toggle="collapse" data-bs-target="#navbarSubMenu8" aria-controls="navbarSubMenu8" aria-expanded="false" aria-label="Toggle navigation"><i class="fas fa-chair"></i> Mesas</a>
			    <div class="submenu-tg">
				    <div class="navbarSubMenu <?php if($slugs[1] == 'mesas'){echo 'show';}else{echo 'collapse';} ?>" id="navbarSubMenu8">
				    	<a href="{{url('mesas')}}">Listar Todas</a>
				    	<a href="{{url('mesas/create')}}">Cadastrar Nova</a>
				    	<a href="{{url('qrcode')}}">QR Code</a>
				    </div>
				</div>
			  </li>

			  <li class="nav-item">
			    <a class="nav-link navbar-toggler dropdown-toggle <?php if($slugs[1] == 'delivery'){echo 'ativado';} ?>" aria-current="page" href="#" data-bs-toggle="collapse" data-bs-target="#navbarSubMenu9" aria-controls="navbarSubMenu9" aria-expanded="false" aria-label="Toggle navigation"><i class="fas fa-utensils"></i> Delivery</a>
			    <div class="submenu-tg">
				    <div class="navbarSubMenu <?php if($slugs[1] == 'delivery'){echo 'show';}else{echo 'collapse';} ?>" id="navbarSubMenu9">
				    	<a href="#">Listar Todos</a>
				    	<a href="#">Cadastrar Novo</a>
				    </div>
				</div>
			  </li>
			  
			</ul>
		
		</div>
	</div>
</div>


		<div class="container">
			<div class="row justify-content-md-center">
				<div class="col-md-2"></div>
				<div class="col-md-10 body-full">
		    		@yield('content')
		    	</div>

	    	</div>
    	</div>

    	<script src="{{url('assets/js/functions.js')}}"></script>
    </body>
</html>
