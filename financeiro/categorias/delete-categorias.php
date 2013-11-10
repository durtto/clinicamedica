<?
session_start();
require_once("../../_funcoes/funcoes.php");
echo "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html id='servicos-listagem' class='servicos' xmlns='http://www.w3.org/1999/xhtml'>";
include("../../componentes/head.php");
echo "</head>";
include("../../componentes/cabecalho.php");
echo "<body>";

$conn = conecta_banco();
$codcategoria = $_GET['cod'];

$sql = "delete from categoriasdemovimentacao where cat_categoria = '$codcategoria'";

if (!($conn -> Execute($sql))) {
    print 'Erro'.$conn -> ErrorMsg().'<BR>'.$sql;
}else{

echo "<script>
         location.href='../../_funcoes/controller.php?opcao=home-categorias';
      </script>";	  
		$conn->disconnect();
	  
	  }
?>