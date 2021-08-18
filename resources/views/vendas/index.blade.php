@extends('template.template')
@section('content')

<h1>Vendas</h1>

<form class="row g-3 form-filtrar-data" method="get" action="">
<div class="col-md-2">  
  <label class="form-label" style="margin-top:0;">Filtrar Data</label>
</div>
<div class="col-md-2">
  <input type="date" value="{{isset($_GET['data-inicio']) ? $_GET['data-inicio'] : date('Y-m-d')}}" name="data-inicio" id="data-inicio" class="form-control">
</div>
<div class="col-md-2">
  <input type="date" value="{{isset($_GET['data-final']) ? $_GET['data-final'] : date('Y-m-d')}}" name="data-final" id="data-final" class="form-control">
</div>

<div class="col-md-2">
  <button type="submit" class="btn btn-success">Filtrar</button>
</div>

</form>

<table class="table table-vendas">
  <thead>
    <tr style="background: rgb(0,65,103);background: linear-gradient(90deg, rgba(0,65,103,1) 0%, rgba(2,84,131,1) 49%, rgba(4,148,127,1) 100%);color:#fff;">
      <th scope="col">ID</th>
      <th scope="col">Cliente</th>
      <th scope="col">Funcionário</th>
      <th scope="col">Data</th>
      <th scope="col">Mesa</th>
      <th scope="col">Total</th>
      <th scope="col">Status</th>
      <th scope="col">Ações</th>
    </tr>
  </thead>
  <tbody>

  	@foreach($vendas as $key)

      <?php
        $status = "";
        $cor_fundo = "";
        if($key['id_status'] == '1'){
          $status = "Em Espera";
          $cor_fundo = "style='background: #e6832f;padding: 6px 15px 8px 15px;color: #fff;border-radius: 5px;'";
        }else if($key['id_status'] == '2'){
          $status = "Confirmado";
          $cor_fundo = "style='background:#048c80;padding: 6px 15px 8px 15px;color: #fff;border-radius: 5px;'";
        }else if($key['id_status'] == '3'){
          $status = "Cancelada";
          $cor_fundo = "style='background:#bb2318;padding: 6px 15px 8px 15px;color: #fff;border-radius: 5px;'";
        }else if($key['id_status'] == '4'){
          $status = "Em Digitação";
          $cor_fundo = "style='background:#999;padding: 6px 15px 8px 15px;color: #fff;border-radius: 5px;'";
        }else{
          
        }
      ?>

	  	<tr style="background: #fff;">
	      <th>{{$key['id']}}</th>
	      <td>{{$key['nome_cliente']}}</td>
        <td>{{$key['nome']}}</td>
        <td><?php echo dataHoraBr($key['created_at']); ?></td>
        <td><?php if($key['id_mesa'] == ""){echo "Balcão/Delivery";}else{echo "Mesa ".$key['id_mesa'];} ?></td>
        <td><?php echo "R$ ". moedaBr($key['total']); ?></td>
        <td><span <?php echo $cor_fundo; ?>>{{$status}}</span></td>
        
        <td style="position:relative;text-align: center;">
          
          <?php 

          if($key['id_status'] == "1"){ ?>

            <span class="hamb-menu-actions"></span>
            <span class="close-menu-actions"></span>
            
            <ul class="list-group-menu-actions">
              <li class="list-group-item">
                <a class="text-white" href="{{url('vendas')}}/{{$key['id']}}/edit"><button class="btn btn-success"><i class="fas fa-check"></i> Atender</button></a>
              </li>
              <li class="list-group-item">
                <a class="text-white" href="{{url('vendas/comprovanteproducao')}}/{{$key['id']}}" target="_blank"><button class="btn btn-secondary"><i class="fas fa-check"></i> Comprovante Produção</button></a>
              </li>
            </ul>

          <?php }else if($key['id_status'] == "2"){ ?>

            <span class="hamb-menu-actions"></span>
            <span class="close-menu-actions"></span>
            
            <ul class="list-group-menu-actions">
              <li class="list-group-item">
                <a class="text-white" href="{{url('vendas')}}/{{$key['id']}}/edit" target="_blank"><button class="btn btn-success"><i class="fas fa-check"></i> Emitir NFE</button></a>
              </li>
              <li class="list-group-item">
                <a class="text-white" href="{{url('vendas/comprovanteproducao')}}/{{$key['id']}}" target="_blank"><button class="btn btn-secondary"><i class="fas fa-check"></i> Comprovante Produção</button></a>
              </li>
              <li class="list-group-item">
                <a class="text-white" href="{{url('vendas/comprovante')}}/{{$key['id']}}" target="_blank"><button class="btn btn-secondary"><i class="fas fa-check"></i> Comprovante</button></a>
              </li>
            </ul>

          <?php }else if($key['id_status'] == "3"){ ?>

            <span class="hamb-menu-actions"></span>
            <span class="close-menu-actions"></span>
            
            <ul class="list-group-menu-actions">
              <li class="list-group-item">
                <a class="text-white" href="{{url('vendas/comprovante')}}/{{$key['id']}}" target="_blank"><button class="btn btn-secondary"><i class="fas fa-check"></i> Comprovante</button></a>
              </li>
            </ul>

          <?php }else if($key['id_status'] == "4"){ ?>

            <span class="hamb-menu-actions"></span>
            <span class="close-menu-actions"></span>
            
            <ul class="list-group-menu-actions">
              <li class="list-group-item">
                <a class="text-white" href="{{url('pdv')}}"><button class="btn btn-success"><i class="fas fa-check"></i> Continuar Venda</button></a>
              </li>
            </ul>

          <?php } ?>
          
        </td>
	    </tr>
  	@endforeach

  </tbody>
</table>


<div class="modal modal-excluir" tabindex="-1">
  <div class="loadinging"></div>
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Excluir Item</h5>
        <button type="button" class="btn-close btn-close-click" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>Tem certeza que deseja excluir este item?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success btn-excluir-confirmar" data-bs-dismiss="modal">Confirmar</button>
        <button type="button" class="btn btn-danger btn-close-click">Cancelar</button>
      </div>
    </div>
  </div>
</div>

{{ $vendas->links("pagination::bootstrap-4") }}
<!--<nav>
  <ul class="pagination">

    <li class="page-item disabled">
      <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Página <?php // if(isset($_GET['page'])){echo $_GET['page'];}else{echo "1";} echo " de ". $produtos['last_page'] ?></a>
    </li>
    <?php //echo paginacao($produtos, 'produtos?page='); ?>


  </ul>
</nav>-->
@endsection

<input type="hidden" class="total_pedidos" value="<?php echo $total; ?>">

<script>
setInterval(function(){
  atualizaPedidos();
}, 7000);

function atualizaPedidos(){

  var total_pedidos = $(".total_pedidos").val();
  

  $.ajax({
      url: base_url+ "/vendas/atualizaroff/1",
      type: "GET",
      dataType: "json",
      success: function(data){
        if(parseInt(data['resultado'])>parseInt(total_pedidos) ){
           location.reload();
        }

      }
    });

}

</script>