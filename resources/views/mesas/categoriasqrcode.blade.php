@extends('template.templategarcon')
@section('content')


<?php if(isset($venda['id'])){
          if($venda['id_status'] == '1'){ 
            echo "Pedido em andamento.";exit;
        }}
?>

<br />
     <h1>Produtos</h1>
     <br />
    <div class="row row-cols-1 row-cols-md-3 g-4">
     <meta name="csrf-token" content="{{ csrf_token() }}" />
     <input type="hidden" value="{{$venda['id']}}" id="id_venda">
     <input type="hidden" value="<?php if(isset($_GET['idmesa'])){echo $_GET['idmesa'];} ?>" id="id_mesa">
      @foreach($produtos as $key)
      <div class="card-body-full btn-prod-garcon">
        <input type="hidden" value="{{$key['id']}}" id="id_produto">
        <input type="hidden" value="{{$key['nome']}}" id="nome_produto">
        <div class="col">
          <div class="card h-100">
            <div class="card-body">
              <h5 class="card-title">{{$key['nome']}}</h5>
            </div>
          </div>
        </div>
      
      </div>
      @endforeach

    </div>


<div class="modal modal-add-prod-garcon" tabindex="-1">
  <div class="loadinging"></div>
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Adicionar Item</h5>
        <button type="button" class="btn-close btn-close-click" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <label for="qtde" class="form-label ">Quantidade</label>
        <div class="modal-body-qtde">
        <button class="btn btn-success btn-qtde-menos">-</button>
        <input type="number" class="form-control" value="1" id="qtde" name="qtde" placeholder="">
        <button class="btn btn-success btn-qtde-mais">+</button>
        </div>
      </div>
      <div class="modal-footer">
        <input type="hidden" value="" class="id_produto_val">
        <button type="button" class="btn btn-success btn-add-item-garcon" data-bs-dismiss="modal">Adicionar</button>
        <button type="button" class="btn btn-danger btn-close-click">Cancelar</button>
      </div>
    </div>
  </div>
</div>



<div class="box-carrinho table-itens-garcon">
  <div class="row" style="background: #ececec;padding: 7px 2px 3px 0px;">
    <div class="col-md-12" style="display: flex">  
      <input type="text" class="form-control" id="nome_cliente" name="nome_cliente" placeholder="Nome do cliente" required="true" style="margin: 0px 5px 5px 5px;">
      <button class="btn btn-success btn-finalizar-mesa" style="margin: 0px 5px 5px 0px;">Finalizar</button>
      <button class="btn btn-danger btn-cancelar-mesa" style="margin: 0px 5px 5px 0px;">Cancelar</button>
    </div>
    <label for="preco" style="margin:0;padding: 0px 0px 0px 20px;" class="form-label">Total: <span class="str-color2">R$ <span class="total-str">{{moedaBr($venda['total'])}}</span></span></label><br/>
  </div>
  <ul class="list-group list-group-items">

    @foreach($vendas_items as $it)
    <li class="list-group-item">
      <span class="car-qtde">{{$it['qtde']}}x</span>
      <span class="car-iten-nome">{{$it['nome']}}</span>
      <span class="car-item-val">R$ {{$it['qtde']*$it['preco']}}
        <?php if(isset($venda['id'])){
          if($venda['id_status'] == '4'){ ?>
            <div class="btn btn-danger btn-remove-prod" data-id-venda="{{$it['id_venda']}}" data-id-item="{{$it['id_venda_items']}}" onclick="removeItemCarrinho(this)">X</div>
          <?php }}?>
      </span>

    </li>
    @endforeach
  </ul>


</div>

@endsection