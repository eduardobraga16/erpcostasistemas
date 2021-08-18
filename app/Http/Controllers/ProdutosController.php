<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\ProdutosModel;
use App\Models\CategoriasModel;
use App\Models\VendasitemsModel;

class ProdutosController extends Controller{
    private $token;
    private $id_usuario;
    private $produtos;
    private $categorias;
    private $vendas_items;

    public function __construct(ProdutosModel $produtos, CategoriasModel $categorias, VendasitemsModel $vendas_items){
        if(isset($_SESSION['userLogado'])){
            $this->token = $_SESSION['userLogado']['token'];
            $this->id_usuario = $_SESSION['userLogado']['id'];
        }else{
            redirect('login')->send();
        }

        $this->produtos = $produtos;
        $this->categorias = $categorias;
        $this->vendas_items = $vendas_items;
    }

    public function index(Request $request){
        $produtos = $this->produtos->orderBy('id','desc')->paginate(15);
        $categoria = $this->produtos->with('categoria')->get();
        //var_dump($categoria);exit;
        
        //dd($produtos);
        /*
    	$token = $this->token;

    	//Se for usar Paginação
    	if(isset($_GET['page'])){
    		$page = "?page=".$_GET['page'];
    	}else{
    		$page = "";
    	}

        $response = Http::acceptJson()
            ->withToken($token)
            ->get('https://costasistemas.club/api/public/api/v1/produtos'.$page)
            ->throw(function ($response, $e){
                redirect('logout')->send();
        });

       
        $produtos = $response->json();
        */
        return view('produtos.index', compact('produtos','categoria'));
    }

    public function create(){
        $categorias = $this->categorias->all();
        /*
		$token = $this->token;
    	$response = Http::acceptJson()
            ->withToken($token)
            ->get('https://costasistemas.club/api/public/api/v1/categorias')
            ->throw(function ($response, $e){
                redirect('logout')->send();
        });
        $categorias = $response->json();
        */
    	return view('produtos.create', compact('categorias'));
    }

    public function store(Request $request){
        $data = $request->all();
        $data['id_usuario'] = $this->id_usuario;
        $preco_str = str_replace(",",".", $request->get('preco'));
        $data['preco'] = $preco_str;
        
        
        
        if($request->hasFile('image') && $request->image->isValid() ){
            $path = $request->image->store('posters', 'public');
            $data['imagem'] = $path;
        }
        try {
            $produto = $this->produtos->create($data);
        } catch (Exception $e) {
            
        }

        //var_dump($image);exit;

        /*
    	$array_categorias = array();

        if($request->get("array_cat")){
        	$dda = json_encode($request->get("array_cat"));
        	$dda1 = json_decode($dda, true);

        	$cats = implode(",", $dda1);
    		$cats2 = json_encode($cats);
    		
        	for ($i=0; $i < count($dda1); $i++) { 
        		array_push($array_categorias, $dda1[$i]);
        	}
        }else{
                array_push($array_categorias, 1);
        }
    	

    	$token = $this->token;

        $image = $request->file('image');  // your base64 encoded
        $image = str_replace('data:image/jpeg;base64,', '', $image);
        $image = str_replace(' ', '+', $image);
        echo $imageName = str_random(10).'.'.'jpg';
        //var_dump($image);
        exit;

        try{

            
           $result = Http::acceptJson()
           ->withToken($token)
           //->attach('image', $photo, 'photo.jpg')
           //->withBody(base64_encode($photo), 'image/jpg')
           //->withHeaders(['Content-Type' => 'image/jpg'])
           //->asForm()
           ->post('https://costasistemas.club/api/public/api/v1/produtos', [
                'nome' => $nome,
                'descricao' => $descricao,
                'preco' => $preco,
                'ativo' => $ativo,
                'categorias' => $array_categorias,
                'id_usuario' => $this->id_usuario,
                "image" => 'image'
            ]);
           $result->throw(function ($response, $e){
                echo $e." - ".$response;
                redirect('logout')->send();
        }); 
        
        } catch(\Illuminate\Http\Client\RequestException $e){
           
        }
        */
        //echo $id_last_insert = json_decode($result['data']['produto_id'], true);

    }

    public function edit($id){

        try {
            $produto = $this->produtos->findOrFail($id);
            $categoria = $this->produtos->with('categoria')->get();
            $categorias = $this->categorias->all();
        } catch (Exception $e) {
            
        }



        /*
    	$token = $this->token;

        $response = Http::acceptJson()
            ->withToken($token)
            ->get('https://costasistemas.club/api/public/api/v1/produtos/'.$id)
            ->throw(function ($response, $e){
                redirect('logout')->send();
        });
        $produto = $response->json();


        $responseCategorias = Http::acceptJson()
            ->withToken($token)
            ->get('https://costasistemas.club/api/public/api/v1/categorias')
            ->throw(function ($response, $e){
                redirect('logout')->send();
        });
        $categorias = $responseCategorias->json();
        */
        return view('produtos.editar', compact('produto','categorias'));
    }


    public function update(Request $request, $id){


        $data = $request->all();
        $preco_str = str_replace(",",".", $request->get('preco'));
        $data['preco'] = $preco_str;
        //var_dump($data);exit;
//        $data['id_usuario'] = $this->id_usuario;
        if($request->hasFile('image') && $request->image->isValid() ){
            $path = $request->image->store('posters', 'public');
            $data['imagem'] = $path;
        }else{
            
        }
        try {
            $produto = $this->produtos->findOrFail($id);
            $produto->update($data);
        } catch (Exception $e) {
            
        }


/*
    	$id_produto = $request->get('id_prod');
    	$nome = $request->get("nome");
    	$preco = $request->get("preco");
    	$descricao = $request->get("descricao");
    	$ativo = $request->get("ativo");
    	
    	
    	$array_categorias = array();
    	
    	if($request->get("array_cat")){
			$dda = json_encode($request->get("array_cat"));
			$dda1 = json_decode($dda, true);

            

	    	$cats = implode(",", $dda1);
			$cats2 = json_encode($cats);
			
	    	for ($i=0; $i < count($dda1); $i++) { 
	    		array_push($array_categorias, $dda1[$i]);
	    	}
    	}else{

                array_push($array_categorias, 1);
            
        }

    	
    	$token = $this->token;

        $response = Http::acceptJson()
            ->withToken($token)
            ->put('https://costasistemas.club/api/public/api/v1/produtos/'.$id_produto,[
			    'nome' => $nome,
			    'descricao' => $descricao,
			    'preco' => $preco,
			    'ativo' => $ativo,
			    'categorias' => $array_categorias
			    
			])
            ->throw(function ($response, $e){
                redirect('logout')->send();
        });
        //echo $id_last_insert = json_decode($response['data']['produto_id'], true);
*/
    }



    public function excluir($id){
        try {
            $produto = $this->produtos->findOrFail($id);
            $produto->delete();
            redirect('produtos')->send();
        } catch (Exception $e) {
            
        }


        /*
        $token = $this->token;

        $response = Http::acceptJson()
            ->withToken($token)
            ->delete('https://costasistemas.club/api/public/api/v1/produtos/'.$id)
            ->throw(function ($response, $e){
                //redirect('logout')->send();
        });
        redirect('produtos')->send();
        */
    }


    public function busca($busca_nome){
        $resultado = $this->produtos->where('nome', 'like','%'.$busca_nome.'%')->get();

        return response()->json($resultado);
    }


    public function additemcarrinho(Request $request){
        $produto = $this->produtos->findOrFail($request->get('id_produto'));
        $vendas_items = $this->vendas_items->create([
            'qtde' => $request->get('qtde'),
            'preco' => $produto->preco,
            'id_venda' => $request->get('id_venda'),
            'id_produto' => $request->get('id_produto'),
        ]);
        $item_inserido = $this->vendas_items
        ->select('vendas_items.id AS id_venda_items','vendas_items.qtde','vendas_items.preco','vendas_items.id_produto','vendas_items.id_venda',
        'produtos.nome','produtos.id')
        ->join('produtos','vendas_items.id_produto', '=', 'produtos.id')    
        ->findOrFail($vendas_items->id);
        return response()->json($item_inserido);   
    }

    public function removeitemcarrinho(Request $request){
        $remove_item = $this->vendas_items->findOrFail($request->get('id_item_venda'));
        $remove_item->delete();

        return response()->json($request->all());
    }





}
