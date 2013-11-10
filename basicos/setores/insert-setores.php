<?
session_start();
require_once("../../_funcoes/funcoes.php");

$conn = conecta_banco();

$nome = $_POST['nome'];


$sql = "SELECT MAX(set_setor) as codigo FROM setores";
$resultado = $conn->query($sql);
while ($linha = $resultado->fetchRow()) 
{		 			
	$cod  = $linha[0]+1;
}

$sql1 = "insert into setores (set_setor, set_nome) values ('$cod','$nome')";

if (!($conn -> Execute($sql1))) {
    $erro='Erro inserindo:'.$conn -> ErrorMsg().'<BR>'.$sql1;
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