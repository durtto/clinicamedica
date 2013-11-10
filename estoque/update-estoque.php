<?
session_start();
require_once("../_funcoes/funcoes.php");
$conn = conecta_banco();

$cod = $_POST['cod'];
$nome = $_POST['nome'];
$marca = $_POST['marca'];
$descricao = $_POST['descricao'];
$unidade = $_POST['un'];
$quantidade = $_POST['quantidade'];
$valor_venda = $_POST['vvenda'];
$valor_compra = $_POST['vcompra'];
$cod_barras = $_POST['codbarras'];
$cod_categoria = $_POST['categoria'];
$margem = $_POST['margem'];

if(true)
{		
	$valor_compra = valorparaobanco($valor_compra);
	$valor_venda = valorparaobanco($valor_venda);
	$margem = valorparaobanco($margem);
	
	$sql = "update produtos set pro_nome = '$nome', pro_descricao = '$descricao', pro_marca = '$marca', pro_valorcompra = '$valor_compra', pro_valorvenda = '$valor_venda', pro_quantidade = '$quantidade', pro_unidade= '$unidade', pro_codbarras = '$cod_barras', pro_categoriaproduto = '$cod_categoria', pro_margem = '$margem' where pro_produto = '$cod'";	
	
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