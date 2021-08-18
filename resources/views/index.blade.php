@extends('template.template')

@section('content')

<h1>Bem Vindo!</h1>


<div class="row row-cols-1 row-cols-md-3 g-4">
  <div class="col">
    <div class="card h-100">
      <div class="card-body">
        <h5 class="card-title">Vendido Hoje</h5>
        <p class="card-text">R$ {{moedaBr($valor_vendido_hoje)}}</p>
      </div>

    </div>
  </div>
  <div class="col">
    <div class="card h-100">
      <div class="card-body">
        <h5 class="card-title">Pedidos Hoje</h5>
        <p class="card-text">22 Pedidos</p>
      </div>

    </div>
  </div>
  <div class="col">
    <div class="card h-100">
      <div class="card-body">
        <h5 class="card-title">Caixa Aberto</h5>
        <p class="card-text">Caixa 1 Aberto</p>
      </div>

    </div>
  </div>
</div>

@endsection