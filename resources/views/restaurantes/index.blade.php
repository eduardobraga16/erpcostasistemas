@extends('template.template')

@section('content')

<h1>Restuarantes</h1>

<table class="table">
  <thead>
    <tr>
      <th scope="col">ID</th>
      <th scope="col">Nome</th>
      <th scope="col">Endereço</th>
      <th scope="col">Bairro</th>
      <th scope="col">Complemento</th>
      <th scope="col">Número</th>
      <th scope="col">Cidade</th>
      <th scope="col">Data Cadastrado</th>
    </tr>
  </thead>
  <tbody>


  	@foreach($restaurantes['data'] as $key)
	  	<tr>
	      <th>{{$key['id']}}</th>
	      <td>{{$key['nome']}}</td>
	      <td>{{$key['endereco']}}</td>
	      <td>{{$key['bairro']}}</td>
	      <td>{{$key['complemento']}}</td>
	      <td>{{$key['numero']}}</td>
	      <td>{{$key['id_cidade']}}</td>
	      <td>{{$key['created_at']}}</td>
	    </tr>
  		
  	@endforeach

  	
    

  </tbody>
</table>


@endsection