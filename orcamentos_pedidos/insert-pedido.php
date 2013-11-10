<?

session_start();
require_once("../_funcoes/funcoes.php");
$conn = conecta_banco();

$id_usuario = $_SESSION['id'];

$cliente = $_POST['cliente'];
$dataentrada = $_POST['dataentrada'];
$descricao = $_POST['descricao'];
$total = $_POST['total'];
$total = valorparaobanco($total);

$condPagamento = $_POST['condicao'];
$parcelasjuros = $_POST['parcelasjuros'];
$parcelas = $_POST['parcelas'];
$desconto = 0;
$formapgto = $_POST['formapagto'];
$produto = $_POST['produto_'];
$valorunitario = $_POST['valor'];
$quantidade = $_POST['quantidade'];
$subtotal = $_POST['subtotal'];
$intervalo = 30;
$diasparcela = 2;
$dataemissao = date('Y-m-d');

	$sql = "SELECT MAX(ped_pedido) as codigo FROM pedidos";
	$resultado = $conn->query($sql);
	while ($linha = $resultado->fetchRow()) 
	{		 			
		$codpedido  = $linha[0]+1;
	}	

	$sql = "insert into pedidos (
			ped_pedido, 
			ped_data, 
			ped_formapagto, 
			ped_valortotal, 
			ped_responsavel, 
			ped_cliente, 
			ped_descricao, 
			ped_condicao
			) values (
			'$codpedido', 
			'$dataemissao', 
			'$formapgto', 
			'$total', 
			'$id_usuario', 
			'$cliente', 
			'Venda consumidor', 
			'$condPagamento'
			)";		
	if (!($conn -> Execute($sql))) {
			$erro.='Erro:'.$conn -> ErrorMsg().'<BR>'.$sql;
	}	



for($i=0;$i<sizeof($produto);$i++)
{
	$sql = "SELECT MAX(pedp_pedidosprodutos) as codigo FROM pedidosprodutos";
	$resultado = $conn->query($sql);
	while ($linha = $resultado->fetchRow()) 
	{		 			
		$codpedidosprodutos  = $linha[0]+1;
	}
	$subtotal[$i] = valorparaobanco($subtotal[$i]);
	$valorunitario[$i] = valorparaobanco($valorunitario[$i]);
	$sql = "insert into pedidosprodutos (
						pedp_pedidosprodutos, 
						pedp_pedido, 
						pedp_produto, 
						pedp_quantidade, 
						pedp_subtotal, 
						pedp_valorunitario
						) values (
						'$codpedidosprodutos', 
						'$codpedido', 
						'$produto[$i]', 
						'$quantidade[$i]', 
						'$subtotal[$i]', 
						'$valorunitario[$i]')";

	if (!($conn -> Execute($sql))) {
    	$erro.='Erro:'.$conn -> ErrorMsg().'<BR>'.$sql;
	}
	
}	
if($condPagamento == 1)
{	
	list($dia,$mes,$ano)= split("/",$dataentrada);
	$dataentrada = $ano."-".$mes."-".$dia;
	$total = $total - ($total*($desconto/100));
	
	$sql = "SELECT MAX(flux_fluxodecaixa) as codigo FROM fluxodecaixa";
	$resultado = $conn->query($sql);
	while ($linha = $resultado->fetchRow()) 
	{		 			
		$cod_conta  = $linha[0]+1;
	}
	$sql = "insert into fluxodecaixa (
				flux_fluxodecaixa, 
				flux_codigo, 
				flux_valor, 
				flux_parcela, 
				flux_tipopagamento, 
				flux_datavencimento, 
				flux_dataemissao, 
				flux_formapagamento, 
				flux_estahpago, 
				flux_categoriamovimentacao, 
				flux_codpessoa, 
				flux_qtdparcelas, 
				flux_descricao, 
				flux_codpedido
				) values (	
				'$cod_conta', 
				'$codpedido', 
				'$total', 
				'1', 
				'1', 
				'$dataentrada', 
				'$dataemissao', 
				'$formapgto', 
				'n', 
				11, 
				'$cliente', 
				1, 
				'Venda nº $codpedido', 
				'$codpedido'
			)";
	//echo $sql;
	if (!($conn -> Execute($sql))) {
			$erro.='Erro:'.$conn -> ErrorMsg().'<BR>'.$sql;
	}
	$sql = "update pedidos set ped_valortotal = '$total' where ped_pedido = '$codpedido'";
	if (!($conn -> Execute($sql))) {
			$erro.='Erro:'.$conn -> ErrorMsg().'<BR>'.$sql;
	}	
	
}else
{
	if($condPagamento == 2) //Á PRAZO S/ JUROS
	{
		$parcela = $total/$parcelas;
	}
		
	$datavencimento = $dataentrada;
	list($dia,$mes,$ano)= split("/",$datavencimento);
		
	for($i=1;$i<=$parcelas;$i++)
	{		
		$datavencimento = $ano."-".$mes."-".$dia;			
		///SE OS VENCIMENTOS CONTAM A PARTIR DA DATA DO PEDIDO, APÓS A ENTRADA CALCULO OS VENCIMENTOS COM BASE NA DATA ATUAL
		if($diasparcela == 1 && $i == 2)
		{			
			list($ano,$mes,$dia)= split("-",$dataemissao);
		}	
		if($i > 1)
		{
			$dia = $dia + $intervalo - 30;
			
			if($dia > 30)
			{
				$dia = 30;					
			}
			$mes += 1;
			if($mes > 12)
			{
				$mes = $mes - 12; 
				$ano += 1;
			}
			$datavencimento = $ano."-".$mes."-".$dia;				
		}		
		
		$sql = "SELECT MAX(flux_fluxodecaixa) as codigo FROM fluxodecaixa";
		$resultado = $conn->query($sql);
		while ($linha = $resultado->fetchRow()) 
		{		 			
			$cod_conta  = $linha[0]+1;
		}
		$sql = "insert into fluxodecaixa (flux_fluxodecaixa, flux_codigo, flux_valor, flux_parcela, flux_tipopagamento, flux_datavencimento, flux_dataemissao, flux_formapagamento, flux_estahpago, flux_categoriamovimentacao, flux_codpessoa, flux_qtdparcelas, flux_descricao, flux_codpedido) values ('$cod_conta', '$codpedido', '$parcela', '$i', '1', '$datavencimento', '$dataemissao', '$formapgto', 'n', 1, '$cliente', '$parcelas', 'Venda nº $codpedido', '$codpedido')";//echo $sql."<br>";
		if (!($conn -> Execute($sql))) {
				$erro.='Erro:'.$conn -> ErrorMsg().'<BR>'.$sql;
		}
	}
}	

if($erro == "")
{
	echo "<script>
			 location.href='../_funcoes/controller.php?opcao=home-pedidos';
      </script>";
	  
	$conn->disconnect();
}
else{
	include('../error/error.php');	
	
	print '<br><b>'.$erro.'</b><br>';
	
	print 'Contate o suporte técnico.';
	
	echo "<br><a href='javascript:history.go(-1);'>Voltar</a>";
}
echo $erro;
?>