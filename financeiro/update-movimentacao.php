<?
session_start();
require_once("../_funcoes/funcoes.php");
$conn = conecta_banco();
$id_usuario = $_SESSION['id'];
$cod_conta = $_POST['cod'];
$cod_fluxodecaixa = $_POST['cod_fluxo'];
$sacado = $_POST['sacado'];
$conta = $_POST['conta'];
$tipopagamento = $_POST['tipopagamento'];
$formapagto = $_POST['formapagto'];
$valorparcela = $_POST['valorparcela'];
$datavencimento = $_POST['datavencimento'];
$datapagamento = $_POST['datapagamento'];
$parcelas = $_POST['qtdparcelas'];
$categoria = $_POST['categoria'];
$descricao = '"'.$_POST['descricao'].'"';
$cedente = 0;


$valorparcela = valorparaobanco($valorparcela);

list($dia,$mes,$ano)= split("/",$datavencimento);
$datavencimento = $ano."-".$mes."-".$dia;

if($datapagamento == "")
{	
	///PRIMEIRO TESTO SE REALMENTE ESTA MOVIMENTAÇÃO NAO OCORREU NA CONTA///
	$sql = "SELECT com_movimentacao, com_fluxodecaixa, com_valormovimentado, com_tipopagamento FROM contasmovimentacao WHERE com_movimentacao = $cod_conta AND com_fluxodecaixa = $cod_fluxodecaixa";
	$resultado = $conn->query($sql);
	if($resultado->numRows() > 0) 
	{		
		echo "<script>
				 location.href='../error/error.php?erro=Não é possível alterar uma movimentação que já ocorreu em uma das contas da empresa.';
		  </script>";	
		  break;
	}else{
	
		$sql = "update fluxodecaixa set flux_codconta = $conta, flux_valor = '$valorparcela', flux_codpessoa = $sacado, flux_datavencimento = '$datavencimento', flux_datapagamento = null, flux_formapagamento = '$formapagto', flux_tipopagamento = $tipopagamento, flux_estahpago = 'N', flux_categoriamovimentacao = '$categoria', flux_descricao = $descricao, flux_cedente = $cedente where flux_codigo = '$cod_conta' and flux_fluxodecaixa = '$cod_fluxodecaixa'";	
		
		if (!($conn -> Execute($sql))) {
			$erro.='Erro:'.$conn -> ErrorMsg().'<BR>'.$sql;
		}
	}
	
}else{
	if($conta == "" || $conta == "null")
	{
		echo "<script>
				 location.href='../error/error.php?erro=Selecione uma conta (origem/destino) ao informar a data de pagamento.';
		  </script>";	
		  break;
	}
	
		
	$sql = "SELECT com_movimentacao, com_fluxodecaixa, com_valormovimentado, com_tipopagamento FROM contasmovimentacao WHERE com_movimentacao = $cod_conta AND com_fluxodecaixa = $cod_fluxodecaixa";
	$resultado = $conn->query($sql);
	if($resultado->numRows() > 0) 
	{		
		echo "<script>
				 location.href='../error/error.php?erro=Não é possível alterar uma movimentação que já ocorreu em uma das contas da empresa.';
		  </script>";	
		  break;
		/*
		while ($linha = $resultado->fetchRow()) 
		{		 			
			$valormovimentado  = $linha[2];
			$tipopagto = $linha[3];
		}
		if(($tipopagamento == $tipopagto) && ($valorparcela > $valormovimentado) && ($tipopagamento == 1))
		{
			$saldoatual = $saldoatual + ($valorparcela - $valormovimentado);
		}else if(($tipopagamento == $tipopagto) && ($valorparcela < $valormovimentado) && ($tipopagamento == 1)){		
			$saldoatual = $saldoatual - ($valormovimentado - $valorparcela);			
		}else if(($tipopagamento == $tipopagto) && ($valorparcela > $valormovimentado) && ($tipopagamento == 2)){		
			$saldoatual = $saldoatual - ($valorparcela - $valormovimentado);			
		}else if(($tipopagamento == $tipopagto) && ($valorparcela < $valormovimentado) && ($tipopagamento == 2)){		
			$saldoatual = $saldoatual + ($valormovimentado - $valorparcela);			
		}else if(($tipopagamento != $tipopagto) && ($tipopagamento == 1)){		
			$saldoatual = $saldoatual + $valormovimentado + $valorparcela;			
		}else if(($tipopagamento != $tipopagto) && ($tipopagamento == 2)){		
			$saldoatual = $saldoatual - $valormovimentado - $valorparcela;			
		}
		
		
		$sql = "update contasmovimentacao set com_saldo = '$saldoatual', com_valormovimentado = '$valorparcela', com_tipopagamento = '$tipopagamento', com_datamovimentacao = '$datapagamento', com_conta = $conta where com_movimentacao = '$cod_conta' and com_fluxodecaixa = '$cod_fluxodecaixa'";
		if (!($conn -> Execute($sql))) {
		$erro.='Erro:'.$conn -> ErrorMsg().'<BR>'.$sql;
		}
		*/
		
	}else{	
	
		list($dia,$mes,$ano)= split("/",$datapagamento);
		$datapagamento = $ano."-".$mes."-".$dia;
		
		$sql = "update fluxodecaixa set 
				flux_codconta = $conta, 
				flux_valor = '$valorparcela', 
				flux_codpessoa = $sacado, 
				flux_datavencimento = '$datavencimento', 
				flux_datapagamento = '$datapagamento', 
				flux_formapagamento = '$formapagto', 
				flux_tipopagamento = $tipopagamento, 
				flux_estahpago = 'S', 
				flux_categoriamovimentacao = '$categoria', 
				flux_descricao = $descricao, 
				flux_cedente = $cedente 
				where flux_codigo = '$cod_conta' and flux_fluxodecaixa = '$cod_fluxodecaixa'";	
		
		if (!($conn -> Execute($sql))) {
			$erro.='Erro:'.$conn -> ErrorMsg().'<BR>'.$sql;
		}
	
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
	$conn->disconnect();
	echo "<script>
				 location.href='../_funcoes/controller.php?opcao=home-financeiro';
		  </script>";		
}
else{
	echo $erro;
	include('../error/error.php?erro='.$erro);	
}

?>