<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\User;
use App\Models\FuncionariosModel;

class AuthController extends Controller
{
	private $token;
    private $usuario;
    private $funcionario;

	public function __construct(User $usuario, FuncionariosModel $funcionario){
        if(isset($_SESSION['userLogado'])){
            $this->token = $_SESSION['userLogado'];
        	//redirect('home')->send();
        }else{
        	//redirect('login')->send();
        }

        $this->usuario = $usuario;
        $this->funcionario = $funcionario;
    }
    
    public function authh(Request $request){
    	$email = $request->get("email");
    	$password =  $request->get("senha");




        if (!empty($email) && !empty($password) ) {
            try {
                $busca_user = $this->usuario->whereRaw(" email = '".$email."' ")->first();
            } catch (Exception $e) {echo $e->getMessage();}

            if(!empty($busca_user)){
                if($password == $busca_user['password']){
                    $id         =  $busca_user["id"];
                    $name         =  $busca_user["name"];
                    $email         =  $busca_user["email"];
                    $token       =  $busca_user["remember_token"];

                    $dadosUserLogado = array(
                        "id"    => $id,
                        "nome"  => $name,
                        "email" => $email,
                        "token" => $token
                    );

                    $_SESSION["userLogado"] = $dadosUserLogado; 

                    redirect('home')->send();
                }else{
                    //$flash['error'] = "Senha incorreta!";
                    //$app->flash('error', 'Senha incorreta!');
                    redirect('login')->send();
                }
            }else{
                //$flash['error'] = "Usuário não encontrado!";
                redirect('login')->send();
            }

        }else{
            //$flash['error'] = "Preencha todos os campos!";
            redirect('login')->send();
        }

        /*
    	$response = Http::acceptJson()
            ->post('https://costasistemas.club/api/public/api/v1/login', [
			    'email' => $user,
			    'password' => $senha
			])
            ->throw(function ($response, $e){
                echo response()->json('Erro');exit;
        });
        $dadosUserLogado = array(
            "token" => $response->json()['token'],
            "id"    => $response->json()['id'],
            "nome"  => $response->json()['nome'],
            "email" => $response->json()['email']
        );
        $_SESSION['userLogado'] = $dadosUserLogado;
        
    */
        //echo "<script>localStorage.setItem('tokenCS','".$response->json()['token']."');</script>";
        //$_SESSION['tokenCS'] = $response->json()['token'];
      //  redirect('home')->send();
    }


    public function authhGarcon(Request $request){
        $email = $request->get("email");
        $password =  $request->get("senha");




        if (!empty($email) && !empty($password) ) {
            try {
                $busca_user = $this->funcionario->whereRaw(" usuario = '".$email."' ")->first();
            } catch (Exception $e) {echo $e->getMessage();}

            if(!empty($busca_user)){
                if($password == $busca_user['senha']){
                    $id         =  $busca_user["id"];
                    $id_usuario         =  $busca_user["id_usuario"];
                    $name         =  $busca_user["nome"];
                    $usuario         =  $busca_user["usuario"];
                    $token       =  $busca_user["token"];

                    $dadosUserLogado = array(
                        "id"    => $id,
                        "id_usuario"    => $id_usuario,
                        "nome"  => $name,
                        "email" => $usuario,
                        "token" => $token
                    );

                    $_SESSION["userFuncionarioLogado"] = $dadosUserLogado; 

                    redirect('garcon')->send();
                }else{
                    //$flash['error'] = "Senha incorreta!";
                    //$app->flash('error', 'Senha incorreta!');

                    redirect('loginGarcon')->send();
                }
            }else{
                //$flash['error'] = "Usuário não encontrado!";
                redirect('loginGarcon')->send();
            }

        }else{
            //$flash['error'] = "Preencha todos os campos!";
            redirect('loginGarcon')->send();
        }

        /*
        $response = Http::acceptJson()
            ->post('https://costasistemas.club/api/public/api/v1/login', [
                'email' => $user,
                'password' => $senha
            ])
            ->throw(function ($response, $e){
                echo response()->json('Erro');exit;
        });
        $dadosUserLogado = array(
            "token" => $response->json()['token'],
            "id"    => $response->json()['id'],
            "nome"  => $response->json()['nome'],
            "email" => $response->json()['email']
        );
        $_SESSION['userLogado'] = $dadosUserLogado;
        
    */
        //echo "<script>localStorage.setItem('tokenCS','".$response->json()['token']."');</script>";
        //$_SESSION['tokenCS'] = $response->json()['token'];
      //  redirect('home')->send();
    }

    public function logout()
    {
        unset($_SESSION['userLogado']);
        redirect('login')->send();
    }
}
