@extends('template.templategarcon')
@section('content')


     <h1>Produtos</h1>
    <br />
    <div class="row row-cols-1 row-cols-md-3 g-4">
     
      @foreach($produtos as $key)
      <div class="card-body-full">
        
        <div class="col">
          <div class="card h-100">
            <div class="card-body">
              <h5 class="card-title">{{$key['nome']}}</h5>
              <h6 class="card-title">R$ {{moedaBr($key['preco'])}}</h6>
            </div>
          </div>
        </div>
        
      </div>
      @endforeach

    </div>






@endsection