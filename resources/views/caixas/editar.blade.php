@extends('template.template')

@section('content')

<div class="alert-msg"></div>

<h1>Atender Venda ID: {{$venda['id']}}</h1>

<form class="row g-3 formulario-edit" id="formulario-front-cad-prod" method="post" action="{{url('produtos')}}/{{$venda['id']}}">
  @csrf
  @method('PATCH')
  <div class="col-md-4">
    <label for="nome_cliente" class="form-label">Nome Cliente</label>
    <input type="text" class="form-control" id="nome_cliente" name="nome_cliente" value="{{$venda['nome_cliente']}}">

    <label for="total" class="form-label">Total</label>
    <input type="text" class="form-control" id="total" name="total" value="{{$venda['total']}}">
  </div>
  <div class="col-md-4">
    <label for="preco" class="form-label">Preço</label>
    <input type="text" class="form-control" id="preco" name="preco" value="{{$venda['preco']}}">
  </div>


  <div class="col-8">
    
  </div>
  <input type="hidden" class="form-control" id="id_prod" name="id_prod" value="{{$venda['id']}}">
  <div class="col-md-4">
    
  </div>


  <div class="col-12 btns-crud">
    <button type="submit" class="btn btn-success btn-confirmar-edit-venda"><i class="fas fa-check"></i> Finalizar Venda</button>
    <button type="button" class="btn btn-danger btn-excluir"><a href="{{url('venda')}}/{{$venda['id']}}"><i class="fas fa-trash"></i> Cancelar Venda</a></button>
    <a href="{{url('vendas')}}"><button type="button" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Voltar</button></a>
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
