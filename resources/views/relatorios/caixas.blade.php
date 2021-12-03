@extends('template.template')
@section('content')

<h1>Relatório de Caixas</h1>

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
      <th scope="col">Nome Funcionário</th>
      <th scope="col">Saldo Inicial</th>
      <th scope="col">Saldo Final</th>
      <th scope="col">Data/Hora</th>
      <th scope="col">Caixa</th>
      <th scope="col">Ações</th>
    </tr>
  </thead>
  <tbody>

    
  	@foreach($caixas as $key)
    <?php
      $status = "";
      $cor_fundo = "";
      
      if($key['fechado'] == 's'){
        $status = "Fechado";
        $cor_fundo = "style='background:#048c80;padding: 6px 15px 8px 15px;color: #fff;border-radius: 5px;'";
      }else if($key['fechado'] == 'n'){
        $status = "aberto";
        $cor_fundo = "style='background: #e6832f;padding: 6px 15px 8px 15px;color: #fff;border-radius: 5px;'";
      }
    ?>
	  	<tr style="background: #fff;">
	      <th>{{$key['id']}}</th>
        <th><span <?php echo $cor_fundo; ?>>{{$status}}</span></th>
	      <td>{{$key['nome']}}</td>
        <td>R$ {{moedaBr($key['saldo_inicial'])}}</td>
        <td>R$ {{moedaBr($key['fechamento_avista'])}}</td>
        <td>{{dataHoraBr($key['created_at'])}}</td>
        <td>{{$key['caixa']}}</td>
        <?php if($key['fechado'] == 's'){ ?>
          <td><a href="{{url()->current()}}?id={{$key['id']}}&print" target="_blank"><button type="submit" class="btn btn-secondary" style="margin: -7px;"><i class="fas fa-print"></i> Imprimir</button></a></td>
        <?php }else{ ?>
          <td></tr>
        <?php } ?>
	    </tr>
  	@endforeach

  </tbody>
</table>




@endsection