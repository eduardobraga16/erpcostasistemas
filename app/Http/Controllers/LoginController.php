<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
	public function __construct(){
        
    }

    public function login(){
        if(isset($_SESSION['userLogado'])){
            redirect('home')->send();
        }else{
            //redirect('login')->send();
        }
    	return  view('login');
    }

    public function loginGarcon(){
        if(isset($_SESSION['userFuncionarioLogado'])){
            redirect('garcon')->send();
        }else{
            //redirect('login')->send();
        }
        return  view('login_garcon');
    }
}
