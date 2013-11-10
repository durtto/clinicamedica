<?

session_start();
require_once("../_funcoes/funcoes.php");
$conn = conecta_banco();

$id_usuario = $_SESSION['id'];
$codos = $_GET['cod'];

$sql = "select ped_pedido from pedidos where ped_os = $codos";
$resultado = $conn->query($sql);
while ($linha = $resultado->fetchRow()) 
{		 			
	$cod_pedido  = $linha[0]+1;
}
if($cod_pedido == "")
{

	$sql = "delete from ordensprodutos where orde_ordemdeservico = $codos";
	if (!($conn -> Execute($sql))) {
		$erro='Erro:'.$conn -> ErrorMsg().'<BR>'.$sql;
	}
	echo $sql;
	$sql = "delete from ordensdeservico where ord_ordemdeservico = $codos";
	if (!($conn -> Execute($sql))) {
		$erro='Erro:'.$conn -> ErrorMsg().'<BR>'.$sql;
	}	
}else{		
	$erro = "Já existe um pedido cadastrado para este orçamento, exclua o mesmo antes de excluir esta OS.";
	echo "<script>
		 location.href='../error/error.php?erro=$erro';
  </script>";
}	
echo $erro;
if($erro == "")
{
		echo "<script>
				 location.href='../_funcoes/controller.php?opcao=home-os';
		  </script>";
}
else{
	include('../error/error.php');	
	
	print '<br><b>'.$erro.'</b><br>';
	
	print 'Contate o suporte técnico.';
	
	echo "<br><a href='javascript:history.go(-1);'>Voltar</a>";
}

?>