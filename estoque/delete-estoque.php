<?
session_start();
require_once("../_funcoes/funcoes.php");
$conn = conecta_banco();

$cod = $_GET['cod'];

if(true)
{		
	
	
	$sql = "delete from produtos where pro_produto = '$cod'";	
	
	if (!($conn -> Execute($sql))) {
		$erro .= 'Erro:'.$conn -> ErrorMsg().'<BR>'.$sql.'<BR>';
	}	
}
if($erro == "")
{
	echo "<script>
         location.href='../_funcoes/controller.php?opcao=home-estoque';
      	  </script>";
	  
	$conn->disconnect();
}
else if($erroSenha != '' || $erro != '')
{
	include('../error/error.php');	
	if($erroSenha)
	{
		print '<br><b>'.$erroSenha.'<br></b>';
	}else{
	print 'Contate o suporte técnico.';
	}
	echo "<br><a href='javascript:history.go(-1);'>Voltar</a>";
}

?>