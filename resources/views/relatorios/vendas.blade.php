@extends('template.template')
@section('content')

<h1>Relatório de Vendas</h1>

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
      <th scope="col">Status</th>
      <th scope="col">Nome Cliente</th>
      <th scope="col">F/ Pagamento</th>
      <th scope="col">Total</th>
      <th scope="col">Data/Hora</th>
    </tr>
  </thead>
  <tbody>

    <?php 
      $total_concluidas = 0;
      $total_canceladas = 0; 
      $total_em_espera = 0; 
    ?>
  	@foreach($vendas as $key)
    <?php
      $status = "";
      $cor_fundo = "";
      
      if($key['id_status'] == '2'){
        $status = "Confirmada";
        $cor_fundo = "style='background:#048c80;padding: 6px 15px 8px 15px;color: #fff;border-radius: 5px;'";
        $total_concluidas += $key['total'];
      }else if($key['id_status'] == '3'){
        $status = "Cancelada";
        $cor_fundo = "style='background:#bb2318;padding: 6px 15px 8px 15px;color: #fff;border-radius: 5px;'";
        $total_canceladas += $key['total'];
      }else if($key['id_status'] == '1'){
        $status = "Em Espera";
        $cor_fundo = "style='background: #e6832f;padding: 6px 15px 8px 15px;color: #fff;border-radius: 5px;'";
        $total_em_espera += $key['total'];
      }else if($key['id_status'] == '4'){
        $status = "Em Digitação";
        $cor_fundo = "style='background:#999'";
      }
    ?>
	  	<tr style="background: #fff;">
	      <th>{{$key['id']}}</th>
        <th><span <?php echo $cor_fundo; ?>>{{$status}}</span></th>
	      <td>{{$key['nome_cliente']}}</td>
        <td>{{$key['forma']}}</td>
        <td>{{moedaBr($key['total'])}}</td>
        <td>{{dataHoraBr($key['created_at'])}}</td>
	    </tr>
  	@endforeach

  </tbody>
</table>



<div class="row g-3 form-filtrar-data" method="get" action="">

<div class="col-md-4">
  <label class="form-label">Vendas Concluídas: R$ {{moedaBr($total_concluidas)}}</label>
</div>
<div class="col-md-4">
  <label class="form-label">Vendas Canceladas: R$ {{moedaBr($total_canceladas)}}</label>
</div>
<div class="col-md-4">
  <label class="form-label">Vendas em Espera: R$ {{moedaBr($total_em_espera)}}</label>
</div>

<div class="col-md-12">
  <a href="{{url()->current()}}?data-inicio={{isset($_GET['data-inicio']) ? $_GET['data-inicio'] : date('Y-m-d')}}&data-final={{isset($_GET['data-final']) ? $_GET['data-final'] : date('Y-m-d')}}&print" target="_blank"><button type="submit" class="btn btn-secondary"><i class="fas fa-print"></i> Imprimir</button></a>
</div>

</div>


@endsection