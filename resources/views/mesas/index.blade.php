@extends('template.template')
@section('content')

<h1>Produtos</h1>
<table class="table">
  <thead>
    <tr style="background: rgb(0,65,103);background: linear-gradient(90deg, rgba(0,65,103,1) 0%, rgba(2,84,131,1) 49%, rgba(4,148,127,1) 100%);color:#fff;">
      <th scope="col">ID</th>
      <th scope="col">Número</th>
      <th scope="col">Ações</th>
    </tr>
  </thead>
  <tbody>

  	@foreach($mesas as $key)
	  	<tr style="background: #fff;">
	      <th>{{$key['id']}}</th>
	      <td>{{$key['numero']}}</td>
        <td class="btns-crud">
          <button class="btn btn-success"><a class="text-white" href="{{url('mesas')}}/{{$key['id']}}/edit">Editar</a></button>
          <button class="btn btn-danger btn-excluir"><a class="text-white" href="{{url('mesas/excluir')}}/{{$key['id']}}">Excluir</a></button>
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

{{ $mesas->links("pagination::bootstrap-4") }}
<!--<nav>
  <ul class="pagination">

    <li class="page-item disabled">
      <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Página <?php // if(isset($_GET['page'])){echo $_GET['page'];}else{echo "1";} echo " de ". $produtos['last_page'] ?></a>
    </li>
    <?php //echo paginacao($produtos, 'produtos?page='); ?>


  </ul>
</nav>-->
@endsection