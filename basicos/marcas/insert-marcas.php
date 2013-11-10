<?
session_start();
require_once("../../_funcoes/funcoes.php");

$conn = conecta_banco();

$nome = $_POST['nome'];


$sql = "SELECT MAX(mar_marca) as codigo FROM marcas";
$resultado = $conn->query($sql);
while ($linha = $resultado->fetchRow()) 
{		 			
	$codmarca  = $linha[0]+1;
}

$sql1 = "insert into marcas (mar_marca, mar_nome) values ('$codmarca','$nome')";

if (!($conn -> Execute($sql1))) {
    $erro='Erro inserindo:'.$conn -> ErrorMsg().'<BR>'.$sql1;
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