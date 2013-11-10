<?
require_once("../../_funcoes/funcoes.php");

$cod = $_GET['cod'];
$sql = "SELECT pro_produto, pro_nome, pro_valorvenda, pro_unidade, pro_valorcompra ". 
"FROM produtos ".			
"WHERE pro_produto = '$cod'";
//echo $sql;
$resultado = execute_query($sql);

$linha = $resultado->fetchRow();
$codigo  = $linha[0];					  
$nome = $linha[1];
$valor = $linha[2];
$unidade = $linha[3];
$custo = $linha[4];
$valor = valorparaousuario_new($valor);
$custo = valorparaousuario_new($custo);
$corpo ="<?xml version=\"1.0\" encoding=\"iso-8859-1\"?>";
$corpo .="<produto><cod>$codigo</cod><nome>$nome</nome><valor>$valor</valor><custo>$custo</custo><unidade>$unidade</unidade></produto>";

header("Content-type: text/xml");
echo $corpo;
?>
