<?

session_start();
require_once("../_funcoes/funcoes.php");
$conn = conecta_banco();

$id_usuario = $_SESSION['id'];
$cod_pedido = $_POST['cod'];
$datapedido = $_POST['datapedido'];
$dataentrada = $_POST['dataentrada'];
$parcelas = $_POST['parcelas'];
$desconto = $_POST['desconto'];
$parcelasjuros = $_POST['parcelasjuros'];


$condicao = $_POST['condicao'];
$dataentrada = $_POST['dataentrada'];	

$formapgto = $_POST['formapagto'];
$intervalo = $_POST['intervalo'];
$diasparcela = $_POST['diasparcela'];
$total = $_POST['total'];
$total = valorparaobanco($total);
$dataemissao = date('Y-m-d');

$produto = $_POST['produto_'];
$quantidade = $_POST['quantidade'];
$subtotal = $_POST['subtotal'];
$valorunitario = $_POST['valor'];


///DELETO TODOS OS PRODUTOS DESTE ORCAMENTO PARA INSERIR OS SELECIONADOS////
if($produto)
{
	$sql = "delete from pedidosprodutos WHERE pedp_pedido = '$cod_pedido'";	
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
		$valorunitario[$i] = valorparaobanco($valorunitario[$i]);
		$subtotal[$i] = valorparaobanco($subtotal[$i]);
		$sql = "insert into pedidosprodutos (pedp_pedidosprodutos, pedp_pedido, pedp_produto, pedp_quantidade, pedp_subtotal, pedp_valorunitario) values ('$codpedidosprodutos', '$cod_pedido', '$produto[$i]', '$quantidade[$i]', '$subtotal[$i]', '$valorunitario[$i]')";
	
		if (!($conn -> Execute($sql))) {
			$erro.='Erro:'.$conn -> ErrorMsg().'<BR>'.$sql;
		}		
	}	
}

///DESAPROVOS OS ORÇAMENTOS PARA DEPOIS APROVAR O SELECIONADO///
$sql = "update orcamentoscondicoespagamento set ocon_estahaprovado = '' where ocon_orcamento = '$cod_pedido'";	
if (!($conn -> Execute($sql))) {
		$erro.='Erro:'.$conn -> ErrorMsg().'<BR>'.$sql;
}
if($condicao == 2)
{
	$aux = ", ocon_qtdparcelas = $parcelas";
}else if($condicao == 3)
{
	$aux = ", ocon_qtdparcelas = $parcelasjuros";
}
else{
	$aux = ", ocon_desconto = $desconto";	
}
$sql = "update orcamentoscondicoespagamento set ocon_estahaprovado = 's' $aux where ocon_orcamento = '$cod_pedido' and ocon_condicaopagamento =  '$condicao'";	
if (!($conn -> Execute($sql))) {
		$erro.='Erro:'.$conn -> ErrorMsg().'<BR>'.$sql;
}
$sql = "SELECT orc_orcamento, orc_descricao, orc_cliente, orc_data, orc_total, orc_situacao, orc_parceiro ". 
		"FROM orcamentos WHERE orc_orcamento = '$cod_pedido'";		

$resultado = $conn -> query($sql);
while ($linha = $resultado->fetchRow()) 
{		 			
	$cod_pedido  = $linha[0];
	$descricao  = $linha[1];
	$cliente  = $linha[2];
	$data  = $linha[3];
	$valor_total  = $linha[4];
	$situacao = $linha[5];	
	$parceiro = $linha[6];			
}
if($condicao == 1)
{	
	list($dia,$mes,$ano)= split("/",$dataentrada);
	$dataentrada = $ano."-".$mes."-".$dia;
	$total = $total - ($total*($desconto/100));
	
	$sql = "update pedidos set ped_formapagto = '$formapgto', ped_valortotal = '$total', ped_condicao = '$condicao' WHERE ped_pedido = '$cod_pedido'";		
	if (!($conn -> Execute($sql))) {
			$erro.='Erro:'.$conn -> ErrorMsg().'<BR>'.$sql;
	}	
	///1º DELETO AS CONTAS DESTE PEDIDO, PARA DEPOIS INSERIR DE ACORDO COM A CONDIÇÃO SELECIONADA///
	$sql = "delete from fluxodecaixa where flux_codpedido = '$cod_pedido'";
	if (!($conn -> Execute($sql))) {
			$erro.='Erro:'.$conn -> ErrorMsg().'<BR>'.$sql;
	}
		
	$sql = "SELECT MAX(flux_fluxodecaixa) as codigo FROM fluxodecaixa";
	$resultado = $conn->query($sql);
	while ($linha = $resultado->fetchRow()) 
	{		 			
		$cod_conta  = $linha[0]+1;
	}
	$sql = "insert into fluxodecaixa (flux_fluxodecaixa, flux_codigo, flux_valor, flux_parcela, flux_tipopagamento, flux_datavencimento, flux_dataemissao, flux_formapagamento, flux_estahpago, flux_categoriamovimentacao, flux_codpessoa, flux_qtdparcelas, flux_descricao, flux_codpedido) values ('$cod_conta', '$cod_pedido', '$total', '1', '1', '$dataentrada', '$dataemissao', '$formapgto', 'n', 1, '$cliente', 1, 'Venda nº $cod_pedido', '$cod_pedido')";
	if (!($conn -> Execute($sql))) {
			$erro.='Erro:'.$conn -> ErrorMsg().'<BR>'.$sql;
	}	
	
}else
{
	if($condicao == 2) //Á PRAZO S/ JUROS
	{
		$parcela = $total/$parcelas;
	}else{
		//C/ JUROS
		$parcelas = $parcelasjuros;
		$parcela = $total/$parcelas;
		$sql = "SELECT par_taxadejuros FROM parametros";
		$resultado = $conn->query($sql);
		$linha = $resultado->fetchRow(); 
		$taxa  = $linha[0];
		$juro = $total * ($taxa/100);
		$parcela = $parcela + $juro;
		$total = $parcelas * $parcela;
	}
	
	$sql = "update pedidos set ped_formapagto = '$formapgto', ped_intervalo = '$intervalo', ped_diasapos = '$diasparcela', ped_valortotal = '$total', ped_condicao = '$condicao' where ped_pedido = '$cod_pedido'";
	if (!($conn -> Execute($sql))) {
			$erro.='Erro:'.$conn -> ErrorMsg().'<BR>'.$sql;
	}
	//echo $sql."<br>";
	$datavencimento = $dataentrada;
	list($dia,$mes,$ano)= split("/",$datavencimento);
	
	///1º DELETO AS CONTAS DESTE PEDIDO, PARA DEPOIS INSERIR DE ACORDO COM A CONDIÇÃO SELECIONADA///
	$sql = "delete from fluxodecaixa where flux_codpedido = '$cod_pedido'";
	if (!($conn -> Execute($sql))) {
			$erro.='Erro:'.$conn -> ErrorMsg().'<BR>'.$sql;
	}
	
	for($i=1;$i<=$parcelas;$i++)
	{		
		$datavencimento = $ano."-".$mes."-".$dia;			
		///SE OS VENCIMENTOS CONTAM A PARTIR DA DATA DO PEDIDO, APÓS A ENTRADA CALCULO OS VENCIMENTOS COM BASE NA DATA ATUAL
		if($diasparcela == 1 && $i == 2)
		{			
			list($dia,$mes,$ano)= split("/",$datapedido);
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
		$sql = "insert into fluxodecaixa (flux_fluxodecaixa, flux_codigo, flux_valor, flux_parcela, flux_tipopagamento, flux_datavencimento, flux_dataemissao, flux_formapagamento, flux_estahpago, flux_categoriamovimentacao, flux_codpessoa, flux_qtdparcelas, flux_descricao, flux_codpedido) values ('$cod_conta', '$cod_pedido', '$parcela', '$i', '1', '$datavencimento', '$dataemissao', '$formapgto', 'n', 1, '$cliente', '$parcelas', 'Venda nº $cod_pedido', '$cod_pedido')";//echo $sql."<br>";
		if (!($conn -> Execute($sql))) {
				$erro.='Erro:'.$conn -> ErrorMsg().'<BR>'.$sql;
		}	
	}
}	
echo $erro;
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

?>