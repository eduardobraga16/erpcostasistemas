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
    <div><span>Cliente: <?php echo $venda->nome_cliente; ?></span></div>
    <div><span>Data: <?php echo dataHoraBr($venda->created_at); ?></span></div>

    <hr style="border: 1px dashed black;" />
	<br />
    <div><h2>Produtos</h2></div>

    <table class="tb-cup">
		<tbody>
			<tr>
				<td><span><strong>Nome</strong></span></td>
				<td><span><strong>Valor</strong></span></td>
				<td><span><strong>Qtde</strong></span></td>
				<td><span><strong>V. Total R$</strong></span></td>
			</tr>
			<?php foreach($items as $iten){ ?>
			<tr class="tb-cup-inter">
				<td style="text-align: left;"><span><?php echo $iten->nome; ?></span></td>
				<td><span> <?php echo moedaBr($iten->preco); ?></span></td>
				<td><span> <?php echo $iten->qtde; ?></span></td>
				<td><span> <?php echo moedaBr($iten->qtde*$iten->preco); ?></span></td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
	<br /><br />
	<hr style="border: 1px dashed black;" />

	<div><span><strong>Forma de Pagamento:</strong> <?php echo $venda->forma_pagamento; ?></span></div>
	<div><span><strong>Dinheiro recebido:</strong> <?php echo $venda->dinheiro_recebido; ?></span></div>
	<div><span><strong>Troco:</strong> <?php echo moedaBr($venda->troco); ?></span></div>
	<div><span><strong>Total pago:</strong> R$ <?php echo moedaBr($venda->total); ?></span></div>

	<br /><br />
	<hr style="border: 1px dashed black;" />

	<div><span>Temos Delivery</span></div>
	<div><span>Número: 99629-3642</span></div>

</div>