<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RestaurantesController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProdutosController;
use App\Http\Controllers\VendasController;
use App\Http\Controllers\CaixasController;
use App\Http\Controllers\MovimentacoesController;
use App\Http\Controllers\RelatoriosController;
use App\Http\Controllers\FuncionariosController;
use App\Http\Controllers\MesasController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::name('web')->group(function(){
		session_start();

		Route::get('home', [HomeController::class, 'index']);

		//Produtos
		Route::resource('produtos', ProdutosController::class);
		Route::get('produtos/excluir/{id}', [ProdutosController::class, 'excluir']);
		Route::get('produtos/busca/{busca_nome}', [ProdutosController::class, 'busca']);
		Route::post('produtos/additemcarrinho', [ProdutosController::class, 'additemcarrinho']);
		Route::post('produtos/removeitemcarrinho', [ProdutosController::class, 'removeitemcarrinho']);

		//Caixas
		Route::resource('caixas', CaixasController::class);
		Route::post('caixas/abertura/{id}', [CaixasController::class, 'abertura']);
		Route::post('caixas/fechamento/{id}', [CaixasController::class, 'fechamento']);

		//Movimentaçoes
		Route::resource('movimentacoes', MovimentacoesController::class);
		Route::get('reforco', [MovimentacoesController::class, 'reforco']);
		Route::get('sangria', [MovimentacoesController::class, 'sangria']);

		//Relatorios
		Route::resource('relatorios', RelatoriosController::class);

		//Funcionários
		Route::resource('funcionarios', FuncionariosController::class);
		Route::get('funcionarios/excluir/{id}', [FuncionariosController::class, 'excluir']);

		//Mesas
		Route::resource('mesas', MesasController::class);
		Route::get('mesas/excluir/{id}', [MesasController::class, 'excluir']);
		Route::get('mesas/pedidosqrcode/{id_estabelecimento}', [MesasController::class, 'pedidosqrcode']);
		Route::get('mesas/pedidosqrcode/{id}/{id_estabelecimento}', [MesasController::class, 'mesa']);
		Route::get('mesas/pedidosqrcode/{id_mesa}/categoria/{id}', [MesasController::class, 'categoria']);
		Route::get('qrcode', [MesasController::class, 'qrcode']);

		//PDV
		Route::get('pdv', [VendasController::class, 'pdv']);
		Route::get('garcon', [VendasController::class, 'garcon']);
		Route::get('mesa/{id}', [VendasController::class, 'mesa']);
		Route::get('mesa/{id_mesa}/categoria/{id}', [VendasController::class, 'categoria']);


		//Vendas
		Route::resource('vendas', VendasController::class);
		Route::post('vendas/finalizarvenda/{id}', [VendasController::class, 'finalizarvenda']);
		Route::post('vendas/finalizagarcon/{id}', [VendasController::class, 'finalizagarcon']);
		Route::post('vendas/colocaremespera/{id}', [VendasController::class, 'colocaremespera']);
		Route::post('vendas/cancelar/{id}', [VendasController::class, 'cancelar']);
		Route::post('vendas/cancelarvendamesa/{id}/{id_mesa}', [VendasController::class, 'cancelarvendamesa']);
		
		Route::post('vendas/atualizatotal/{id}', [VendasController::class, 'atualizatotal']);
		Route::get('vendas/comprovante/{id}', [VendasController::class, 'comprovante']);
		Route::get('vendas/comprovanteproducao/{id}', [VendasController::class, 'comprovanteproducao']);
		Route::get('vendas/atualizaroff/{id}', [VendasController::class, 'atualizaroff']);
		
		//Rotas login
		Route::get('login', [LoginController::class, 'login']);
		Route::get('logout', [AuthController::class, 'logout']);
		Route::post('authh', [AuthController::class, 'authh']);

	
});
