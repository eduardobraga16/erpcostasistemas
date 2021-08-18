@extends('template.template')
@section('content')

<h1>PDV</h1>
<p style="color: #e8e8e8;">Venda Iniciada em: {{dataHoraBr($venda['created_at'])}}</p>

<form class="row g-3" id="formulario-front-cad-prod" method="post" action="{{url('vendas/finalizarvenda')}}/{{$venda['id']}}" enctype="multipart/form-data">
  @csrf
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <input type="hidden" value="{{$venda['id']}}" class="id_venda">
  <div class="col-md-6 area-prods">
    <div class="box-finalizar-pdv box-add-item-car">
    <label for="busca_nome" class="form-label ">Produto</label>
    <input type="text" class="form-control" id="busca_nome" name="busca_nome" placeholder="Digite o nome do produto" autofocus>

    <div class="produtos-resultado">
      <ul class="list-group"></ul>
    </div>


    <label for="qtde" class="form-label ">Quantidade</label>
    <input type="number" class="form-control" value="1" id="qtde" name="qtde" placeholder="">

    <label for="preco_prod" class="form-label ">Preço</label>
    <input type="number" class="form-control" value="0" id="preco_prod" name="preco_prod" placeholder="" disabled="true">
    <input type="hidden" value="" id="id_produto" name="id_produto" placeholder="">

    
    <br/>
    
    

    <button type="submit" class="btn btn-success btn-inserir-item-carrinho"><i class="fas fa-shopping-cart"></i> Inserir no Carrinho</button>
    </div>
    <div class="box-finalizar-pdv">
      

    <label for="preco" class="form-label">Total: <span class="str-color1">R$ <span class="total-str">{{moedaBr($venda['total'])}}</span></span></label><br/>
    <label for="troco" class="form-label"><input type="hidden" value="{{$venda['troco']}}" id="troco" name="troco">Troco: <span class="str-color1">R$ <span class="troco-str">{{moedaBr($venda['troco'])}}</span></span></label><br/>

    <label for="forma_pagamento" class="form-label">Forma de Pagamento</label>
    <ul class="nav flex-column">
      
      
      <li class="nav-item">
        <select name="forma_pagamento" id="forma_pagamento" required="true" class="form-select">
          @foreach($formaspagamento as $forma)
            <option value="{{$forma['id']}}" <?php if($forma['forma'] == "Avista"){echo "selected";} ?> >{{$forma['forma']}}</option>
          @endforeach
        </select>
      </li>
      
    </ul>

    <label for="valor_recebido" class="form-label ">Valor Recebido</label>
    <br/>
    <input type="text" class="form-control" value="{{$venda['total']}}" id="valor_recebido" name="valor_recebido" required="true">

    <label for="nome_cliente" class="form-label ">Nome Cliente</label>
    <br/>
    <input type="text" class="form-control" id="nome_cliente" name="nome_cliente" placeholder="Digite o nome do cliente" required="true">

    <input type="checkbox" id="check_nome_cliente" name="check_nome_cliente">
    <label for="check_nome_cliente" class="form-label lbl-nao-ifr">Não informar</label>
    <br/>

    <button type="submit" class="btn btn-success btn-finalizar-venda"><i class="fas fa-check"></i> Finalizar Venda</button>
    <button type="submit" class="btn btn-warning btn-em-empera-venda"><i class="far fa-clock"></i> Colocar em Espera</button>
    <a href="{{url('vendas/cancelar')}}/{{$venda['id']}}"><button type="button" class="btn btn-danger btn-cancelar-venda"><i class="fas fa-times"></i> Cancelar Venda</button></a>


    </div>

  </div>
  <div class="col-md-6 box-carrinho-pai">
    <label for="preco" class="form-label">Carrinho</label>
    <div class="box-carrinho">
      <ul class="list-group list-group-items">

        @foreach($vendas_items as $it)
        <li class="list-group-item">
          <span class="car-qtde">{{$it['qtde']}}x</span>
          <span class="car-iten-nome">{{$it['nome']}}</span>
          <span class="car-item-val">R$ {{$it['qtde']*$it['preco']}}<div class="btn btn-danger btn-remove-prod" data-id-venda="{{$it['id_venda']}}" data-id-item="{{$it['id_venda_items']}}" onclick="removeItemCarrinho(this)">X</div></span>

        </li>
        @endforeach
      </ul>
    </div>
    

  </div>


</form>

@endsection