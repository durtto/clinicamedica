<?
session_start();
require_once("../_funcoes/funcoes.php");
$conn = conecta_banco();

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
$fornecedor = $_POST['fornecedor'];
$situacaotributaria = $_POST['situacaotributaria'];
$ipi = $_POST['ipi'];
if(true)
{	
	$sql = "SELECT MAX(pro_produto) as codigo FROM produtos";
	$resultado = $conn->query($sql);
	while ($linha = $resultado->fetchRow()) 
	{		 			
		$produto  = $linha[0]+1;
	}
	$valor_compra = valorparaobanco($valor_compra);
	$valor_venda = valorparaobanco($valor_venda);
	$margem = valorparaobanco($margem);
	$ipi = valorparaobanco($ipi);
	
	$sql = "insert into produtos (pro_produto, pro_nome, pro_descricao, pro_marca, pro_valorcompra, pro_valorvenda, pro_quantidade, pro_unidade, pro_codbarras, pro_categoriaproduto, pro_margem) values('$produto','$nome','$descricao','$marca','$valor_compra', '$valor_venda', '$quantidade', '$unidade', '$cod_barras', '$cod_categoria', '$margem')";	
	
	if (!($conn -> Execute($sql))) {
		$erro .= 'Erro inserindo:'.$conn -> ErrorMsg().'<BR>'.$sql.'<BR>';
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