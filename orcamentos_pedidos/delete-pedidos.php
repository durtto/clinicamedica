<?

session_start();
require_once("../_funcoes/funcoes.php");
$conn = conecta_banco();

$id_usuario = $_SESSION['id'];
$cod_pedido = $_GET['cod'];

	$sql = "SELECT flux_fluxodecaixa as codigo FROM fluxodecaixa WHERE flux_codpedido = ".$cod_pedido;
	$resultado = $conn->query($sql);
	if($resultado)
	{	
		$sql = "delete from fluxodecaixa where flux_codpedido = $cod_pedido";
		if (!($conn -> Execute($sql))) {
			echo "<script>
					 location.href='../error/error.php?erro=Esta movimentação já ocorreu na conta da empresa.';
			  </script>";	
			break;
		}
		$sql = "delete from pedidosprodutos where pedp_pedido = $cod_pedido";
		if (!($conn -> Execute($sql))) {
			//$erro='Erro:'.$conn -> ErrorMsg().'<BR>'.$sql;
		}
		$sql = "delete from pedidos where ped_pedido = $cod_pedido";
		if (!($conn -> Execute($sql))) {
			$erro='Erro:'.$conn -> ErrorMsg().'<BR>'.$sql;
		}
	}else{
		$sql = "delete from pedidosprodutos where pedp_pedido = $cod_pedido";
		if (!($conn -> Execute($sql))) {
			//$erro='Erro:'.$conn -> ErrorMsg().'<BR>'.$sql;
		}	
		$sql = "delete from pedidos where ped_pedido = $cod_pedido";
		if (!($conn -> Execute($sql))) {
			$erro='Erro:'.$conn -> ErrorMsg().'<BR>'.$sql;
		}	
	}
if($erro == "")
{

		echo "<script>
				 location.href='../_funcoes/controller.php?opcao=home-pedidos';
		  </script>";

}
else{
	include('../error/error.php');	
	
	print '<br><b>'.$erro.'</b><br>';
	
	print 'Contate o suporte técnico.';
	
	echo "<br><a href='javascript:history.go(-1);'>Voltar</a>";
}

?>