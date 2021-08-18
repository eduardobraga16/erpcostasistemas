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
.cupon-full p{
	font-size: 13px;
}
.cupon-full span{
	font-size: 13px;
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
    <div><h2>Relatório de Vendas Itens</h2></div>
    <div><span>Data: {{$data_inicio}} / {{$data_final}}</span></div>

    <hr style="border: 1px dashed black;" />
	<br />
    <div><h2>Vendas</h2></div>

    <table class="tb-cup">
		<tbody>
			<tr>
				<td><span><strong>Nome</strong></span></td>
				<td><span><strong>Qtde</strong></span></td>
				<td><span><strong>Preço</strong></span></td>
				<td><span><strong>Sub Total</strong></span></td>
			</tr>
			<?php $total =0; foreach($items as $iten){ ?>
			<tr class="tb-cup-inter">
				<td style="text-align: left;"><span><?php echo $iten->nome; ?></span></td>
				<td><span> <?php echo $iten->qtde_total; ?></span></td>
				<td><span> <?php echo moedaBr($iten->preco); ?></span></td>
				<td><span> <?php echo moedaBr($iten->qtde_total*$iten->preco); ?></span></td>
			</tr>
			<?php $total += $iten->qtde_total*$iten->preco;} ?>
		</tbody>
	</table>
	<br /><br />

	<span>Total: </span> R$<?php echo moedaBr($total); ?>
	

</div>