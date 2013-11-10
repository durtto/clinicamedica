<?
session_start();
require_once("../_funcoes/funcoes.php");
$conn = conecta_banco();
$id_usuario = $_SESSION['id'];

$cod_fluxodecaixa = $_GET['cod'];

$sql = "delete from fluxodecaixa where flux_fluxodecaixa = '$cod_fluxodecaixa'";	
if(!($conn -> Execute($sql))) {
	echo "<script>
			 location.href='../error/error.php?erro=Esta movimentação já ocorreu na conta da empresa.';
	  </script>";	
	break;
	echo $sql;
} 
if($erro == "")
{	
	echo "<script>
				 location.href='../_funcoes/controller.php?opcao=home-financeiro';
		  </script>";	
	$conn->disconnect();
}
else{
	include('../error/error.php?erro='.$erro);	
}

?>