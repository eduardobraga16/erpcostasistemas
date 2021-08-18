@extends('template.template')

@section('content')

<div class="alert-msg"></div>

<h1>Adicionar Novo Produto</h1>

<form class="row g-3" id="formulario-front-cad-prod" method="post" action="{{url('produtos')}}" enctype="multipart/form-data">
  @csrf
  <div class="col-md-6">
    <label for="nome" class="form-label">Nome</label>
    <input type="text" class="form-control" id="nome" name="nome">
  </div>
  <div class="col-md-6">
    <label for="preco" class="form-label">Preço</label>
    <input type="text" class="form-control" id="preco" name="preco">
  </div>
  <div class="col-8">
    <label for="descricao" class="form-label">Descrição</label>
    <input type="text" class="form-control" id="descricao" name="descricao">
  </div>
  <div class="col-4">
    <label for="image" class="form-label">Imagem</label>
    <input type="file" class="form-control" id="image_arquivo" name="image">
  </div>
  <div class="col-md-4">
    <label for="ativo" class="form-label">Ativo</label>
    <select id="ativo" name="ativo" class="form-select">
      <option value="s" selected>Sim</option>
      <option value="n">Não</option>
    </select>
  </div>

  <div class="col-md-4">
    <label for="ativo" class="form-label">Categoria</label>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <ul class="nav flex-column">
      
      
      <li class="nav-item">
        <select name="id_categoria" id="id_categoria" required="true">
          <option selected>Selecione uma categoria</option>
          @foreach($categorias as $cat)
          <option value="{{$cat['id']}}">{{$cat['nome']}}</option>
          @endforeach
        </select>
      </li>
      
    </ul>
  </div>
  

  <div class="col-12">
    <button type="submit" class="btn btn-success btn-confirmar-cadastro"><i class="fas fa-check"></i> Cadastrar</button>
    <a href="{{url('produtos')}}"><button type="button" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Voltar</button></a>
  </div>
</form>



  <div class="modal modal-excluir" tabindex="-1">
  <div class="loadinging"></div>
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Mensagem</h5>
        <button type="button" class="btn-close btn-close-click" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>Produto cadastrado com sucesso!!</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success btn-close-click">Ok</button>
      </div>
    </div>
  </div>
</div>



@endsection