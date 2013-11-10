<?
session_start();
require_once("../../_funcoes/funcoes.php");

$conn = conecta_banco();
$cod = $_POST['cod'];
$nome = $_POST['nome'];

$sql1 = "update setores set set_nome = '$nome' where set_setor ='$cod'";

if (!($conn -> Execute($sql1))) {
    $erro='Erro:'.$conn -> ErrorMsg().'<BR>'.$sql1;
}
if($erro != '')	{		
	include('../../error/error.php?erro='.$erro);	
	
}
else{	
	echo "<script>
		 location.href='../_funcoes/controller.php?opcao=home-setores';
	  </script>";	
}
?>