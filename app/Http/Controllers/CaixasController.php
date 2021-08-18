<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CaixasModel;
use App\Models\AberturacaixaModel;
use App\Models\FuncionariosModel;
use App\Models\EstabelecimentosModel;

class CaixasController extends Controller
{
    
    private $token;
    private $id_usuario;
    private $produtos;
    private $caixas;
    private $abertura_caixa;
    private $funcionarios;
    private $estabelecimentos;

    public function __construct(CaixasModel $caixas, AberturacaixaModel $abertura_caixa, FuncionariosModel $funcionarios, EstabelecimentosModel $estabelecimentos){
        if(isset($_SESSION['userLogado'])){
            $this->token = $_SESSION['userLogado']['token'];
            $this->id_usuario = $_SESSION['userLogado']['id'];
        }else{
            redirect('login')->send();
        }

        $this->caixas = $caixas;
        $this->abertura_caixa = $abertura_caixa;
        $this->funcionarios = $funcionarios;
        $this->estabelecimentos = $estabelecimentos;
    }

    public function index()
    {
        $caixas = $this->caixas->orderBy('caixa','asc')->get();

        $caixasAberto = $this->caixas->where('fechado', 'n')->get()->count();
        
        if($caixasAberto > 0){
            $caixaAbertoList = $this->caixas
            ->select('caixas.id','caixas.caixa',
                'abertura_caixa.id AS id_ab_caixa','abertura_caixa.id_funcionario',
                'abertura_caixa.created_at','abertura_caixa.updated_at','abertura_caixa.saldo_inicial','abertura_caixa.fechamento_avista',
                'funcionarios.nome AS nomeFuncionario')
            ->join('abertura_caixa', 'caixas.id', '=', 'abertura_caixa.id_caixa')
            ->join('funcionarios', 'abertura_caixa.id_funcionario', '=', 'funcionarios.id')
            ->where('caixas.fechado', 'n')
            ->where('abertura_caixa.fechado', 'n')
            ->get();
            //$caixa_informações = $this->abertura_caixa->where('id_caixa',$caixaAberto['id'])->firstOrFail();
        }else{
            //$caixa_informações = null;
            $caixaAbertoList = null;
        }

        $funcionarios = $this->funcionarios->where('operando','n')->get();
        $estabelecimentos = $this->estabelecimentos->all();

        return view('caixas.index', compact('caixas','caixasAberto','caixaAbertoList','funcionarios', 'estabelecimentos'));
    }

    public function create()
    {
        
    }


    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        //
    }

    public function abertura(Request $request,$id){
        //var_dump($request->all());exit;
        $isLogado = false;
        $caixasAberto = $this->caixas->where('fechado', 'n')->get()->count();

        $logando_funcionario = $this->funcionarios->where('id',$request->get('id_funcionario'))->where('senha',$request->get('senha'))->get()->count();

        if($logando_funcionario){
            $caixa = $this->caixas->findOrFail($id);
            $caixa->update([
                'fechado'=> 'n',
            ]);



            $ab_caixa = $this->abertura_caixa->create([
                'saldo_inicial'         => $request->get('valor_inicial'),
                'id_usuario'            => $this->id_usuario,
                'id_funcionario'        => $request->get('id_funcionario'),
                'id_estabelecimento'    => $request->get('id_estabelecimento'),
                'id_caixa'              => $id,
                'fechado'               => 'n'
            ]);

            $funcionario_find = $this->funcionarios->findOrFail($request->get('id_funcionario'));
            $funcionario_find->update([
                'operando'       =>'s'
            ]);
            $isLogado = true;
            return response()->json(['isLogado'=>$isLogado]);
        }else{
            $isLogado = false;
            return response()->json(['isLogado'=>$isLogado]);
        }        

    }

    public function fechamento(Request $request,$id){
        //var_dump($request->all());exit;
        $isLogado = false;
        $logando_funcionario = $this->funcionarios->where('id',$request->get('id_funcionario'))->where('senha',$request->get('senha'))->get()->count();
        if($logando_funcionario){
            //Deixa o Caixa Livre
            $caixa = $this->caixas->findOrFail($id);
            $caixa->update(['fechado'=> 's']);

            //Fecha o Caixa na tabela Abertura_caixa
            //$ab_caixa_id_find = $this->abertura_caixa->where('id_caixa',$id)->where('fechado', 'n')->firstOrFail();
            $ab_caixa = $this->abertura_caixa->findOrFail($request->get('id_ab_caixa'));
            $ab_caixa->update([
                'fechamento_avista'   => $request->get('valor_avista'),
                'fechamento_credito'   => $request->get('valor_credito'),
                'fechamento_debito'   => $request->get('valor_debito'),
                'fechamento_pix'   => $request->get('valor_pix'),
                'fechado'       =>'s'
            ]);

            $funcionario_find = $this->funcionarios->findOrFail($request->get('id_funcionario'));
            $funcionario_find->update([
                'operando'       =>'n'
            ]);
            $isLogado = true;
            return response()->json(['isLogado'=>$isLogado]);
        }else{
            $isLogado = false;
            return response()->json(['isLogado'=>$isLogado]);
        }
        

    }






   


}

