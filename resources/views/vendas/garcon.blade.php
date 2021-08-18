@extends('template.templategarcon')
@section('content')


<br />
     <h1>Mesas</h1>
     <br />
    <div class="row row-cols-1 row-cols-md-3 g-4">
     
      @foreach($mesas as $key)
      <?php if($key['ocupada'] == 's'){
        $titulo = " - Ocupada"; $cor_fundo = 'card-body-ocupada'; ?>
        <div class="card-body-full">
          <a href="{{url('/mesa')}}/{{$key['id']}}">
          <div class="col">
            <div class="card h-100">
              <div class="card-body {{$cor_fundo}}">
                <h5 class="card-title">{{$key['numero']}}{{$titulo}}</h5>
              </div>
            </div>
          </div>
          </a>
        </div>
      <?php }else{ 
        $titulo = " - Disponível";$cor_fundo =""; ?>
        <div class="card-body-full">
        <a href="{{url('/mesa')}}/{{$key['id']}}">
          <div class="col">
            <div class="card h-100">
              <div class="card-body {{$cor_fundo}}">
                <h5 class="card-title">{{$key['numero']}}{{$titulo}}</h5>
              </div>
            </div>
          </div>
        </a>
        </div>
      <?php } ?>
      @endforeach

    </div>




@endsection


<script>
setInterval(function(){
  location.reload();
}, 12000);
</script>