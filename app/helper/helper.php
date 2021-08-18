<?php

	function moedaBr($str){
		return number_format($str, 2,',','.');
	}

	function dataOriginal($str){
		return date("Y-m-d",strtotime($str));
	}

	function dataBr($str){
		return date("d/m/Y",strtotime($str));
	}

	function dataHoraBr($str){
		return date("d/m/Y, \à\s G:i",strtotime($str));
	}

	function horaBr($str){
		return date("G:i",strtotime($str));
	}



	function paginacao($produtos, $url){
		$pagy_ant = 0;
	    $pagy_frent = $produtos['last_page'];
	    if(isset($_GET['page'])){
	      $pagy_ant = $_GET['page'] - 3;
	      if($pagy_ant < 1){
	        $pagy_ant = 0;
	      }else if($pagy_ant == 2){
	        $pagy_frent = $_GET['page'] + 3;
	      }else{
	        $pagy_frent = $_GET['page'] + 3;
	      }
	      if($pagy_frent > $produtos['last_page']){
	        $pagy_frent = $produtos['last_page'];
	      }
	    }
	    for ($i=$pagy_ant; $i < $pagy_frent; $i++) { ?>
	        <li class="page-item 
	        	<?php if(isset($_GET['page'])){if($_GET['page'] == $i+1){ echo "active"; }}else{if($i+1=='1'){echo "active";}} ?> ">
	        	<a class="page-link" href="<?php echo $url; ?><?php echo $i+1; ?>"><?php echo $i+1; ?></a>
	        </li>
	    <?php } 
	}

?>