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

class GarconController extends Controller
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
        if(isset($_SESSION['userFuncionarioLogado'])){
            $this->token = $_SESSION['userFuncionarioLogado']['token'];
            $this->id_usuario = $_SESSION['userFuncionarioLogado']['id_usuario'];
        }else{
            redirect('loginGarcon')->send();
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
        $mesas = $this->mesas->where('id_usuario', $this->id_usuario)->orderBy('numero','asc')->get();
        return view('vendas.garcon', compact('mesas'));
    }



    public function mesa($id){
        //$caixasAberto = $this->caixas->where('fechado', 'n')->get()->count();
        /*if(!$caixasAberto){
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
            */

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
                'vendas_items.id_venda','vendas_items.id_produto','vendas_items.observacoes','vendas_items.editar',
                'produtos.nome','produtos.id')
                ->join('produtos', 'vendas_items.id_produto', '=', 'produtos.id')
                ->where('vendas_items.id_venda',$venda['id'])->orderBy('vendas_items.id','desc')->get();
            }else{
                //Abrindo nova venda
                $abrir_venda = $this->vendas->create([
                    'finalizado' => 'n',
                    'id_usuario' => $this->id_usuario,
                    //'id_estabelecimento' => $caixaAbertoAtual['id_estabelecimento'],
                    'id_mesa' => $id,
                    'id_status' => 4,
                    //'id_caixa' => $caixaAbertoAtual['caixa_id'],
                    //'id_funcionario' => $caixaAbertoAtual['id_funcionario'],
                    //'id_abertura_caixa' => $caixaAbertoAtual['id_ab_caixa']

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
        //}

        
    }

    public function categoria($id_mesa,$id){

        /*$caixasAberto = $this->caixas->where('fechado', 'n')->get()->count();
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
            */

            $isVenda = $this->vendas
            ->where('finalizado', 'n')
            ->where('id_mesa', $id_mesa)
            ->get()->count();

            if($isVenda>0){
                $venda = $this->vendas
                ->where('finalizado','n')
                ->where('id_mesa',$id_mesa)->firstOrFail();

                $vendas_items = $this->vendas_items
                ->select('vendas_items.id AS id_venda_items','vendas_items.qtde','vendas_items.preco','vendas_items.editar',
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
    //}



    public function atualizaroff($id){
        $total = $this->vendas->where('id_status','1')->get()->count();
        return response()->json(['resultado'=>$total]);
    }


}
