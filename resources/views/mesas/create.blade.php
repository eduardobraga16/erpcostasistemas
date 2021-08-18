@extends('template.template')

@section('content')

<div class="alert-msg"></div>

<h1>Adicionar Funcionário</h1>

<form class="row g-3 formulario-edit" id="formulario-front-cad-prod" method="post" action="{{url('mesas')}}">
  @csrf
  @method('POST')
  <div class="col-md-4">
    <label for="numero" class="form-label">Número Mesa</label>
    <input type="text" class="form-control" id="numero" name="numero" value="" required>

    
  </div>


    <meta name="csrf-token" content="{{ csrf_token() }}" />



  <div class="col-12 btns-crud">
    <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> Salvar</button>
    <a href="{{url('mesas')}}"><button type="button" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Voltar</button></a>
  </div>
</form>



@endsection
