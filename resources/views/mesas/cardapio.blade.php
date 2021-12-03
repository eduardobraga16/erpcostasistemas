@extends('template.templategarcon')
@section('content')


     <h1>Categorias</h1>
     <h2 style="color: #a9a9a9;font-size: 19px;">Escolha uma categoria</h2>
    <br />
    <div class="row row-cols-1 row-cols-md-3 g-4">
     
      @foreach($categorias as $key)
      <div class="card-body-full">
        <a href="{{url('cardapiocategoria')}}/{{$key['id']}}">
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






@endsection