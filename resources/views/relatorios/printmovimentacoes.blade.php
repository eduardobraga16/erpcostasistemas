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
    <div><h2>Relatório de Vendas</h2></div>
    <div><span>Data: {{$data_inicio}} / {{$data_final}}</span></div>

    <hr style="border: 1px dashed black;" />
	<br />
    <div><h2>Vendas</h2></div>

    <table class="tb-cup">
		<tbody>
			<tr>
				<td><span><strong>data</strong></span></td>
				<td><span><strong>Tipo</strong></span></td>
				<td><span><strong>Valor</strong></span></td>
				<td><span><strong>Funcionário</strong></span></td>
			</tr>
			<?php foreach($movimentacoes as $iten){ ?>
			<tr class="tb-cup-inter">
				<td style="text-align: left;"><span><?php echo dataHoraBr($iten->created_at); ?></span></td>
				<td><span> <?php echo $iten->tipo; ?></span></td>
				<td><span> <?php echo moedaBr($iten->valor); ?></span></td>
				<td><span> <?php echo $iten->id_funcionario; ?></span></td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
	<br /><br />
	

</div>