@extends('template.templategarcon')
@section('content')


    <br />
    <?php if(isset($titulo)){echo "<h1>".$titulo."</h1>";}else{ ?>
     <h1>Mesa {{$mesa['numero']}}</h1>
     <h2 style="color: #a9a9a9;font-size: 19px;">Escolha uma categoria</h2>
    <br />
    <div class="row row-cols-1 row-cols-md-3 g-4">
     
      @foreach($categorias as $key)
      <div class="card-body-full">
        <a href="{{url('mesa')}}/{{$mesa['id']}}/categoria/{{$key['id']}}">
        <div class="col">
          <div class="card h-100">
            <div class="card-body">
              <h5 class="card-title">{{$key['nome']}}</h5>
            </div>
          </div>
        </div>
        </a>
      </div>
      @endforeach

    </div>

<?php } ?>



<?php if(isset($vendas_items)){ ?>
<div class="box-carrinho table-itens-garcon">
  <div class="row" style="background: #ececec;padding: 7px 2px 3px 0px;">
    <div class="col-md-12" style="display: flex">  
      <input type="text" class="form-control" id="nome_cliente" name="nome_cliente" placeholder="Nome do cliente" value="<?php echo $venda['nome_cliente']; ?>" required="true" style="margin: 0px 5px 5px 5px;">
      <meta name="csrf-token" content="{{ csrf_token() }}" />
      <input type="hidden" value="<?php if(isset($venda['id'])){echo $venda['id'];} ?>" id="id_venda">
      <input type="hidden" value="<?php if(isset($venda['id_mesa'])){echo $venda['id_mesa'];} ?>" id="id_mesa">
      <button class="btn btn-success btn-finalizar-garcon" style="margin: 0px 5px 5px 0px;"><i class="fas fa-check"></i></button>
      <?php if($venda['id_status'] == '4'){ ?>
        <button class="btn btn-danger btn-cancelar-mesa" style="margin: 0px 5px 5px 0px;"><i class="fas fa-times"></i></button>
      <?php } ?>
    </div>

    <div class="col-md-12" style="display: flex">
      <input type="checkbox" id="check_nome_cliente" name="check_nome_cliente" required style="margin: 5px 5px 0px 10px;">
      <label for="check_nome_cliente" class="form-label lbl-nao-ifr" style="margin: 0px 0px 10px 0px;">Não informar</label>
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
          if($it['editar'] == 's'){ ?>
            <div class="btn btn-danger btn-remove-prod" data-id-venda="{{$it['id_venda']}}" data-id-item="{{$it['id_venda_items']}}" onclick="removeItemCarrinho(this)">X</div>
        <?php }} ?>
      </span>

    </li>
    @endforeach

  </ul>


</div>
<?php } ?>

@endsection