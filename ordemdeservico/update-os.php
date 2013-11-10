<?

session_start();
require_once("../_funcoes/funcoes.php");
$conn = conecta_banco();

$id_usuario = $_SESSION['id'];
$codos = $_POST['cod'];
$cliente = $_POST['cliente'];
$responsavel = $_POST['responsavel'];

$defeito = $_POST['defeito'];
$total = $_POST['total'];
$total = valorparaobanco($total);
$equipamento = $_POST['equipamento'];
$defeito = $_POST['defeito'];
$observacoes = $_POST['observacoes'];
$situacao = $_POST['situacao'];

$produto = $_POST['produto_'];
$valorunitario = $_POST['valor'];
$quantidade = $_POST['quantidade'];
$subtotal = $_POST['subtotal'];
$dataemissao = date('Y-m-d');

$datasaida = $_POST['datasaida'];
$parte = $_POST['parte'];


if(!$parte)
{
	///DELETO TODOS OS PRODUTOS DESTA OS PARA INSERIR OS SELECIONADOS////
	$sql = "delete from ordensprodutos WHERE orde_ordemdeservico = '$codos'";	
	if (!($conn -> Execute($sql))) {
		$erro.='Erro:'.$conn -> ErrorMsg().'<BR>'.$sql;
	}
	if($produto)
	{	
		for($i=0;$i<sizeof($produto);$i++)
		{
			$sql = "SELECT MAX(orde_ordenproduto) as codigo FROM ordensprodutos";
			$resultado = $conn->query($sql);
			while ($linha = $resultado->fetchRow()) 
			{		 			
				$codordensprodutos  = $linha[0]+1;
			}
			$subtotal[$i] = valorparaobanco($subtotal[$i]);
			$valorunitario[$i] = valorparaobanco($valorunitario[$i]);
			$sql = "insert into ordensprodutos (orde_ordenproduto, orde_ordemdeservico, orde_produto, orde_quantidade, orde_subtotal, orde_valorunitario) values ('$codordensprodutos', '$codos', '$produto[$i]', '$quantidade[$i]', '$subtotal[$i]', '$valorunitario[$i]')";
			
			if (!($conn -> Execute($sql))) {
				$erro.='Erro:'.$conn -> ErrorMsg().'<BR>'.$sql;
			}
			
		}	
	}
	if($situacao == 4)
	{
		///SE VAI ENCERRAR A OS, DEPOIS REDIRECIONA PARA A TELA DO PEDIDO E UM CONTA NO FLUXO DE CAIXA///
		
		$datasaida = dataparaobanco($datasaida);
			
		$sql = "update ordensdeservico set ord_cliente = '$cliente', ord_responsavel = '$responsavel', ord_situacao = '$situacao', ord_defeito = '$defeito', ord_equipamento = '$equipamento', ord_datasaida = '$datasaida', ord_valor = $total, ord_observacoes = '$observacoes' WHERE ord_ordemdeservico = '$codos'";				
	}else{
		$sql = "update ordensdeservico set ord_cliente = '$cliente', ord_responsavel = '$responsavel', ord_situacao = '$situacao', ord_defeito = '$defeito', ord_equipamento = '$equipamento', ord_valor = $total, ord_datasaida = null, ord_observacoes = '$observacoes' WHERE ord_ordemdeservico = '$codos'";	
			
	}
	
	if (!($conn -> Execute($sql))) {
			$erro.='Erro:'.$conn -> ErrorMsg().'<BR>'.$sql;
	}	
}else if($parte == 2)
{
	
	$sql =			"SELECT ".
				" ord_ordemdeservico, ord_cliente, ord_responsavel, ord_situacao, ord_defeito, ord_dataentrada, ord_datasaida, ord_valor, ord_equipamento ".				
				" FROM ordensdeservico WHERE ord_ordemdeservico = $codos";

	$resultado = $conn->query($sql);
	while ($linha = $resultado->fetchRow()) 
	{		 			
		  $codos  = $linha[0];
		  $cod_cliente  = $linha[1];
		  $cod_responsavel  = $linha[2];
		  $cod_situacao  = $linha[3];
		  $defeito  = $linha[4];  
		  $dataentrada = $linha[5];
		  $datasaida = $linha[6];
		  $total = $linha[7];
		  $equipamento = $linha[8];
	}	
	
	///VERIFICAÇÃO E ATUALIZAÇÃO DO ESTOQUE///	
	$sql = "SELECT orde_produto, orde_quantidade FROM ordensprodutos WHERE orde_ordemdeservico = '$codos'";
	$result = $conn->query($sql);
	//echo $sql."<br>";
	while ($linha = $result->fetchRow()) 
	{		 			
		$codproduto  = $linha[0];
		$qtd_orcada = $linha[1];
		
		$sql = "select pro_quantidade, pro_nome from produtos where pro_produto = $codproduto";
		$resul = $conn->query($sql);
		$linha = $resul->fetchRow();			 					 			
		$qtd_estoque  = $linha[0];
		$nomeproduto = $linha[1];
		///SE NÃO HOUVER QTD. SUFICIENTE NO ESTOQUE, O MESMO FICARÁ NEGATIVO///
		if($qtd_orcada <= $qtd_estoque)
		{
		}
			$qtd = $qtd_estoque - $qtd_orcada;
			$sql = "update produtos set pro_quantidade = $qtd where pro_produto = $codproduto";
			if (!($conn -> Execute($sql))) {
				$erro.='Erro:'.$conn -> ErrorMsg().'<BR>'.$sql;
			}		
			//$erro_estoque .= "A quantidade ($qtd_orcada) do produto <em>$nomeproduto</em> no pedido é maior do que disponível em estoque!";		
	}
	
	$dataemissao = date('Y-m-d');
	$dataentrada = $_POST['dataentrada'];			
	$formapgto = $_POST['formapagto'];
	$intervalo = $_POST['intervalo'];
	$diasparcela = $_POST['diasparcela'];
	$desconto = $_POST['desconto'];
	$parcelas = $_POST['parcelas'];
	$condicao = $_POST['condicao'];
	$parcelasjuros = $_POST['parcelasjuros'];
	if($condicao == 1)
	{
		$sql = "SELECT MAX(ped_pedido) as codigo FROM pedidos";
		$resultado = $conn->query($sql);
		while ($linha = $resultado->fetchRow()) 
		{		 			
			$codpedido  = $linha[0]+1;
		}
		$total = $total - ($total*($desconto/100));	
		
		///ATUALIZA O TOTAL COM O DESCONTO NA OS///
		$sql = "update ordensdeservico set ord_valor = $total WHERE ord_ordemdeservico = '$codos'";					
		if (!($conn -> Execute($sql))) {
				$erro.='Erro:'.$conn -> ErrorMsg().'<BR>'.$sql;
		}
		
		$sql = "insert into pedidos (ped_pedido, ped_os, ped_data, ped_formapagto, ped_valortotal, ped_responsavel, ped_cliente, ped_descricao) values ('$codpedido', '$codos', '$datasaida', '$formapgto', '$total', '$cod_responsavel', '$cod_cliente', 'OS nº $codos')";		
		if (!($conn -> Execute($sql))) {
				$erro.='Erro:'.$conn -> ErrorMsg().'<BR>'.$sql;
		}	
		$sql = "SELECT MAX(flux_fluxodecaixa) as codigo FROM fluxodecaixa";
		$resultado = $conn->query($sql);
		while ($linha = $resultado->fetchRow()) 
		{		 			
			$cod_conta  = $linha[0]+1;
		}
			
		list($dia,$mes,$ano)= split("/",$dataentrada);
		$dataentrada = $ano."-".$mes."-".$dia;
		$sql = "insert into fluxodecaixa (flux_fluxodecaixa, flux_codigo, flux_valor, flux_parcela, flux_tipopagamento, flux_datavencimento, flux_dataemissao, flux_formapagamento, flux_estahpago, flux_categoriamovimentacao, flux_codpessoa, flux_qtdparcelas, flux_descricao, flux_codpedido) values ('$cod_conta', '$codpedido', '$total', '1', '1', '$dataentrada', '$dataemissao', '$formapgto', 'n', 1, '$cliente', 1, 'OS nº $codos', '$codpedido')";
		if (!($conn -> Execute($sql))) {
				$erro.='Erro:'.$conn -> ErrorMsg().'<BR>'.$sql;
		}	
	}else{
	
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
			$sql = "SELECT MAX(ped_pedido) as codigo FROM pedidos";
			$resultado = $conn->query($sql);
			while ($linha = $resultado->fetchRow()) 
			{		 			
				$codpedido  = $linha[0]+1;
			}
			$sql = "insert into pedidos (ped_pedido, ped_os, ped_data, ped_formapagto, ped_valortotal, ped_responsavel, ped_cliente, ped_descricao) values ('$codpedido', '$codos', '$datasaida', '$formapgto', '$total', '$cod_responsavel', '$cod_cliente', 'OS nº $codos')";	
			if (!($conn -> Execute($sql))) {
					$erro.='Erro:'.$conn -> ErrorMsg().'<BR>'.$sql;
			}
			//echo $sql."<br>";
			$datavencimento = $dataentrada;
			list($dia,$mes,$ano)= split("/",$datavencimento);
			for($i=1;$i<=$parcelas;$i++)
			{		
				$datavencimento = $ano."-".$mes."-".$dia;			
				///SE OS VENCIMENTOS CONTAM A PARTIR DA DATA DO PEDIDO, APÓS A ENTRADA CALCULO OS VENCIMENTOS COM BASE NA DATA ATUAL
				if($diasparcela == 1 && $i == 2)
				{			
					$dia = date("d");
					$mes =  date("m");
					$ano = date("Y");
				}
			
				if($i > 1)
				{
					$dia = $dia + $intervalo - 30;
					
					if($dia > 30)
					{
						$dia = 30;					
					}
					$mes += 1;
					if($mes == 2 && $dia > 28)
					{
						$dia = 28;
					}
					if($mes > 12)
					{
						$mes = $mes - 12; 
						$ano += 1;
					}
					$datavencimento = $ano."-".$mes."-".$dia;				
				}
				$sql = "SELECT MAX(flux_fluxodecaixa) as codigo FROM fluxodecaixa";
				$resultado3 = $conn->query($sql);
				$linha = $resultado3->fetchRow();						 			
				$cod_conta  = $linha[0] + 1;				
								
				$sql = "insert into fluxodecaixa (flux_fluxodecaixa, flux_codigo, flux_valor, flux_parcela, flux_tipopagamento, flux_datavencimento, flux_dataemissao, flux_formapagamento, flux_estahpago, flux_categoriamovimentacao, flux_codpessoa, flux_qtdparcelas, flux_descricao, flux_codpedido) values ('$cod_conta', '$codpedido', '$parcela', '$i', '1', '$datavencimento', '$dataemissao', '$formapgto', 'n', 1, '$cliente', '$parcelas', 'OS nº $codos', '$codpedido')";
				echo $sql."<br>";
				if (!($conn -> Execute($sql))) {
						$erro.='Erro:'.$conn -> ErrorMsg().'<BR>'.$sql;
				}					
			}				
	}
}
//echo $erro;
if($erro == "")
{
	if($situacao == 4 && $total > 0)
	{
		echo "<script>
				 location.href='./editar-os-encerrar.php?cod=$codos';
		  </script>";	
	}else{	
			echo "<script>
				 location.href='../_funcoes/controller.php?opcao=home-os';
		  </script>";
	}

	
	$conn->disconnect();
}
else{
	include('../error/error.php');	
	
	print '<br><b>'.$erro.'</b><br>';
	
	print 'Contate o suporte técnico.';
	
	echo "<br><a href='javascript:history.go(-1);'>Voltar</a>";
}

?>