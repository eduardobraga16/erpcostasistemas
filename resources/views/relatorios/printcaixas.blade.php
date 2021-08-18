<style type="text/css">
	body{
		font-family: arial;
	}
.cupon-full{
	display: none;
}
.cupon-full h2{
	font-size: 17px;
	font-weight: bold;
}
.cupon-full{
	font-size: 12px;
}
.cupon-full span{
	font-size: 11px;
}
.tb-cup-inter td{
	text-align: center;
}
.tb-cup td{
	
}

@media print{
	.cupon-full{
		display: block;
	}
}
</style>

<script>
	print();
	window.addEventListener("afterprint", function(event) { window.close(); });
    window.onafterprint();
</script>

<div class="cupon-full">
    <div><h2>Relatório Fechamento Caixa</h2></div>
    <div><span>Data: {{dataHoraBr(date("Y-m-d G:i:s"))}}</span></div>
    <div><span>Caixa: {{$caixa_ab['caixa']}}</span></div>
    <div><span>Abertura: {{dataHoraBr($caixa_ab['created_at'])}}</span></div>
    <div><span>Fechamento: {{dataHoraBr($caixa_ab['updated_at'])}}</span></div>

    <hr style="border: 1px dashed black;" />
	<br />
    <div><h3>Dados do Caixa</h3></div>

    <div>Saldo Inicial:  R$<?php echo moedaBr($caixa_ab['saldo_inicial']); ?></div>
	<div>Saldo em Caixa:  R$<?php echo moedaBr($caixa_ab['saldo_em_caixa']); ?></div>
	<div>Saldo Cartão Crédito:  R$<?php echo moedaBr($caixa_ab['cartao_credito']); ?></div>
	<div>Saldo Cartão Débito:  R$<?php echo moedaBr($caixa_ab['cartao_debito']); ?></div>
	<div>Saldo PIX:  R$<?php echo moedaBr($caixa_ab['pix']); ?></div>
	

	<hr style="border: 1px dashed black;" />

	<div><h3>Dados de fechamento do Caixa</h3></div>
	<div>Funcionário:  <?php echo $caixa_ab['nome']; ?></div>
	<div>Dinheiro Caixa:  
	<?php 
		$diferenca = $caixa_ab['fechamento_avista']-$caixa_ab['saldo_em_caixa'];
		echo moedaBr($caixa_ab['fechamento_avista']); 
		echo ", Diferença: ".moedaBr($diferenca);
	?></div>
	<div>Cartão Crédito:  
		<?php 
		$diferenca1 = $caixa_ab['fechamento_credito']-$caixa_ab['cartao_credito'];
		echo moedaBr($caixa_ab['fechamento_credito']); 
		echo ", Diferença: ".moedaBr($diferenca1);
	?><div>
	<div>Cartão Débito:  
		<?php 
		$diferenca2 = $caixa_ab['fechamento_debito']-$caixa_ab['cartao_debito'];
		echo moedaBr($caixa_ab['fechamento_debito']); 
		echo ", Diferença: ".moedaBr($diferenca2);
		?></div>
	<div>PIX:  
		<?php 
		$diferenca3 = $caixa_ab['fechamento_pix']-$caixa_ab['pix'];
		echo moedaBr($caixa_ab['fechamento_pix']); 
		echo ", Diferença: ".moedaBr($diferenca3);
		?></div>

	<hr style="border: 1px dashed black;" />

	<div><h3>Movimentações</h3></div>

	@foreach($movimentacoes_caixa as $kk)
		<div>
			<?php if($kk['tipo'] == 's'){ ?>
				Sangria:  - R$<?php echo moedaBr($kk['valor']); ?> <?php if(isset($kk['motivo'])){echo "(".$kk['motivo'].")";} ?>
			<?php }else if($kk['tipo'] == 'e'){ ?>
				Reforço: + R$<?php echo moedaBr($kk['valor']); ?> <?php if(isset($kk['motivo'])){echo "(".$kk['motivo'].")";} ?>
			<?php } ?>
		</div>
	@endforeach

</div>