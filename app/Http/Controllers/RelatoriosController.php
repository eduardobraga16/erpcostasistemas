<?php

namespace App\Http\Controllers;
//use DB;
use Illuminate\Http\Request;
use App\Models\VendasModel;
use App\Models\CaixasModel;
use App\Models\VendasitemsModel;
use App\Models\FormapagamentosModel;
use App\Models\MovimentacoesModel;
use App\Models\AberturacaixaModel;

class RelatoriosController extends Controller
{
    
    private $token;
    private $id_usuario;
    private $produtos;
    private $vendas;
    private $caixas;
    private $formapagamento;
    private $movimentacoes;
    private $abertura_caixa;

    public function __construct(VendasModel $vendas, CaixasModel $caixas, VendasitemsModel $vendas_items, FormapagamentosModel $formapagamento, MovimentacoesModel $movimentacoes,AberturacaixaModel $abertura_caixa){
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
        $this->abertura_caixa = $abertura_caixa;
    }

    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        switch ($id) {
            case 'movimentacoes':
                $data_inicio = isset($_GET['data-inicio']) ? $_GET['data-inicio'] : date('Y-m-d');
                $data_final = isset($_GET['data-final']) ? $_GET['data-final'] : date('Y-m-d');

                $movimentacoes = $this->movimentacoes
                ->whereBetween('created_at',[$data_inicio." 00:00:00",$data_final." 23:59:59"])
                ->get();

                if(isset($_GET['print'])){
                    return view('relatorios.printmovimentacoes', compact('movimentacoes','data_inicio','data_final'));                    
                }

                return view('relatorios.movimentacoes', compact('movimentacoes'));
                break;
            case 'vendas':
                $data_inicio = isset($_GET['data-inicio']) ? $_GET['data-inicio'] : date('Y-m-d');
                $data_final = isset($_GET['data-final']) ? $_GET['data-final'] : date('Y-m-d');

                $vendas = $this->vendas
                ->select('forma_pagamento.forma','vendas.id','vendas.total','vendas.dinheiro_recebido','vendas.id_status','vendas.created_at','vendas.id_caixa','vendas.nome_cliente')
                ->join('forma_pagamento', 'vendas.forma_pagamento', '=', 'forma_pagamento.id')
                ->whereBetween('created_at',[$data_inicio." 00:00:00",$data_final." 23:59:59"])
                ->get();

                if(isset($_GET['print'])){
                    return view('relatorios.printvendas', compact('vendas','data_inicio','data_final'));                    
                }

                return view('relatorios.vendas', compact('vendas'));
                break;
            case 'caixas':
                $data_inicio = isset($_GET['data-inicio']) ? $_GET['data-inicio'] : date('Y-m-d');
                $data_final = isset($_GET['data-final']) ? $_GET['data-final'] : date('Y-m-d');

                $caixas = $this->abertura_caixa
                ->select('funcionarios.nome','abertura_caixa.id','abertura_caixa.saldo_inicial','abertura_caixa.id_usuario','abertura_caixa.id_funcionario','abertura_caixa.id_estabelecimento','abertura_caixa.created_at','abertura_caixa.updated_at','abertura_caixa.id_caixa','abertura_caixa.fechado','abertura_caixa.fechamento_avista',
                    'caixas.caixa')
                ->join('funcionarios','abertura_caixa.id_funcionario', '=', 'funcionarios.id')
                ->join('caixas','abertura_caixa.id_caixa', '=', 'caixas.id')
                ->whereBetween('created_at',[$data_inicio." 00:00:00",$data_final." 23:59:59"])
                ->get();

                
                

                if(isset($_GET['print'])){
                    $caixa_ab = $this->abertura_caixa
                    ->select('funcionarios.nome',
                            'abertura_caixa.id','abertura_caixa.saldo_inicial','abertura_caixa.id_usuario','abertura_caixa.id_funcionario',
                            'abertura_caixa.id_estabelecimento','abertura_caixa.created_at','abertura_caixa.updated_at',
                            'abertura_caixa.id_caixa','abertura_caixa.fechado',
                            'abertura_caixa.cartao_credito','abertura_caixa.cartao_debito','abertura_caixa.pix',
                            'abertura_caixa.fechamento_avista','abertura_caixa.fechamento_credito','abertura_caixa.fechamento_debito','abertura_caixa.fechamento_pix',
                            'abertura_caixa.saldo_em_caixa','caixas.caixa')
                    ->join('funcionarios','abertura_caixa.id_funcionario', '=', 'funcionarios.id')
                    ->join('caixas','abertura_caixa.id_caixa', '=', 'caixas.id')
                    ->findOrFail($_GET['id']);
                    $movimentacoes_caixa = $this->movimentacoes->where('id_abertura_caixa',$caixa_ab['id'])->get();
                    return view('relatorios.printcaixas', compact('caixa_ab','movimentacoes_caixa'));                    
                }else{
                    return view('relatorios.caixas', compact('caixas'));
                }
                break;
            case 'vendasitens':
                $data_inicio = isset($_GET['data-inicio']) ? $_GET['data-inicio'] : date('Y-m-d');
                $data_final = isset($_GET['data-final']) ? $_GET['data-final'] : date('Y-m-d');

                $items = $this->vendas_items
                ->select([
                    'vendas_items.id_produto',
                    'vendas_items.preco',
                    //\DB::raw('SUM(vendas_items.preco) as total'),
                    \DB::raw('SUM(vendas_items.qtde) as qtde_total'),
                    'produtos.nome'
                ])
                ->join('produtos', 'vendas_items.id_produto', '=', 'produtos.id')
                ->join('vendas', 'vendas_items.id_venda', '=', 'vendas.id')
                ->where('vendas.id_status','=','2')
                ->groupBy('vendas_items.id_produto','produtos.nome','vendas_items.preco')
                ->whereBetween('vendas.created_at',[$data_inicio." 00:00:00",$data_final." 23:59:59"])
                ->get();

                if(isset($_GET['print'])){
                    return view('relatorios.printvendasitens', compact('items','data_inicio','data_final'));                    
                }

                return view('relatorios.vendasitems', compact('items'));
                break;

            default:
                echo "nenhum";
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    public function vendas(){
        echo "teste";
    }
}
