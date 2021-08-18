@extends('template.template')

@section('content')

<div class="alert-msg"></div>

<h1>Editar Produto</h1>

<form class="row g-3 formulario-edit" id="formulario-front-cad-prod" method="post" action="{{url('produtos')}}/{{$produto['id']}}">
  @csrf
  @method('PATCH')
  <div class="col-md-4">
    <label for="nome" class="form-label">Nome</label>
    <input type="text" class="form-control" id="nome" name="nome" value="{{$produto['nome']}}">

    <label for="descricao" class="form-label">Descrição</label>
    <textarea type="text" class="form-control" id="descricao" name="descricao" value="">{{$produto['descricao']}}</textarea>
  </div>
  <div class="col-4">
    <label for="image" class="form-label">Imagem</label>
    <img src="<?php if($produto['imagem']){echo url('storage')."/".$produto['imagem'];}else{echo "nao tem";} ?>" width="150px">
    <input type="file" class="form-control" id="image" name="image">
  </div>
  <div class="col-md-4">
    <label for="preco" class="form-label">Preço</label>
    <input type="text" class="form-control real-mask" id="preco" name="preco" value="{{$produto['preco']}}">

    <label for="ativo" class="form-label">Ativo</label>
    <select id="ativo" name="ativo" class="form-select">
      <option value="s" <?php if($produto['ativo'] == 's'){echo "selected";} ?> >Sim</option>
      <option value="n" <?php if($produto['ativo'] == 'n'){echo "selected";} ?> >Não</option>
    </select>
  </div>

  <div class="col-md-4">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <label for="id_categoria" class="form-label">Categoria</label> 
    <select  id="id_categoria" name="id_categoria" class="form-select">
      <option selected>Selecione uma categoria</option>
      @foreach($categorias as $cat)
      <option value="{{$cat['id']}}" <?php if($cat['id'] == $produto['categoria']['id']){echo "selected";} ?> >{{$cat['nome']}}</option>
      @endforeach
    </select>
   
  </div>
  <div class="col-8">
    
  </div>
  <input type="hidden" class="form-control" id="id_prod" name="id_prod" value="{{$produto['id']}}">
  <div class="col-md-4">
    
  </div>


  <div class="col-12 btns-crud">
    <button type="submit" class="btn btn-success btn-confirmar-edit-prod"><i class="fas fa-check"></i> Salvar</button>
    <button type="button" class="btn btn-danger btn-excluir"><a href="{{url('produtos/excluir')}}/{{$produto['id']}}"><i class="fas fa-trash"></i> Excluir</a></button>
    <a href="{{url('produtos')}}"><button type="button" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Voltar</button></a>
  </div>
</form>





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


@endsection
