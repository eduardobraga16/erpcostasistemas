<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VendasModel;
use App\Models\CaixasModel;
use App\Models\VendasitemsModel;
use App\Models\FormapagamentosModel;
use App\Models\CategoriasModel;
use App\Models\ProdutosModel;
use App\Models\MesasModel;
use App\Models\AberturacaixaModel;

class VendasController extends Controller
{
    
    private $token;
    private $id_usuario;
    private $produtos;
    private $vendas;
    private $caixas;
    private $formapagamento;
    private $mesas;
    private $abertura_caixa;

    public function __construct(VendasModel $vendas, CaixasModel $caixas, VendasitemsModel $vendas_items, FormapagamentosModel $formapagamento, CategoriasModel $categorias, ProdutosModel $produtos, MesasModel $mesas,AberturacaixaModel $abertura_caixa){
        if(isset($_SESSION['userLogado'])){
            $this->token = $_SESSION['userLogado']['token'];
            $this->id_usuario = $_SESSION['userLogado']['id'];
        }else{
            redirect('login')->send();
        }

        $this->vendas           = $vendas;
        $this->caixas           = $caixas;
        $this->vendas_items     = $vendas_items;
        $this->formapagamento   = $formapagamento;
        $this->categorias       = $categorias;
        $this->produtos         = $produtos;
        $this->mesas            = $mesas;
        $this->abertura_caixa   = $abertura_caixa;
    }

    public function index(Request $request)
    {
        $data_inicio = isset($_GET['data-inicio']) ? $_GET['data-inicio'] : date('Y-m-d');
        $data_final = isset($_GET['data-final']) ? $_GET['data-final'] : date('Y-m-d');
        //$vendas = $this->vendas->where('id_status','<>','2')->orderBy('id','desc')->paginate(15);
        $vendas = $this->vendas
        ->select('funcionarios.nome',
        'vendas.id','vendas.nome_cliente','vendas.finalizado','vendas.total','vendas.forma_pagamento','vendas.dinheiro_recebido','vendas.troco','vendas.created_at','vendas.id_mesa','vendas.id_status','vendas.id_caixa')
        ->join('funcionarios', 'vendas.id_funcionario', '=','funcionarios.id')
        ->whereBetween('vendas.created_at',[$data_inicio." 00:00:00",$data_final." 23:59:59"])
        ->orderBy('vendas.id','desc')->paginate(25);

        $caixasAberto = $this->caixas->where('fechado', 'n')->get()->count();
        if(!$caixasAberto){
           redirect('caixas')->send();
        }
        $total = $this->vendas->where('id_status','1')->get()->count();
        return view('vendas.index', compact('vendas','total'));
    }


    public function create(){}

    public function store(Request $request){}

    public function show($id){}

    public function edit($id)
    {
        $venda = $this->vendas->findOrFail($id);
        $formaspagamento = $this->formapagamento->all();

        $vendas_items = $this->vendas_items
        ->select('vendas_items.id AS id_venda_items','vendas_items.qtde','vendas_items.preco',
        'vendas_items.id_venda','vendas_items.id_produto',
        'produtos.nome','produtos.id')
        ->join('produtos', 'vendas_items.id_produto', '=', 'produtos.id')
        ->where('vendas_items.id_venda',$venda['id'])->orderBy('vendas_items.id','desc')->get();

        return view('vendas.editar', compact('venda','vendas_items','formaspagamento'));
    }

    public function update(Request $request, $id){}

    public function destroy($id){}

    public function pdv(){
        $formaspagamento = $this->formapagamento->all();

        $caixasAberto = $this->caixas->where('fechado', 'n')->get()->count();
        if(!$caixasAberto){
           redirect('caixas')->send();
        }else{
            $caixaAbertoAtual = $this->caixas
            ->select('caixas.id as caixa_id','caixas.caixa',
                'abertura_caixa.id AS id_ab_caixa','abertura_caixa.id_funcionario',
                'abertura_caixa.created_at','abertura_caixa.updated_at','abertura_caixa.saldo_inicial','abertura_caixa.fechamento_avista', 'abertura_caixa.id_estabelecimento',
                'funcionarios.nome AS nomeFuncionario')
            ->join('abertura_caixa', 'caixas.id', '=', 'abertura_caixa.id_caixa')
            ->join('funcionarios', 'abertura_caixa.id_funcionario', '=', 'funcionarios.id')
            ->where('caixas.fechado', 'n')
            ->where('abertura_caixa.fechado', 'n')
            ->firstOrFail();

            $isVenda = $this->vendas->where('finalizado', 'n')->get()->count();

            if($isVenda>0){
                $venda = $this->vendas->where('finalizado','n')->firstOrFail();
                $vendas_items = $this->vendas_items
                ->select('vendas_items.id AS id_venda_items','vendas_items.qtde','vendas_items.preco',
                'vendas_items.id_venda','vendas_items.id_produto',
                'produtos.nome','produtos.id')
                ->join('produtos', 'vendas_items.id_produto', '=', 'produtos.id')
                ->where('vendas_items.id_venda',$venda['id'])->orderBy('vendas_items.id','desc')->get();
            }else{
                //Abrindo nova venda
                $abrir_venda = $this->vendas->create([
                    'finalizado' => 'n',
                    'id_usuario' => $this->id_usuario,
                    'id_estabelecimento' => $caixaAbertoAtual['id_estabelecimento'],
                    'id_status' => 4,
                    'id_caixa' => $caixaAbertoAtual['caixa_id'],
                    'id_abertura_caixa' => $caixaAbertoAtual['id_ab_caixa'],
                    'id_funcionario' => $caixaAbertoAtual['id_funcionario'],
                ]);

                $venda = $this->vendas->findOrFail($abrir_venda->id);
                $vendas_items = $this->vendas_items
                ->select('vendas_items.id AS id_venda_items','vendas_items.qtde','vendas_items.preco',
                'vendas_items.id_venda','vendas_items.id_produto',
                'produtos.nome','produtos.id')
                ->join('produtos', 'vendas_items.id_produto', '=', 'produtos.id')
                ->where('vendas_items.id_venda',$venda['id'])->orderBy('vendas_items.id','desc')
                ->get();
            }
        }
        return view('vendas.pdv', compact('venda','vendas_items','formaspagamento'));
    }


    public function finalizarvenda(Request $request, $id){
        $venda = $this->vendas->findOrFail($id);
        $venda->update([
            'nome_cliente' => $request->get('nome_cliente'),
            'finalizado' => 's',
            'forma_pagamento' => $request->get('forma_pagamento'),
            'dinheiro_recebido' => $request->get('valor_recebido'),
            'troco' => $request->get('troco'),
            'id_status' => 2
        ]);
        if(!$venda['id_mesa'] == ""){
            $mesa = $this->mesas->findOrFail($venda['id_mesa']);
            $mesa->update(['ocupada' => 'n']);
        }

        switch ($venda['forma_pagamento']) {
            case '1':
                $ab_caixa = $this->abertura_caixa->findOrFail($venda['id_abertura_caixa']);
                $total_no_caixa = $ab_caixa['saldo_em_caixa']+$venda['total'];
                $ab_caixa->update([
                    'saldo_em_caixa' => $total_no_caixa
                ]);
                break;
            case '2':
                $ab_caixa = $this->abertura_caixa->findOrFail($venda['id_abertura_caixa']);
                $total_no_caixa = $ab_caixa['cartao_credito']+$venda['total'];
                $ab_caixa->update([
                    'cartao_credito' => $total_no_caixa
                ]);
                break;
            case '3':
                $ab_caixa = $this->abertura_caixa->findOrFail($venda['id_abertura_caixa']);
                $total_no_caixa = $ab_caixa['cartao_debito']+$venda['total'];
                $ab_caixa->update([
                    'cartao_debito' => $total_no_caixa
                ]);
                break;
            case '4':
                $ab_caixa = $this->abertura_caixa->findOrFail($venda['id_abertura_caixa']);
                $total_no_caixa = $ab_caixa['pix']+$venda['total'];
                $ab_caixa->update([
                    'pix' => $total_no_caixa
                ]);
                break;
            default:
            echo "nenhum";
        }

        redirect('vendas')->send();
    }

    public function colocaremespera(Request $request,$id_venda){
        $venda = $this->vendas->findOrFail($id_venda);
        $venda->update([
            'nome_cliente' => $request->get('nome_cliente'),
            'finalizado' => 'n',
            'id_status' => 1
        ]);
        return response()->json("foi");
    }

    public function cancelarvendamesa($id_venda, $id_mesa){
        $venda = $this->vendas->findOrFail($id_venda);
        if($venda['id_status'] == '4'){
            $venda->update([
                'finalizado' => 's',
                'id_status' => 3
            ]);
        }

        
        $mesa = $this->mesas->findOrFail($id_mesa);
        $mesa->update(['ocupada'=>'n']);
        
        return response()->json("foi");
    }

    public function cancelar($id_venda){
        $venda = $this->vendas->findOrFail($id_venda);
        if($venda['id_status'] == '4' || $venda['id_status'] == '1'){
            $venda->update([
                'finalizado' => 's',
                'id_status' => 3
            ]);
        }
        return response()->json("foi");
    }

    public function finalizagarcon(Request $request, $id_venda){
        $venda = $this->vendas->findOrFail($id_venda);
        $venda->update([
            'nome_cliente' => $request->get('nome_cliente'),
            'finalizado' => 'n',
            'id_status' => 1
        ]);
        return response()->json("foi");
    }

    public function atualizatotal($id_venda){
        $vendas_items = $this->vendas_items->where('id_venda',$id_venda)->get();
        $total = 0;
        foreach ($vendas_items as $key) {
            $total += $key['qtde']*$key['preco'];
        }
        $venda = $this->vendas->findOrFail($id_venda);
        $venda->update([
            'total' => $total
        ]);

        return response()->json($total);
    }

    public function comprovante($id_venda){
        $venda = $this->vendas->findOrFail($id_venda);
        $items = $this->vendas_items
        ->select('vendas_items.id AS id_venda_items','vendas_items.qtde','vendas_items.preco',
                'vendas_items.id_venda','vendas_items.id_produto',
                'produtos.nome','produtos.id')
                ->join('produtos', 'vendas_items.id_produto', '=', 'produtos.id')
        ->where('vendas_items.id_venda',$id_venda)->get();
        return view('vendas.comprovante', compact('venda','items'));
    }

    public function comprovanteproducao($id_venda){
        $venda = $this->vendas->findOrFail($id_venda);
        $items = $this->vendas_items
        ->select('vendas_items.id AS id_venda_items','vendas_items.qtde','vendas_items.preco',
                'vendas_items.id_venda','vendas_items.id_produto',
                'produtos.nome','produtos.id')
                ->join('produtos', 'vendas_items.id_produto', '=', 'produtos.id')
        ->where('vendas_items.id_venda',$id_venda)->get();
        return view('vendas.comprovante', compact('venda','items'));
    }





    ////////////////////////Garçon pedidos
    public function garcon(){
        $mesas = $this->mesas->where('id_usuario', $this->id_usuario)->orderBy('numero','asc')->get();
        return view('vendas.garcon', compact('mesas'));
    }

    public function mesa($id){
        $caixasAberto = $this->caixas->where('fechado', 'n')->get()->count();
        if(!$caixasAberto){
            $titulo = "Nenhum caixa Aberto!";
            return view('vendas.mesa', compact('titulo'));
        }else{
            $caixaAbertoAtual = $this->caixas
            ->select('caixas.id as caixa_id','caixas.caixa',
                'abertura_caixa.id AS id_ab_caixa','abertura_caixa.id_funcionario',
                'abertura_caixa.created_at','abertura_caixa.updated_at','abertura_caixa.saldo_inicial','abertura_caixa.fechamento_avista', 'abertura_caixa.id_estabelecimento',
                'funcionarios.nome AS nomeFuncionario')
            ->join('abertura_caixa', 'caixas.id', '=', 'abertura_caixa.id_caixa')
            ->join('funcionarios', 'abertura_caixa.id_funcionario', '=', 'funcionarios.id')
            ->where('caixas.fechado', 'n')
            ->where('abertura_caixa.fechado', 'n')
            ->firstOrFail();

            $isVenda = $this->vendas
            ->where('finalizado', 'n')
            ->where('id_mesa', $id)
            ->get()->count();

            if($isVenda>0){
                $venda = $this->vendas
                ->where('finalizado','n')
                ->where('id_mesa',$id)->firstOrFail();

                $vendas_items = $this->vendas_items
                ->select('vendas_items.id AS id_venda_items','vendas_items.qtde','vendas_items.preco',
                'vendas_items.id_venda','vendas_items.id_produto','vendas_items.observacoes',
                'produtos.nome','produtos.id')
                ->join('produtos', 'vendas_items.id_produto', '=', 'produtos.id')
                ->where('vendas_items.id_venda',$venda['id'])->orderBy('vendas_items.id','desc')->get();
            }else{
                //Abrindo nova venda
                $abrir_venda = $this->vendas->create([
                    'finalizado' => 'n',
                    'id_usuario' => $this->id_usuario,
                    'id_estabelecimento' => $caixaAbertoAtual['id_estabelecimento'],
                    'id_mesa' => $id,
                    'id_status' => 4,
                    'id_caixa' => $caixaAbertoAtual['caixa_id'],
                    'id_funcionario' => $caixaAbertoAtual['id_funcionario'],
                    'id_abertura_caixa' => $caixaAbertoAtual['id_ab_caixa']

                ]);

                $venda = $this->vendas->findOrFail($abrir_venda->id);
                $vendas_items = $this->vendas_items
                ->select('vendas_items.id AS id_venda_items','vendas_items.qtde','vendas_items.preco',
                'vendas_items.id_venda','vendas_items.id_produto','vendas_items.observacoes',
                'produtos.nome','produtos.id')
                ->join('produtos', 'vendas_items.id_produto', '=', 'produtos.id')
                ->where('vendas_items.id_venda',$venda['id'])->orderBy('vendas_items.id','desc')
                ->get();
            }

            $categorias = $this->categorias->all();
            $mesa = $this->mesas->findOrFail($id);
            $mesa->update([
                'ocupada' => 's'
            ]);
            return view('vendas.mesa', compact('categorias', 'mesa', 'venda', 'vendas_items'));
        }

        
    }

    public function categoria($id_mesa,$id){

        $caixasAberto = $this->caixas->where('fechado', 'n')->get()->count();
        if(!$caixasAberto){
            redirect('garcon')->send();
        }else{
            $caixaAbertoAtual = $this->caixas
            ->select('caixas.id as caixa_id','caixas.caixa',
                'abertura_caixa.id AS id_ab_caixa','abertura_caixa.id_funcionario',
                'abertura_caixa.created_at','abertura_caixa.updated_at','abertura_caixa.saldo_inicial','abertura_caixa.fechamento_avista', 'abertura_caixa.id_estabelecimento',
                'funcionarios.nome AS nomeFuncionario')
            ->join('abertura_caixa', 'caixas.id', '=', 'abertura_caixa.id_caixa')
            ->join('funcionarios', 'abertura_caixa.id_funcionario', '=', 'funcionarios.id')
            ->where('caixas.fechado', 'n')
            ->where('abertura_caixa.fechado', 'n')
            ->firstOrFail();

            $isVenda = $this->vendas
            ->where('finalizado', 'n')
            ->where('id_mesa', $id_mesa)
            ->get()->count();

            if($isVenda>0){
                $venda = $this->vendas
                ->where('finalizado','n')
                ->where('id_mesa',$id_mesa)->firstOrFail();

                $vendas_items = $this->vendas_items
                ->select('vendas_items.id AS id_venda_items','vendas_items.qtde','vendas_items.preco',
                'vendas_items.id_venda','vendas_items.id_produto','vendas_items.observacoes',
                'produtos.nome','produtos.id')
                ->join('produtos', 'vendas_items.id_produto', '=', 'produtos.id')
                ->where('vendas_items.id_venda',$venda['id'])->orderBy('vendas_items.id','desc')->get();
            }else{
                redirect('garcon')->send();
            }

            $categorias = $this->categorias->all();
            $mesa = $this->mesas->findOrFail($id);
            $produtos = $this->produtos->where('id_categoria', $id)->get();
            return view('vendas.categoriasgarcon', compact('produtos', 'mesa', 'venda', 'vendas_items'));
        }
    }



    public function atualizaroff($id){
        $total = $this->vendas->where('id_status','1')->get()->count();
        return response()->json(['resultado'=>$total]);
    }


}
