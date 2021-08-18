@extends('template.template')
@section('content')

<h1>Produtos</h1>
<table class="table">
  <thead>
    <tr style="background: rgb(0,65,103);background: linear-gradient(90deg, rgba(0,65,103,1) 0%, rgba(2,84,131,1) 49%, rgba(4,148,127,1) 100%);color:#fff;">
      <th scope="col">ID</th>
      <th scope="col">Nome</th>
      <th scope="col">Descrição</th>
      <th scope="col">Preço</th>
      <th scope="col">Ativo</th>
      <th scope="col">Categoria</th>
      <th scope="col">Ações</th>
    </tr>
  </thead>
  <tbody>

  	@foreach($produtos as $key)
	  	<tr style="background: #fff;">
	      <th>{{$key['id']}}</th>
	      <td>{{$key['nome']}}</td>
	      <td>{{$key['descricao']}}</td>
	      <td><?php echo "R$ ". moedaBr($key['preco']); ?></td>
	      <td><?php if($key['ativo'] == 's'){echo "Sim";}else{echo "Não";} ?></td>
        <td>{{$key['categoria']['nome']}}</td>
        <td>
          <a class="text-white" href="{{url('produtos')}}/{{$key['id']}}/edit"><button class="btn btn-success">Editar</button></a>
          <a class="text-white" href="{{url('produtos/excluir')}}/{{$key['id']}}"><button class="btn btn-danger btn-excluir">Excluir</button></a>
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

{{ $produtos->links("pagination::bootstrap-4") }}
<!--<nav>
  <ul class="pagination">

    <li class="page-item disabled">
      <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Página <?php // if(isset($_GET['page'])){echo $_GET['page'];}else{echo "1";} echo " de ". $produtos['last_page'] ?></a>
    </li>
    <?php //echo paginacao($produtos, 'produtos?page='); ?>


  </ul>
</nav>-->
@endsection