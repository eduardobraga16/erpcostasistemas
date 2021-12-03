<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VendasModel;
use App\Models\CaixasModel;
use App\Models\VendasitemsModel;
use App\Models\FormapagamentosModel;
use App\Models\MovimentacoesModel;
use App\Models\AberturacaixaModel;

class MovimentacoesController extends Controller
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
        $this->abertura_caixa   = $abertura_caixa;
    }

    public function index()
    {
     /*   $movimentacoes = $this->movimentacoes
        ->select('funcionarios.nome','movimentacoes.id','movimentacoes.tipo','movimentacoes.valor','movimentacoes.id_usuario','movimentacoes.id_funcionario','movimentacoes.id_estabelecimento'
        ,'movimentacoes.id_caixa','movimentacoes.created_at','movimentacoes.updated_at','movimentacoes.id_abertura_caixa')
        ->join('funcionarios','movimentacoes.id_funcionario','=','funcionarios.id')
        ->orderBy('id','desc')
        ->paginate(20);

        return view('movimentacoes.index', compact('movimentacoes'));*/
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $caixasAberto = $this->caixas->where('fechado', 'n')->get()->count();
        if(!$caixasAberto){
           redirect('caixas')->send();
        }else{
           
            
            $caixaAbertoAtual = $this->caixas
            ->select('caixas.id as caixa_id','caixas.caixa',
                'abertura_caixa.id AS id_ab_caixa','abertura_caixa.id_funcionario',
                'abertura_caixa.created_at','abertura_caixa.updated_at','abertura_caixa.saldo_inicial','abertura_caixa.fechamento_avista', 'abertura_caixa.id_estabelecimento','abertura_caixa.id_caixa AS id_caixa_join',
                'funcionarios.nome AS nomeFuncionario')
            ->join('abertura_caixa', 'caixas.id', '=', 'abertura_caixa.id_caixa')
            ->join('funcionarios', 'abertura_caixa.id_funcionario', '=', 'funcionarios.id')
            ->where('caixas.fechado', 'n')
            ->where('abertura_caixa.fechado', 'n')
            ->firstOrFail();

            $id_caixa_aberto = $caixaAbertoAtual['id_caixa_join'];
            $valor_inicial = $caixaAbertoAtual['saldo_inicial'];
            $data_abertura = $caixaAbertoAtual['created_at'];
            $data_fechamento = $caixaAbertoAtual['updated_at'];

            $vendas_deste_caixa = $this->vendas
            ->where('id_caixa',$id_caixa_aberto)
            ->where('id_status','2')
            ->where('created_at','>=',$data_abertura)
            ->get();

            $valor_em_caixa = $valor_inicial;
            foreach ($vendas_deste_caixa as $key) {
                $valor_em_caixa += $key['total'];
            }


            return view('movimentacoes.reforco', compact('caixaAbertoAtual','valor_em_caixa'));
            
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        try {

            if($request->get('tipo') == 'e'){
                /*
                $ab_caixa = $this->abertura_caixa->findOrFail($request->get('id'));
                $total_no_caixa = $ab_caixa['saldo_em_caixa']+$request->get('valor');
                $ab_caixa->update([
                    'saldo_em_caixa' => $total_no_caixa
                ]);
                */
                $movimentacao = $this->movimentacoes->create([
                    'tipo'                  => $request->get('tipo'),
                    'valor'                 => $request->get('valor'),
                    'motivo'                 => $request->get('motivo'),
                    'id_usuario'            => $this->id_usuario,
                    'id_funcionario'        => $request->get('id_funcionario'),
                    'id_estabelecimento'    => $request->get('id_estabelecimento'),
                    'id_caixa'              => $request->get('id_caixa'),
                    'id_abertura_caixa'     => $request->get('id')
                ]);
                return response()->json(['resultado'=>'Movimentação feita com sucesso!']);
                //redirect('movimentacoes/create?tipo=e')->send();
            }else{
                
                $ab_caixa = $this->abertura_caixa->findOrFail($request->get('id'));
                if($ab_caixa['saldo_em_caixa'] < $request->get('valor')){
                    return response()->json(['resultado'=>'Saldo Em caixa menor do que valor solicitado!']);
                }else{
                    /*$total_no_caixa = $ab_caixa['saldo_em_caixa']-$request->get('valor');
                    $ab_caixa->update([
                        'saldo_em_caixa' => $total_no_caixa
                    ]);
                    */
                    $movimentacao = $this->movimentacoes->create([
                        'tipo'                  => $request->get('tipo'),
                        'valor'                 => $request->get('valor'),
                        'motivo'                 => $request->get('motivo'),
                        'id_usuario'            => $this->id_usuario,
                        'id_funcionario'        => $request->get('id_funcionario'),
                        'id_estabelecimento'    => $request->get('id_estabelecimento'),
                        'id_caixa'              => $request->get('id_caixa'),
                        'id_abertura_caixa'     => $request->get('id')
                    ]);
                    return response()->json(['resultado'=>'Movimentação feita com sucesso!']);
                }
//                redirect('movimentacoes/create?tipo=s')->send();
            }

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
        echo "show";
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        echo "edit";
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



 

    public function sangria(Request $request){
        echo "chegou";
    }

    public function movimentacoes(){

    }


}
