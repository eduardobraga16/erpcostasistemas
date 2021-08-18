<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
	private $token;
	public function __construct(){
        if(isset($_SESSION['tokenCS'])){
            $this->token = $_SESSION['tokenCS'];
        	//redirect('home')->send();
        }else{
        	//redirect('login')->send();
        }
    }
    
    public function authh(Request $request){
    	

    	$user = $request->get("user");
    	$senha =  $request->get("senha");

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
        

        //echo "<script>localStorage.setItem('tokenCS','".$response->json()['token']."');</script>";
        //$_SESSION['tokenCS'] = $response->json()['token'];
        redirect('home')->send();
    }

    public function logout()
    {
        $token = $this->token;
        $response = Http::acceptJson()
            ->withToken($token)
            ->get('https://costasistemas.club/api/public/api/v1/logout')
            ->throw(function ($response, $e){
                echo response()->json('Erro ao sair');exit;
        });
        unset($_SESSION['tokenCS']);
        redirect('login')->send();
    }
}
