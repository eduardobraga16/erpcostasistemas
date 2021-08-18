@extends('template.template')
@section('content')

<h1>Relatório de Movimentações</h1>


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
      <th scope="col">ID</th>
      <th scope="col">Tipo</th>
      <th scope="col">Nome Funcionario</th>
      <th scope="col">ID Caixa</th>
      <th scope="col">Valor</th>
      <th scope="col">Data/Hora</th>
      <th scope="col">ID Abertura Caixa</th>
    </tr>
  </thead>
  <tbody>

    <?php $total_entradas = 0;$total_saidas = 0; ?>
  	@foreach($movimentacoes as $key)
    <?php
      $tipo = "";
      $cor_fundo = "";
      
      if($key['tipo'] == 'e'){
        $tipo = "Entrada";
        $cor_fundo = "style='background:#048c80;padding: 6px 15px 8px 15px;color: #fff;border-radius: 5px;'";
        $total_entradas += $key['valor'];
      }else if($key['tipo'] == 's'){
        $tipo = "Saída";
        $cor_fundo = "style='background: #e6832f;padding: 6px 15px 8px 15px;color: #fff;border-radius: 5px;'";
        $total_saidas += $key['valor'];
      }
    ?>
	  	<tr style="background: #fff;">
	      <th>{{$key['id']}}</th>
        <th><span <?php echo $cor_fundo; ?>>{{$tipo}}</span></th>
	      <td>{{$key['id_funcionario']}}</td>
        <td>{{$key['id_caixa']}}</td>
        <td>R$ {{moedaBr($key['valor'])}}</td>
        <td>{{dataHoraBr($key['created_at'])}}</td>
        <td>{{$key['id_abertura_caixa']}}</td>
	    </tr>
  	@endforeach

  </tbody>
</table>



<div class="row g-3 form-filtrar-data" method="get" action="">

<div class="col-md-6">
  <label class="form-label">Total de Entradas: R$ {{moedaBr($total_entradas)}}</label>
</div>
<div class="col-md-6">
  <label class="form-label">Total de Saídas: R$ {{moedaBr($total_saidas)}}</label>
</div>

<div class="col-md-12">
  <a href="{{url()->current()}}?data-inicio={{isset($_GET['data-inicio']) ? $_GET['data-inicio'] : date('Y-m-d')}}&data-final={{isset($_GET['data-final']) ? $_GET['data-final'] : date('Y-m-d')}}&print" target="_blank"><button type="submit" class="btn btn-secondary"><i class="fas fa-print"></i> Imprimir</button></a>
</div>

</div>


@endsection