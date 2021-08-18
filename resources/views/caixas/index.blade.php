@extends('template.template')
@section('content')


<div class="row g-3 justify-content-md-center">

  <?php if($caixasAberto){ ?>
    <center><h1>Caixas Abertos</h1></center>
@foreach($caixaAbertoList as $key)
    <div class="col-md-4 box-caixa">
      <input type="hidden" value="{{$key['id']}}" id="id_caixa" name="id_caixa">
      <input type="hidden" value="{{$key['id_ab_caixa']}}" id="id_ab_caixa" name="id_ab_caixa">
      <input type="hidden" value="{{$key['id_funcionario']}}" id="id_funcionario" name="id_funcionario">
      <input type="hidden" value="{{$key['nomeFuncionario']}}" id="nome_funcionario" name="nome_funcionario">
      <meta name="csrf-token" content="{{ csrf_token() }}" />
      <label for="caixa" class="form-label"><h2>{{$key['caixa']}}</h2></label><br/>
      <label for="caixa_status" class="form-label">Status: 
        <?php 
        $status_caixa = false; 
        if($key['fechado'] == 's'){
          echo "Fechado<br/>";
          $status_caixa = true;
        }else{
          echo "Aberto<br/>";
          $status_caixa = false;
        }

        echo "Aberto em: <br/>". $key['created_at']."<br/>";
        echo "Funcionário: <br/>". $key['nomeFuncionario']."<br/>";
        echo "Saldo Inicial: <br/>R$ ". moedaBr($key['saldo_inicial'])."<br/>";
        
        if(!$status_caixa){ ?>
          <button type="submit" class="btn btn-danger btn-fechar-caixa"><i class="fas fa-times"></i> Fechar Caixa</button>
        <?php } ?>
      </label>
    </div>
@endforeach
  <?php }//else{ ?>
    <center><h1>Abrir Caixa</h1></center>
    <center><h2>Escolha um caixa para abrir!</h2></center>
  	@foreach($caixas as $key)

    <div class="col-md-4 box-caixa">
      <input type="hidden" value="{{$key['id']}}" id="id_caixa" name="id_caixa">
      <label for="caixa" class="form-label"><h2>{{$key['caixa']}}</h2></label><br/>
      <label for="caixa_status" class="form-label">Status: 
        <?php 
        $status_caixa = false; 
        if($key['fechado'] == 's'){
          echo "Fechado<br/>";
          $status_caixa = true;
        }else{
          echo "Aberto<br/>";
          $status_caixa = false;
        }
        if($status_caixa){ ?>
          <button type="submit" class="btn btn-success btn-abrir-caixa"><i class="fas fa-check"></i> Abrir Caixa</button>
        <?php } ?>
      </label>
    </div>
  
  	@endforeach

  <?php //} ?>
</div>


<div class="modal modal-excluir" id="modal-abrir-caixa" tabindex="-1">
  <div class="loadinging"></div>
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Abrir Caixa</h5>
        <button type="button" class="btn-close btn-close-click" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

          <label for="estabelecimento_id" class="form-label">Estabelecimento</label><br/>
          <select class="form-select" id="estabelecimento_id" name="estabelecimento_id">
            @foreach($estabelecimentos as $key)
            <option value="{{$key['id']}}">{{$key['nome']}}</option>
            @endforeach
          </select>
          <br/>

          <label for="funcionario_id" class="form-label">Funcionario</label><br/>
          <select class="form-select" id="funcionario_id" name="funcionario_id">
            <option value="" selected>Selecione Seu Nome</option>
            @foreach($funcionarios as $key)
            <option value="{{$key['id']}}">{{$key['nome']}}</option>
            @endforeach
          </select>
          <br/>

          <label for="senha" class="form-label">Senha</label>
          <input type="password" class="form-control" id="senha" name="senha">

          <label for="valor_inicial" class="form-label">Valor Inicial</label>
          <input type="text" class="form-control" id="valor_inicial" value="0" name="valor_inicial">
        
      </div>
      <div class="modal-footer">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <button type="button" class="btn btn-success btn-abrir-caixa-confirmar" data-bs-dismiss="modal">Abrir Caixa</button>
        <button type="button" class="btn btn-danger btn-close-click">Cancelar</button>
        <input type='hidden' value='' class='id_caixa'>
      </div>
    </div>
  </div>
</div>



<div class="modal modal-excluir" id="modal-fechar-caixa" tabindex="-1">
  <div class="loadinging"></div>
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Fechar Caixa</h5>
        <button type="button" class="btn-close btn-close-click" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">



          <label for="funcionario_id" class="form-label">Funcionario</label>
          <input type="text" class="form-control" id="funcionario_nome_fecha" name="funcionario_nome_fecha" disabled="false">
          <input type="hidden" class="form-control" id="funcionario_id_fecha" name="funcionario_id_fecha" disabled="false"><br/>

          <label for="senha" class="form-label">Senha</label>
          <input type="password" class="form-control" id="senha" name="senha"><br/>

          <label for="valor_final" class="form-label">Dinheiro em Caixa</label>
          <input type="text" class="form-control" id="valor_final" value="0" name="valor_final"><br/>

          <label for="valor_final" class="form-label">Cartão Crédito</label>
          <input type="text" class="form-control" id="cartao_credito" value="0" name="cartao_credito"><br/>

          <label for="valor_final" class="form-label">Cartão Débito</label>
          <input type="text" class="form-control" id="cartao_debito" value="0" name="cartao_debito"><br/>

          <label for="valor_final" class="form-label">Pix</label>
          <input type="text" class="form-control" id="pix" value="0" name="pix">
        
      </div>
      <div class="modal-footer">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <button type="button" class="btn btn-success btn-fechar-caixa-confirmar" data-bs-dismiss="modal">Fechar Caixa</button>
        <button type="button" class="btn btn-danger btn-close-click">Cancelar</button>
        <input type='hidden' value='' class='id_caixa'>
        <input type='hidden' value='' class='id_ab_caixa'>
      </div>
    </div>
  </div>
</div>


<!--<nav>
  <ul class="pagination">

    <li class="page-item disabled">
      <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Página <?php // if(isset($_GET['page'])){echo $_GET['page'];}else{echo "1";} echo " de ". $produtos['last_page'] ?></a>
    </li>
    <?php //echo paginacao($produtos, 'produtos?page='); ?>


  </ul>
</nav>-->
@endsection