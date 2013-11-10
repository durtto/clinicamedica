<?

session_start();
require_once("../../_funcoes/funcoes.php");

$conn = conecta_banco();

$nome = $_POST['nome'];
$agencia = $_POST['agencia'];
$numeroconta = $_POST['conta'];

$sql = "SELECT MAX(con_conta) as codigo FROM contas";
$resultado = $conn->query($sql);
while ($linha = $resultado->fetchRow()) 
{		 			
	$cod_conta  = $linha[0]+1;
}
$sql = "insert into contas (con_conta, con_agencia, con_numeroconta, con_nome, con_saldoatual) values ('$cod_conta', '$agencia', '$numeroconta', '$nome', 0)";
	
if (!($conn -> Execute($sql))) {
	$erro = 'Erro inserindo:'.$conn -> ErrorMsg().'<BR>'.$sql.'<BR>';
}

if($erro == "")
{	
	echo "<script>
				 location.href='../../_funcoes/controller.php?opcao=home-contas';
		  </script>";	
	$conn->disconnect();
}
else{
	include('../../error/error.php?erro='.$erro);	
}
?>