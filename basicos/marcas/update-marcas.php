<?
session_start();
require_once("../../_funcoes/funcoes.php");

$conn = conecta_banco();
$cod = $_POST['cod'];
$nome = $_POST['nome'];

$sql1 = "update marcas set mar_nome = '$nome' where mar_marca ='$cod'";

if (!($conn -> Execute($sql1))) {
    $erro='Erro:'.$conn -> ErrorMsg().'<BR>'.$sql1;
}
if($erro != '')	{		
	include('../../error/error.php?erro='.$erro);	
	
}
else{	
	echo "<script>
		 location.href='../../_funcoes/controller.php?opcao=home-marcas';
	  </script>";	
}
?>