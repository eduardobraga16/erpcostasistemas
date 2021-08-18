@extends('template.template')

@section('content')

<?php 
    $tipo = "";
    $sub_pagina = "";
    
    if(isset($_GET['tipo'])){
      if($_GET['tipo'] != "" && $_GET['tipo'] == "e" || $_GET['tipo'] == "s"){
          $tipo = $_GET['tipo'];
          if($tipo == "e"){
            $sub_pagina = "Adicionar Dinheiro ao ";
          }else{
            $sub_pagina = "Remover Dinheiro do ";
          }
      }else{
          redirect('movimentacoes')->send();
      } 
    }else{
        redirect('movimentacoes')->send();
    }

?>

<div class="alert-msg"></div>

<h1>{{$sub_pagina}} {{$caixaAbertoAtual['caixa']}}</h1>

<form class="row g-3" id="formulario-front-cad-prod" method="post" action="{{url('movimentacoes')}}" enctype="multipart/form-data">
  @csrf
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <div class="col-md-6">
    <label for="saldo_inicial" class="form-label">Saldo Inicial</label>
    <input type="text" class="form-control" id="saldo_inicial" value="{{$caixaAbertoAtual['saldo_inicial']}}" readonly="true" name="saldo_inicial">
    <input type="hidden" class="form-control" id="tipo" value="{{$tipo}}" name="tipo">
    <input type="hidden" class="form-control" id="id_funcionario" value="{{$caixaAbertoAtual['id_funcionario']}}" name="id_funcionario">
    <input type="hidden" class="form-control" id="id_estabelecimento" value="{{$caixaAbertoAtual['id_estabelecimento']}}" name="id_estabelecimento">
    <input type="hidden" class="form-control" id="id_caixa" value="{{$caixaAbertoAtual['id_caixa_join']}}" name="id_caixa">
    <input type="hidden" class="form-control" id="id" value="{{$caixaAbertoAtual['id_ab_caixa']}}" name="id">
  </div>
  <div class="col-md-6">
    <label for="saldo_atual" class="form-label">Saldo Atual</label>
    <input type="text" class="form-control" id="saldo_atual" value="{{$valor_em_caixa}}" readonly="true" name="saldo_atual">
  </div>
  <div class="col-8">
    <label for="valor" class="form-label">Valor</label>
    <input type="text" class="form-control" id="valor" name="valor">

    <label for="motivo" class="form-label">Motivo</label>
    <input type="text" class="form-control" id="motivo" name="motivo">
  </div>



  

  <div class="col-12">
    <button type="submit" class="btn btn-success btn-confirmar-movimentacao"><i class="fas fa-check"></i> Confirmar</button>
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