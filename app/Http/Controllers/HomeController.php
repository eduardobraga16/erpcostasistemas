<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VendasModel;
use App\Models\CaixasModel;
use App\Models\VendasitemsModel;
use App\Models\FormapagamentosModel;
use App\Models\MovimentacoesModel;

class HomeController extends Controller
{
	private $token;
    private $id_usuario;
    private $produtos;
    private $vendas;
    private $caixas;
    private $formapagamento;
    private $movimentacoes;

    public function __construct(VendasModel $vendas, CaixasModel $caixas, VendasitemsModel $vendas_items, FormapagamentosModel $formapagamento, MovimentacoesModel $movimentacoes){
        if(isset($_SESSION['userLogado'])){
            $this->token = $_SESSION['userLogado']['token'];
            $this->id_usuario = $_SESSION['userLogado']['id'];
        }else{
            redirect('login')->send();
        }

        $this->vendas = $vendas;
        $this->caixas = $caixas;
        $this->vendas_items = $vendas_items;
        $this->formapagamento = $formapagamento;
        $this->movimentacoes = $movimentacoes;
    }

    public function index(){

        $data_atual = date('Y-m-d');
        $data_final = date('Y-m-d G:i:s');
        

        $vendas_de_hoje = $this->vendas
        ->where('id_status','2')
        ->whereBetween('created_at',[$data_atual, $data_final])
        ->get();

        $valor_vendido_hoje = 0;
        foreach ($vendas_de_hoje as $key) {
            $valor_vendido_hoje += $key['total'];
        }


    	return view('index',compact('valor_vendido_hoje'));
    }
}
