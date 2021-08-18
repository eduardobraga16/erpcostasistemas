<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MesasModel;
use App\Models\VendasModel;
use App\Models\CaixasModel;
use App\Models\VendasitemsModel;
use App\Models\FormapagamentosModel;
use App\Models\CategoriasModel;
use App\Models\ProdutosModel;
use App\Models\AberturacaixaModel;

class MesasController extends Controller
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


    public function index()
    {
        $mesas = $this->mesas
        ->paginate(20);

        return view('mesas.index', compact('mesas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        

        return view('mesas.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $data['id_usuario'] = $this->id_usuario;
        $data['ocupada'] = 'n';
        
        try {
            $mesa = $this->mesas->create($data);
            redirect('mesas')->send();
        } catch (Exception $e) {
            
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $mesa = $this->mesas->findOrFail($id);
        } catch (Exception $e) {
            
        }

        return view('mesas.editar', compact('mesa'));
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
        $data = $request->all();
        try {
            $mesa = $this->mesas->findOrFail($id);
            $mesa->update($data);
            redirect('mesas')->send();
        } catch (Exception $e) {
            
        }
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

    public function excluir($id){
        try {
            $mesa = $this->mesas->findOrFail($id);
            $mesa->delete();
            redirect('mesas')->send();
        } catch (Exception $e) {
            
        }
    }


    public function pedidosqrcode($id_estabelecimento){
        $mesas = $this->mesas->where('id_usuario', $this->id_usuario)->orderBy('numero','asc')->get();
        return view('mesas.pedidosqrcode', compact('mesas','id_estabelecimento'));
    }

    public function mesa($id,$id_estabelecimento){
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
            return view('mesas.mesasqrcode', compact('categorias', 'mesa', 'venda', 'vendas_items'));
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
            return view('mesas.categoriasqrcode', compact('produtos', 'mesa', 'venda', 'vendas_items'));
        }
    }

    public function qrcode(){
        return view('mesas.qrcode');
    }
}
