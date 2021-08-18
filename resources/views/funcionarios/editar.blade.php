@extends('template.template')

@section('content')

<div class="alert-msg"></div>

<h1>Editar Funcionário</h1>

<form class="row g-3 formulario-edit" id="formulario-front-cad-prod" method="post" action="{{url('funcionarios')}}/{{$funcionario['id']}}">
  @csrf
  @method('PATCH')
  <div class="col-md-4">
    <label for="nome" class="form-label">Nome</label>
    <input type="text" class="form-control" id="nome" name="nome" value="{{$funcionario['nome']}}">
  </div>
  <div class="col-md-4">

    <label for="administrador" class="form-label">Administrador</label>
    <select id="administrador" name="administrador" class="form-select">
      <option value="s" <?php if($funcionario['administrador'] == 's'){echo "selected";} ?> >Sim</option>
      <option value="n" <?php if($funcionario['administrador'] == 'n'){echo "selected";} ?> >Não</option>
    </select>
  </div>

  <div class="col-md-4">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <label for="id_estabelecimento" class="form-label">Estabelecimento</label> 
    <select  id="id_estabelecimento" name="id_estabelecimento" class="form-select">
      <option selected>Selecione um estabelecimento</option>
      @foreach($estabelecimentos as $cat)
      <option value="{{$cat['id']}}" <?php if($cat['id'] == $funcionario['id_estabelecimento']){echo "selected";} ?> >{{$cat['nome']}}</option>
      @endforeach
    </select>
  </div>

  <div class="col-md-4">
    <label for="senha" class="form-label">Senha</label>
    <input type="text" class="form-control" id="senha" name="senha" value="{{$funcionario['senha']}}" required>

    
  </div>



  <div class="col-12 btns-crud">
    <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> Salvar</button>
    <button type="button" class="btn btn-danger btn-excluir"><a href="{{url('funcionarios/excluir')}}/{{$funcionario['id']}}"><i class="fas fa-trash"></i> Excluir</a></button>
    <a href="{{url('funcionarios')}}"><button type="button" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Voltar</button></a>
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
