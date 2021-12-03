$( document ).ready(function() {
    $(".loud").css("display", "none");

    /*var array_categorias = [];

    $("input:checkbox").change(function() {
        if($(this).is(":checked")) { 
    		
        	array_categorias.push($(this).val());
        	console.log(array_categorias);
        }else{
        	var array_categorias_index = array_categorias.indexOf($(this).val());
        	array_categorias.splice(array_categorias_index, 1);
        	console.log(array_categorias);
        }
    }); 

    for(var i = 0; i < $("input[name='id_categoria']:checked").length; i++){
        array_categorias.push($("input[name='id_categoria']:checked").eq(i).val());
        //$("input[name='id_categoria']:checked").eq(i).attr("id","id_categoria").parent().hide();
    }*/


    $(".btn-confirmar-cadastro").click(function(e){
    	e.preventDefault();

        $(".loud").css("display", "block");
    	let nome = $("#nome").val();
    	let descricao = $("#descricao").val();
    	let preco = $("#preco").val();
    	let ativo = $("#ativo").val();
        let id_categoria = $("#id_categoria").val();

        var formulario = document.getElementById('formulario-front-cad-prod');
        var formData = new FormData(formulario);
    	let _token   = $('meta[name="csrf-token"]').attr('content');

        //Campos Obrigatórios
        if(id_categoria == ""){
            alert("Selecione uma Categoria!");
            $(".loadinging").css({"z-index":"10"});
            $(".loud").css({"display":"none"});
            exit();
        }

    	$.ajax({
        	type: 'post',
        	url: base_url+'/produtos',
        	data:formData,
        	processData: false,  
            contentType: false,
            dataType: "html",
        	success: function(data){
                console.log(data);
        		$(".loud").css("display", "none");
                var modal = $(".modal-excluir");
                modal.show();
                $("#nome").val("");
                $("#descricao").val("");
                $("#preco").val("");
                $("#image_arquivo").val("");
        	}
        });
    });

    $(".btn-confirmar-edit-prod").click(function(b){
        b.preventDefault();

        $(".loud").css("display", "block");
        let id_prod = $("#id_prod").val();
        let nome = $("#nome").val();
        let descricao = $("#descricao").val();
        let preco = $("#preco").val();
        let ativo = $("#ativo").val();
        var image = $('#image')[0].files[0];

        var formulario = document.getElementById('formulario-front-cad-prod');
        var formData = new FormData(formulario);
        formData.append('image', image);
        formData.append('_method', 'PUT');
        let _token   = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            type: 'POST',
            url: base_url+'/produtos/'+id_prod,
            data:formData,
            contentType: false,
            processData: false,
            success: function(data){
                $(".loud").css("display", "none");
                redirecionaUrl(base_url+'/produtos');
            }
        });

    });

    $(".btn-abrir-caixa").click(function(c){
        c.preventDefault();
        let id_caixa = $(this).parent().parent().find("#id_caixa").val();
        var modal = $("#modal-abrir-caixa");
        modal.find('.id_caixa').attr('value', id_caixa);
        modal.show();
    });

    $(".btn-abrir-caixa-confirmar").click(function(d){
        d.preventDefault();
        $(".loadinging").css({"z-index":"106222"});
        $(".loud").css({"display":"block"});
        let id_caixa = $(this).parent().find(".id_caixa").val();
        let valor_inicial = $(this).parent().parent().find("#valor_inicial").val();
        let id_funcionario = $(this).parent().parent().find("#funcionario_id").val();
        let id_estabelecimento = $(this).parent().parent().find("#estabelecimento_id").val();
        let _token   = $('meta[name="csrf-token"]').attr('content');

        //Campos Obrigatórios
        if(!id_funcionario){
            alert("Selecione o Funcionário!");
            $(".loadinging").css({"z-index":"10"});
            $(".loud").css({"display":"none"});
            exit();
        }

        $.ajax({
            type: 'POST',
            url: base_url+'/caixas/abertura/'+id_caixa,
            data:{
                id:id_caixa,
                valor_inicial: valor_inicial,
                id_funcionario:id_funcionario,
                //nome_funcionario:nome_funcionario,
                id_estabelecimento:id_estabelecimento,
                _token:_token
            },
            //dataType: 'json',
            success: function(data){
                //console.log(data);
                redirecionaUrl(base_url+'/vendas');
            }
        });
    });

    $(".btn-fechar-caixa").click(function(c){
        c.preventDefault();
        let id_caixa = $(this).parent().parent().find("#id_caixa").val();
        let id_ab_caixa = $(this).parent().parent().find("#id_ab_caixa").val();
        let id_funcionario = $(this).parent().parent().find("#id_funcionario").val();
        let nome_funcionario = $(this).parent().parent().find("#nome_funcionario").val();
        $("#funcionario_id_fecha").val(id_funcionario);
        $("#funcionario_nome_fecha").val(nome_funcionario);

        var modal = $("#modal-fechar-caixa");
        modal.find('.id_caixa').attr('value', id_caixa);
        modal.find('.id_ab_caixa').attr('value',id_ab_caixa);
        modal.show();
    });


    $(".btn-fechar-caixa-confirmar").click(function(c){
        c.preventDefault();
        $(".loadinging").css({"z-index":"106222"});
        $(".loud").css("display", "block");
        let id_caixa = $(this).parent().find(".id_caixa").val();
        let id_ab_caixa = $(this).parent().find(".id_ab_caixa").val();
        let id_funcionario = $(this).parent().parent().find("#funcionario_id_fecha").val();
        let nome_funcionario = $(this).parent().parent().find("#funcionario_nome_fecha").val();
        let valor_final = $(this).parent().parent().find("#valor_final").val();
        let valor_credito = $(this).parent().parent().find("#cartao_credito").val();
        let valor_debito = $(this).parent().parent().find("#cartao_debito").val();
        let valor_pix = $(this).parent().parent().find("#pix").val();
        let _token   = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            type: 'POST',
            url: base_url+'/caixas/fechamento/'+id_caixa,
            data:{
                id:id_caixa,
                id_ab_caixa:id_ab_caixa,
                id_funcionario:id_funcionario,
                nome_funcionario:nome_funcionario,
                valor_avista:valor_final,
                valor_credito:valor_credito,
                valor_debito:valor_debito,
                valor_pix:valor_pix,
                _token:_token
            },
            success: function(data){
                redirecionaUrl(base_url+'/vendas');
            }
        });
    });


    //Movimentações
    $(".btn-confirmar-movimentacao").click(function(z){
        z.preventDefault();
        $(".loadinging").css({"z-index":"106222"});
        $(".loud").css("display", "block");

        let id = $(this).parent().parent().find("#id").val();
        let id_caixa = $(this).parent().parent().find("#id_caixa").val();
        let id_estabelecimento = $(this).parent().parent().find("#id_estabelecimento").val();
        let id_funcionario = $(this).parent().parent().find("#id_funcionario").val();
        let tipo = $(this).parent().parent().find("#tipo").val();
        let valor = $(this).parent().parent().find("#valor").val();
        let motivo = $(this).parent().parent().find("#motivo").val();
        
        let _token   = $('meta[name="csrf-token"]').attr('content');


        $.ajax({
            type: 'POST',
            url: base_url+'/movimentacoes',
            data:{
                id:id,
                id_caixa:id_caixa,
                id_estabelecimento:id_estabelecimento,
                id_funcionario:id_funcionario,
                tipo:tipo,
                valor:valor,
                motivo:motivo,
                _token:_token
            },
            success: function(data){
                //console.log(data);
                $(".loadinging").css({"z-index":"10"});$(".loud").css({"display":"none"});
                alert(data['resultado']);
                $("#valor").val("");
                $("#motivo").val("");
                /*console.log(data);
                if(data['isLogado']){
                    redirecionaUrl(base_url+'/vendas');
                }else{
                    $(".loadinging").css({"z-index":"10"});
                    $(".loud").css({"display":"none"});
                    alert("Senha errada!");
                }*/
            }
        });
    });


    //btns
    $(".btn-excluir").click(function(e){
        e.preventDefault();
        var url_item_excluir = $(this).find('a').attr("href");
        var modal = $(".modal-excluir");
        modal.append("<input type='hidden' value='"+url_item_excluir+"' class='url_item_excluir'>");
        modal.show();
    });
    $(".btn-close-click").click(function(){
        $(this).parent().parent().parent().parent().hide();
    });
    $(".btn-excluir-confirmar").click(function(){
        $(this).parent().parent().parent().parent().hide();
        $(".loud").css("display", "block");
        var url_item_excluir_redir = $(".url_item_excluir").val();
        redirecionaUrl(url_item_excluir_redir);
    });

    //Carrinho
    $("#busca_nome").on('keyup',function(){
        let nome_busca = $(this).val();
        if(nome_busca == ''){
            $('.produtos-resultado').css("display","none");
            $('.produtos-resultado .list-group').html("");
        }else{
            $('.produtos-resultado').css("display","block");
            buscaProduto(nome_busca);
        }
    });

    function buscaProduto(busca_nome){
        $.ajax({
            type: 'GET',
            url: base_url+'/produtos/busca/'+busca_nome,
            dataType: 'json',
            success: function(data){
                let li_produto = '';
                for(var i in data){
                    li_produto += '<li class="list-group-item" data-id="'+data[i].id+'" data-nome="'+data[i].nome+'" data-preco="'+data[i].preco+'" onclick="addItemCarrinho(this)">'+
                    '<span class="car-iten-nome">'+data[i].nome+'</span>'+
                    '<span class="car-item-val">R$ '+data[i].preco+'</span>'+
                    '</li>';
                }
                $('.produtos-resultado .list-group').html(li_produto);
            }
        });
    }

    $(".btn-inserir-item-carrinho").click(function(f){
        f.preventDefault();
        $(".loud").css("display", "block");
        let _token   = $('meta[name="csrf-token"]').attr('content');
        let id_venda = $(".id_venda").val();
        let qtde = $("#qtde").val();
        let nome = $("#busca_nome").val();
        let preco = $("#preco_prod").val();
        let id_produto = $("#id_produto").val();
        adicionaItemCarrinho(_token,qtde,id_produto,id_venda,nome);
    });

    function adicionaItemCarrinho(_token,qtde,id_produto,id_venda, nome){
        $.ajax({
            type: 'POST',
            url: base_url+'/produtos/additemcarrinho',
            data: {
                id_produto:id_produto,
                nome: nome,
                qtde: qtde,
                id_venda: id_venda,
                _token:_token
            },
            dataType: 'json',
            success: function(data){
                var li_item = '<li class="list-group-item"><span class="car-qtde">'+data.qtde+'x</span>'+
                '<span class="car-iten-nome">'+data.nome+'</span>'+
                '<span class="car-item-val">R$ '+parseFloat(data.qtde)*parseFloat(data.preco)+'<div class="btn btn-danger btn-remove-prod" data-id-venda="'+data.id_venda+'" data-id-item="'+data.id_venda_items+'" onclick="removeItemCarrinho(this)">X</div></span></li>'+
                '</li>';
                atualizaTotal(id_venda,_token);

                $('.list-group-items').prepend(li_item);
                $(".loud").css("display", "none");
                $("#busca_nome").val("");
                $("#preco_prod").val(0);
                $("#qtde").val(1);
                $("#busca_nome").focus();
            }
        });
    }


    $(".btn-em-empera-venda").click(function(i){
        i.preventDefault();
        let id_venda = $(".id_venda").val();
        let nome_cliente = $("#nome_cliente").val();
        let _token   = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            type: 'POST',
            url: base_url+'/vendas/colocaremespera/'+id_venda,
            data: {
                id_venda: id_venda,
                nome_cliente:nome_cliente,
                _token:_token
            },
            dataType: 'json',
            success: function(data){
                //console.log(data);
                redirecionaUrl(base_url+"/vendas");
            }
        });
    });


    $(".btn-cancelar-venda").click(function(g){
        g.preventDefault();
        let id_venda = $(".id_venda").val();
        let _token   = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            type: 'POST',
            url: base_url+'/vendas/cancelar/'+id_venda,
            data: {
                id_venda: id_venda,
                _token:_token
            },
            dataType: 'json',
            success: function(data){
                //console.log(data);
                redirecionaUrl(base_url+"/vendas");
            }
        });
    });
    

    $("#check_nome_cliente:checkbox").change(function() {
        if($(this).is(":checked")) { 
            $("#nome_cliente").val("Sem nome");
        }else{
            $("#nome_cliente").val("");
        }
    }); 
    
    $("#valor_recebido").on('keyup',function(){
        let valor_troco = '0';
        let total = $(".total-str").text().replace(',','.');
        let valor_recebido = $(this).val();
        if(valor_recebido == ''){
            valor_troco = 0;
            mascaraValor(valor_troco.toFixed(2))
        }else{
            valor_troco = parseFloat(valor_recebido) - parseFloat(total);    
        }
        $(".troco-str").html(valor_troco.toFixed(2));
        $("#troco").val(valor_troco);
    });

    $(".hamb-menu-actions").click(function(){
        $(this).hide();
        $(this).parent().find(".close-menu-actions").css("display","inline-block");
        $(".list-group-menu-actions").hide();
        $(this).parent().find(".list-group-menu-actions").toggle();
    });

    $(".close-menu-actions").click(function(){
        $(this).hide();
        $(this).parent().find(".hamb-menu-actions").show();
        $(".list-group-menu-actions").hide();
        $(this).parent().find(".list-group-menu-actions").hide();
    });

    $("#valor_recebido").click(function(){
        $(this).select();
    });


    //Inpunts mask
    $(".real-mask").on('keyup',function(){
        $(this).mask("000000000000000,00", {reverse: true});
    });



    //Garçon Add produto
    $(".btn-prod-garcon").click(function(t){
        t.preventDefault();

        let id_produto = $(this).find("#id_produto").val();
        let nome_produto = $(this).find("#nome_produto").val();

        var modal = $(".modal-add-prod-garcon");
        $(".id_produto_val").val(id_produto);
        $(".modal-add-prod-garcon .modal-title").html(nome_produto);
        
        modal.show();
    });

    $(".btn-add-item-garcon").click(function(q){
        q.preventDefault();
        $(".loud").css("display", "block");

        let id_produto = $(".id_produto_val").val();
        let id_venda = $("#id_venda").val();
        let nome_produto = $(this).find("#nome_produto").val();
        let qtde = $("#qtde").val();
        let _token   = $('meta[name="csrf-token"]').attr('content');

        adicionaItemCarrinho(_token,qtde,id_produto,id_venda,nome_produto);
        var modal = $(".modal-add-prod-garcon");
        modal.hide();
    });

    $(".btn-finalizar-garcon").click(function(q){
        q.preventDefault();
        $(".loud").css("display", "block");

        let id_venda = $("#id_venda").val();
        let nome_cliente = $("#nome_cliente").val();
        let _token   = $('meta[name="csrf-token"]').attr('content');


        finalizarVendaGarcon(_token,id_venda,nome_cliente,'/garcon');
    });

    $(".btn-finalizar-mesa").click(function(t){
        t.preventDefault();
        $(".loud").css("display", "block");

        let id_venda = $("#id_venda").val();
        let nome_cliente = $("#nome_cliente").val();
        if(nome_cliente == ''){
            alert("Digite seu nome!");
            $("#nome_cliente").focus();
            $(".loud").css("display", "none");
            exit();
        }
        let _token   = $('meta[name="csrf-token"]').attr('content');


        finalizarVendaGarcon(_token,id_venda,nome_cliente,'/mesas/pedidosqrcode/1');
    });

    $(".btn-cancelar-mesa").click(function(j){
        j.preventDefault();
        $(".loud").css("display", "block");

        let id_venda = $("#id_venda").val();
        let id_mesa = $("#id_mesa").val();
        let _token   = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            type: 'POST',
            url: base_url+'/vendas/cancelarvendamesa/'+id_venda+'/'+id_mesa,
            data: {
                id_venda: id_venda,
                _token:_token
            },
            dataType: 'json',
            success: function(data){
                //console.log(data);
                redirecionaUrl(base_url+"/garcon");
            }
        });
    });
    

    
    $(".btn-qtde-menos").click(function(){
        let qtde = parseFloat($("#qtde").val());
        if(qtde != 1){
            $("#qtde").val(qtde-1);
        }
        
    });
    
    $(".btn-qtde-mais").click(function(){
        let qtde = parseFloat($("#qtde").val());
        $("#qtde").val(qtde+1);
    });

});

function finalizarVendaGarcon(_token,id_venda,nome_cliente,url_redirect){
    $.ajax({
        type: 'POST',
        url: base_url+'/vendas/finalizagarcon/'+id_venda,
        data: {
            nome_cliente:nome_cliente,
            id_venda: id_venda,
            _token:_token
        },
        dataType: 'json',
        success: function(data){
            //console.log(data);
            redirecionaUrl(base_url+url_redirect);
        }
    });
}

function calculaTroco(total){
    let valor_troco = '0';
    let valor_recebido = $("#valor_recebido").val();
    if(valor_recebido == '0'){
        exit();
    }
    valor_troco = parseFloat(valor_recebido) - parseFloat(total);    
    $(".troco-str").html(valor_troco.toFixed(2));
    $("#troco").val(valor_troco);
    
}


function removeItemCarrinho(obj){
    $(".loud").css("display", "block");
    let _token   = $('meta[name="csrf-token"]').attr('content');
    let id_item_venda = $(obj).attr('data-id-item');
    let id_venda = $(obj).attr('data-id-venda');
    $.ajax({
        type: 'POST',
        url: base_url+'/produtos/removeitemcarrinho',
        data: {
            id_item_venda:id_item_venda,
            _token:_token
        },
        dataType: 'json',
        success: function(data){
            console.log(data);
            atualizaTotal(id_venda,_token);
            $(obj).closest("li").remove();
            $(".loud").css("display", "none");
        }
    });
}

function addItemCarrinho(obj){
    let _token   = $('meta[name="csrf-token"]').attr('content');
    let preco = $(obj).attr("data-preco");
    let nome = $(obj).attr("data-nome");
    let id_produto = $(obj).attr("data-id");
    let id_venda = $(".id_venda").val();

    $("#busca_nome").val(nome);
    $("#preco_prod").val(preco);
    $("#id_produto").val(id_produto);

    $('.produtos-resultado').css("display","none");
    $('.produtos-resultado .list-group').html("");
    $("#qtde").select();
}

function atualizaTotal(id_venda,_token){
    $.ajax({
        type: 'POST',
        url: base_url+'/vendas/atualizatotal/'+id_venda,
        data: {
            id_venda: id_venda,
            _token:_token
        },
        dataType: 'json',
        success: function(data){
            console.log(data);
            $(".total-str").html(mascaraValor(data.toFixed(2)));
            $("#valor_recebido").val(data);
            calculaTroco(data);
        }
    });
}

function mascaraValor(valor) {
    valor = valor.toString().replace(/\D/g,"");
    valor = valor.toString().replace(/(\d)(\d{8})$/,"$1.$2");
    valor = valor.toString().replace(/(\d)(\d{5})$/,"$1.$2");
    valor = valor.toString().replace(/(\d)(\d{2})$/,"$1,$2");
    return valor;                 
}

function redirecionaUrl(href){
    window.location.href = href;
}