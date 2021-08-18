@extends('template.template')

@section('content')

<div class="alert-msg"></div>

<h1>Adicionar Funcionário</h1>

<form class="row g-3 formulario-edit" id="formulario-front-cad-prod" method="post" action="{{url('funcionarios')}}">
  @csrf
  @method('POST')
  <div class="col-md-4">
    <label for="nome" class="form-label">Nome</label>
    <input type="text" class="form-control" id="nome" name="nome" value="" required>

    
  </div>
  <div class="col-md-4">

    <label for="administrador" class="form-label">Administrador</label>
    <select id="administrador" name="administrador" class="form-select">
      <option value="s">Sim</option>
      <option value="n" selected>Não</option>
    </select>
  </div>

  <div class="col-md-4">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <label for="id_estabelecimento" class="form-label">Estabelecimento</label> 
    <select  id="id_estabelecimento" name="id_estabelecimento" class="form-select">
      @foreach($estabelecimentos as $cat)
      <option value="{{$cat['id']}}">{{$cat['nome']}}</option>
      @endforeach
    </select>
  </div>
  <div class="col-md-4">
    <label for="senha" class="form-label">Senha</label>
    <input type="text" class="form-control" id="senha" name="senha" value="" required>

    
  </div>


  <div class="col-12 btns-crud">
    <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> Salvar</button>
    <a href="{{url('funcionarios')}}"><button type="button" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Voltar</button></a>
  </div>
</form>



@endsection
