<?
session_start();
require_once("../_funcoes/funcoes.php");
$conn = conecta_banco();

$nome = "Cortina";
$marca = 2;
$descricao = "teste";
$unidade = "m²";
$quantidade = "140";
$valor_venda = "26,00";
$valor_compra = "13,00";
$valor_compra = valorparaobanco($valor_compra);
$valor_venda = valorparaobanco($valor_venda);

for($i=0; $i<30; $i++)
{	
	$sql = "SELECT MAX(pro_produto) as codigo FROM produtos";
	$resultado = $conn->query($sql);
	while ($linha = $resultado->fetchRow()) 
	{		 			
		$produto  = $linha[0]+1;
	}	
	
	$sql = "insert into produtos (pro_produto, pro_nome, pro_descricao, pro_marca, pro_valorcompra, pro_valorvenda, pro_quantidade, pro_unidade) values('$produto','$nome $produto','$descricao','$marca','$valor_compra', '$valor_venda', '$quantidade', '$unidade')";	
	
	if (!($conn -> Execute($sql))) {
		$erro .= 'Erro inserindo:'.$conn -> ErrorMsg().'<BR>'.$sql.'<BR>';
	}	
}


?>