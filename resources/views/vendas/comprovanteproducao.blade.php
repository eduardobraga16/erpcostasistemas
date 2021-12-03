<?php use App\Models\MesasModel; ?>
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
    <div><span>Cliente: <?php if($venda->nome_cliente == ""){echo "N/D";}else{echo $venda->nome_cliente;} ?></span></div>
    <div><span>Data: <?php echo dataHoraBr($venda->created_at); ?></span></div>
    <div><span>Mesa: <?php if($venda['id_mesa'] == ""){echo "Balcão/Delivery";}else{ echo MesasModel::find($venda['id_mesa'])->numero;} ?></span></div>

    <hr style="border: 1px dashed black;" />
	<br />
    <div><h2>Produtos</h2></div>

    <table class="tb-cup">
		<tbody>
			<tr>
				<td><span><strong>Nome</strong></span></td>
				<td><span><strong>Qtde</strong></span></td>
			</tr>
			<?php foreach($items as $iten){ ?>
			<tr class="tb-cup-inter">
				<td style="text-align: left;"><span><?php echo $iten->nome_produto; ?></span></td>
				<td><span> <?php echo $iten->qtde; ?></span></td>
			</tr>
			<?php } ?>
		</tbody>
	</table>


</div>