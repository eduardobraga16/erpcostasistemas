@extends('template.template')
@section('content')

<h1>Relatório de Vendas Por Item</h1>

<form class="row g-3 form-filtrar-data" method="get" action="">
<div class="col-md-2">  
  <label class="form-label" style="margin-top:0;">Filtrar Data</label>
</div>
<div class="col-md-2">
  <input type="date" value="{{isset($_GET['data-inicio']) ? $_GET['data-inicio'] : date('Y-m-d')}}" name="data-inicio" id="data-inicio" class="form-control">
</div>
<div class="col-md-2">
  <input type="date" value="{{isset($_GET['data-final']) ? $_GET['data-final'] : date('Y-m-d')}}" name="data-final" id="data-final" class="form-control">
</div>

<div class="col-md-2">
  <button type="submit" class="btn btn-success">Filtrar</button>
</div>

</form>


<table class="table table-vendas">
  <thead>
    <tr style="background: rgb(0,65,103);background: linear-gradient(90deg, rgba(0,65,103,1) 0%, rgba(2,84,131,1) 49%, rgba(4,148,127,1) 100%);color:#fff;">
      <th scope="col">Nome Produto</th>
      <th scope="col">Qtde</th>
      <th scope="col">Preço único</th>
      <th scope="col">Total</th>
    </tr>
  </thead>
  <tbody>

    <?php 
      $total = 0;
    ?>
  	@foreach($items as $key)

	  	<tr style="background: #fff;">
	      <th>{{$key['nome']}}</th>
        <th>{{$key['qtde_total']}}</th>
	      <td>R$ {{moedaBr($key['preco'])}}</td>
        <td>R$ {{moedaBr($key['qtde_total']*$key['preco'])}}</td>
	    </tr>
      <?php $total += $key['qtde_total']*$key['preco']; ?>
  	@endforeach

  </tbody>
</table>



<div class="row g-3 form-filtrar-data" method="get" action="">

<div class="col-md-12">
  <label class="form-label">Total: R$ {{moedaBr($total)}}</label>
</div>

<div class="col-md-12">
  <a href="{{url()->current()}}?data-inicio={{isset($_GET['data-inicio']) ? $_GET['data-inicio'] : date('Y-m-d')}}&data-final={{isset($_GET['data-final']) ? $_GET['data-final'] : date('Y-m-d')}}&print" target="_blank"><button type="submit" class="btn btn-secondary"><i class="fas fa-print"></i> Imprimir</button></a>
</div>

</div>


@endsection