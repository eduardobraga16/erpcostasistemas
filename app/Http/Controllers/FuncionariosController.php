<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FuncionariosModel;
use App\Models\CategoriasModel;
use App\Models\VendasitemsModel;
use App\Models\EstabelecimentosModel;

class FuncionariosController extends Controller
{
    private $token;
    private $id_usuario;
    private $funcionarios;
    private $estabelecimentos;

    public function __construct(FuncionariosModel $funcionarios,EstabelecimentosModel $estabelecimentos){
        if(isset($_SESSION['userLogado'])){
            $this->token = $_SESSION['userLogado']['token'];
            $this->id_usuario = $_SESSION['userLogado']['id'];
        }else{
            redirect('login')->send();
        }

        $this->funcionarios = $funcionarios;
        $this->estabelecimentos = $estabelecimentos;
    }


    public function index()
    {
        $funcionarios = $this->funcionarios
        ->select('estabelecimentos.nome AS nome_estabelecimento_join','funcionarios.id','funcionarios.id_usuario','funcionarios.nome','funcionarios.administrador','funcionarios.id_estabelecimento')
        
        ->join('estabelecimentos','funcionarios.id_estabelecimento','=','estabelecimentos.id')
        ->where('funcionarios.id_usuario', $this->id_usuario)
        ->paginate(20);
        return view('funcionarios.index', compact('funcionarios'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try {
            $estabelecimentos = $this->estabelecimentos
            ->where('id_usuario', $this->id_usuario)
            ->get();
        } catch (Exception $e) {
            
        }

        return view('funcionarios.create', compact('estabelecimentos'));
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
        $data['operando'] = 'n';
        
        try {
            $funcionario = $this->funcionarios->create($data);
            redirect('funcionarios')->send();
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
            $funcionario = $this->funcionarios->findOrFail($id);
            $estabelecimentos = $this->estabelecimentos
            ->where('id_usuario', $this->id_usuario)
            ->get();
        } catch (Exception $e) {
            
        }

        return view('funcionarios.editar', compact('funcionario','estabelecimentos'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        try {
            $funcionario = $this->funcionarios->findOrFail($id);
            $funcionario->update($data);
            redirect('funcionarios')->send();
        } catch (Exception $e) {
            
        }
    }

    public function excluir($id){
        try {
            $funcionario = $this->funcionarios->findOrFail($id);
            $funcionario->delete();
            redirect('funcionarios')->send();
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
}
