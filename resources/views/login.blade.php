
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="{{url('assets/css/bootstrap.min.css')}}">
        <script src="{{url('assets/js/bootstrap.min.js')}}"></script>
        <title>Laravel</title>


    </head>

    <body>
    	
	<div class="container">
		<div class="row justify-content-md-center">

		  	<div class="col-6">

				<h1>Login</h1>
				<form action="authh" method="post">
					@csrf
				  <div class="mb-3">
				    <label for="exampleInputEmail1" name="user" class="form-label">Usuário</label>
				    <input type="email" class="form-control" name="user" id="exampleInputEmail1" aria-describedby="emailHelp">
				  </div>
				  <div class="mb-3">
				    <label for="exampleInputPassword1" name="senha" class="form-label">Senha</label>
				    <input type="password" class="form-control" name="senha" id="exampleInputPassword1">
				  </div>
				  <button type="submit" class="btn btn-primary">Submit</button>
				</form>

			</div>

		</div>
	</div>


 </body>
</html>