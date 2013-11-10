<?

session_start();
require_once("../_funcoes/funcoes.php");
$conn = conecta_banco();

$id_usuario = $_SESSION['id'];

$cliente = $_POST['cliente'];
$responsavel = $_POST['responsavel'];
$data = date('Y-m-d');
$defeito = $_POST['defeito'];
$total = $_POST['total'];
$total = valorparaobanco($total);
$equipamento = $_POST['equipamento'];
$defeito = $_POST['defeito'];
$observacoes = $_POST['observacoes'];
$produto = $_POST['produto_'];
$valorunitario = $_POST['valor'];
$quantidade = $_POST['quantidade'];
$subtotal = $_POST['subtotal'];

	$sql = "SELECT MAX(ord_ordemdeservico) as codigo FROM ordensdeservico";
	$resultado = $conn->query($sql);
	while ($linha = $resultado->fetchRow()) 
	{		 			
		$codos  = $linha[0]+1;
	}	

	$sql = "insert into ordensdeservico (ord_ordemdeservico, ord_cliente, ord_responsavel, ord_situacao, ord_defeito, ord_equipamento, ord_dataentrada, ord_valor, ord_observacoes) values ('$codos', '$cliente', '$responsavel', '1', '$defeito', '$equipamento', '$data', '$total', '$observacoes')";		
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

//echo $erro;
if($erro == "")
{
	echo "<script>
			 location.href='../_funcoes/controller.php?opcao=home-os';
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