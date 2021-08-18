@extends('template.template')
@section('content')

<h1>Movimentações</h1>
<table class="table table-vendas">
  <thead>
    <tr style="background: rgb(0,65,103);background: linear-gradient(90deg, rgba(0,65,103,1) 0%, rgba(2,84,131,1) 49%, rgba(4,148,127,1) 100%);color:#fff;">
      <th scope="col">ID</th>
      <th scope="col">Tipo</th>
      <th scope="col">Valor</th>
      <th scope="col">Funcionario</th>
      <th scope="col">Data/Hora</th>
      <th scope="col">ID da Abertura de Caixa</th>
    </tr>
  </thead>
  <tbody>

  	@foreach($movimentacoes as $key)
    <?php
      $tipo = "";
      $cor_fundo = "";
      if($key['tipo'] == 'e'){
        $tipo = "Entrada";
        $cor_fundo = "style='background:#078c0c;color:#fff;'";
      }else if($key['tipo'] == 's'){
        $tipo = "Saída";
        $cor_fundo = "style='background:#ca3328;color:#fff;'";
      }
    ?>
	  	<tr <?php echo $cor_fundo; ?>>
	      <th>{{$key['id']}}</th>
	      <td>{{$tipo}}</td>
        <td>{{$key['valor']}}</td>
        <td>{{$key['nome']}}</td>
        <td>{{dataHoraBr($key['created_at'])}}</td>
        <td>{{$key['id_abertura_caixa']}}</td>
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

{{ $movimentacoes->links("pagination::bootstrap-4") }}
<!--<nav>
  <ul class="pagination">

    <li class="page-item disabled">
      <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Página <?php // if(isset($_GET['page'])){echo $_GET['page'];}else{echo "1";} echo " de ". $produtos['last_page'] ?></a>
    </li>
    <?php //echo paginacao($produtos, 'produtos?page='); ?>


  </ul>
</nav>-->
@endsection