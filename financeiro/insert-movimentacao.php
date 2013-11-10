<?
session_start();
require_once("../_funcoes/funcoes.php");
$conn = conecta_banco();
$id_usuario = $_SESSION['id'];

$sacado = $_POST['sacado'];
$conta = $_POST['conta'];
$tipopagamento = $_POST['tipopagamento'];
$formapagto = $_POST['formapagto'];
$valorparcela = $_POST['valorparcela'];
$datavencimento = $_POST['datavencimento'];
$datapagamento = $_POST['datapagamento'];
$parcelas = $_POST['qtdparcelas'];
$categoria = $_POST['categoria'];
$intervalo = $_POST['intervalo'];
$descricao = $_POST['descricao'];
$dataemissao = date("Y-m-d");

$valorparcela = valorparaobanco($valorparcela);

$sql = "SELECT MAX(flux_codigo) as codigo FROM fluxodecaixa";
$resultado = $conn->query($sql);
while ($linha = $resultado->fetchRow()) 
{		 			
	$cod_conta  = $linha[0]+1;
}
if($datapagamento == "")
{		
	list($dia,$mes,$ano)= split("/",$datavencimento);
	$datavencimento = $ano."-".$mes."-".$dia;
	for($i=1;$i<=$parcelas;$i++)
	{			
		///SE OS VENCIMENTOS CONTAM A PARTIR DA DATA DO PEDIDO, APÓS A ENTRADA CALCULO OS VENCIMENTOS COM BASE NA DATA ATUAL
		/*if($diasparcela == 1 && $i == 2)
		{			
			list($dia,$mes,$ano)= split("/",$datapedido);
		}*/	
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
			if($mes == 2 && $dia > 28)
			{
				$dia = 28;
			}
			if(strlen($dia)<2)
			{
				$dia = "0".$dia;
			}
			if(strlen($mes)<2)
			{
				$mes = "0".$mes;
			}
			$datavencimento = $ano."-".$mes."-".$dia;				
		}
		$sql = "SELECT MAX(flux_fluxodecaixa) as codigo FROM fluxodecaixa";
		$resultado = $conn->query($sql);
		while ($linha = $resultado->fetchRow()) 
		{		 			
			$cod_fluxodecaixa  = $linha[0]+1;
		}
		if($conta != 'null')
		{
			$sql = "insert into fluxodecaixa (flux_fluxodecaixa, flux_parcela, flux_codpessoa, flux_dataemissao, flux_datavencimento, flux_tipopagamento, flux_formapagamento, flux_codigo, flux_qtdparcelas, flux_valor, flux_codconta, flux_estahpago, flux_categoriamovimentacao, flux_descricao) values ('$cod_fluxodecaixa', '$i', '$sacado', '$dataemissao', '$datavencimento', '$tipopagamento', '$formapagto', '$cod_conta', '$parcelas', '$valorparcela', $conta, 'N', '$categoria', '$descricao')";
		}else{
			$sql = "insert into fluxodecaixa (flux_fluxodecaixa, flux_parcela, flux_codpessoa, flux_dataemissao, flux_datavencimento, flux_tipopagamento, flux_formapagamento, flux_codigo, flux_qtdparcelas, flux_valor, flux_estahpago, flux_categoriamovimentacao, flux_descricao) values ('$cod_fluxodecaixa', '$i', '$sacado', '$dataemissao', '$datavencimento', '$tipopagamento', '$formapagto', '$cod_conta', '$parcelas', '$valorparcela', 'N', '$categoria', '$descricao')";
		}
		//echo $sql."<br>";		
		if (!($conn -> Execute($sql))) {
		$erro.='Erro:'.$conn -> ErrorMsg().'<BR>'.$sql;
		}
	}	
}else{
	list($dia,$mes,$ano)= split("/",$datapagamento);
	$datapagamento = $ano."-".$mes."-".$dia;
	list($dia,$mes,$ano)= split("/",$datavencimento);
	$datavencimento = $ano."-".$mes."-".$dia;
	for($i=1;$i<=$parcelas;$i++)
	{			
		
		if($i > 1)
		{			
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
			if(strlen($dia)<2)
			{
				$dia = "0".$dia;
			}
			if(strlen($mes)<2)
			{
				$mes = "0".$mes;
			}
			$datavencimento = $ano."-".$mes."-".$dia;				
		}
		$sql = "SELECT MAX(flux_fluxodecaixa) as codigo FROM fluxodecaixa";
		$resultado = $conn->query($sql);
		while ($linha = $resultado->fetchRow()) 
		{		 			
			$cod_fluxodecaixa  = $linha[0]+1;
		}
		if($conta != 'null')
		{
			$sql = "insert into fluxodecaixa (flux_fluxodecaixa, flux_parcela, flux_codpessoa, flux_dataemissao, flux_datavencimento, flux_tipopagamento, flux_formapagamento, flux_codigo, flux_qtdparcelas, flux_valor, flux_codconta, flux_datapagamento, flux_estahpago, flux_categoriamovimentacao, flux_descricao) values ('$cod_fluxodecaixa', '$i', '$sacado', '$dataemissao', '$datavencimento', '$tipopagamento', '$formapagto', '$cod_conta', '$parcelas', '$valorparcela', $conta, '$datapagamento', 'S', '$categoria', '$descricao')";
		}else{
			echo "<script>
				 location.href='../error/error.php?erro=Se a data de pagamento está preenchida, você deve informar uma conta (origem/destino) para realizar a transação.';
		  </script>";	
		  	break;
		}			
		if (!($conn -> Execute($sql))) {
		$erro.='Erro:'.$conn -> ErrorMsg().'<BR>'.$sql;
		}
		///SE POSSUI DATA DE PAGAMENTO, PROCEDE PARA MOVIMENTAÇÃO DA CONTA BANCÁRIA///		
		$sql = "SELECT con_saldoatual FROM contas WHERE con_conta = $conta";
		$resultado = $conn->query($sql);
		while ($linha = $resultado->fetchRow()) 
		{		 			
			$saldoatual  = $linha[0];
		}
		if($tipopagamento == 1)
		{
			$saldoatual = $saldoatual + $valorparcela;
		}else{		
			$saldoatual = $saldoatual - $valorparcela;			
		}
		$sql = "SELECT max(com_codigoordem) FROM contasmovimentacao";
		$resultado = $conn->query($sql);
		while ($linha = $resultado->fetchRow()) 
		{		 			
			$codordem  = $linha[0]+1;
		}
		$sql = "insert into contasmovimentacao (com_codigoordem, com_movimentacao, com_conta, com_saldo, com_valormovimentado, com_tipopagamento, com_fluxodecaixa, com_datamovimentacao) values ('$codordem', '$cod_conta', '$conta', '$saldoatual', '$valorparcela', '$tipopagamento', '$cod_fluxodecaixa', '$datapagamento')";
		if (!($conn -> Execute($sql))) {
		$erro.='Erro:'.$conn -> ErrorMsg().'<BR>'.$sql;
		}	
		$sql = "UPDATE contas set con_saldoatual = $saldoatual where con_conta = $conta";
		if (!($conn -> Execute($sql))) {
			$erro.='Erro:'.$conn -> ErrorMsg().'<BR>'.$sql;
		}
	}
}



if($erro == "")
{	
	if($_POST['gerarrecibo']=="on" && $datapagamento)
	{
		echo "<script>
				 window.open('./docs/gerar-recibo.php?cod=".$cod_conta."');
		  </script>";
	}
	echo "<script>
				 location.href='../_funcoes/controller.php?opcao=home-financeiro';
		  </script>";	
	$conn->disconnect();
}
else{

	include('../error/error.php?erro='.$erro);	
}

?>