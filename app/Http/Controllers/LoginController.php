<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
	public function __construct(){
        if(isset($_SESSION['userLogado'])){
        	redirect('home')->send();
        }else{
        	//redirect('login')->send();
        }
    }

    public function login(){
    	return  view('login');
    }
}
