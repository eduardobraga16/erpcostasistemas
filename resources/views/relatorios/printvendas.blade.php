<style type="text/css">
	body{
		font-family: arial;
	}
.cupon-full{
	display: none;
}
.cupon-full h2{
	font-size: 16px;
	font-weight: bold;
}
.cupon-full p{
	font-size: 12px;
}
.cupon-full span{
	font-size: 12px;
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
    <div><h2>Relatório de Vendas</h2></div>
    <div><span>Data: {{$data_inicio}} / {{$data_final}}</span></div>

    <hr style="border: 1px dashed black;" />
	<br />
    <div><h2>Vendas</h2></div>

    <table class="tb-cup">
		<tbody>
			<tr>
				<td><span><strong>Data</strong></span></td>
				<td><span><strong>Pagamento</strong></span></td>
				<td><span><strong>Total</strong></span></td>
			</tr>
			<?php $total = 0; foreach($vendas as $iten){ ?>
			<tr class="tb-cup-inter">
				<td style="text-align: left;"><span><?php echo dataHoraBr($iten->created_at); ?></span></td>
				<td><span> <?php echo $iten->forma; ?></span></td>
				<td><span> <?php echo moedaBr($iten->total); ?></span></td>
			</tr>
			<?php $total += $iten->total;} ?>
		</tbody>
	</table>
	<br /><br />
	
	<span>Total: </span> R$<?php echo moedaBr($total); ?>

</div>