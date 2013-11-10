<?
session_start();
require_once("../_funcoes/funcoes.php");
echo "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html id='servicos-listagem' class='servicos' xmlns='http://www.w3.org/1999/xhtml'>";
include("../componentes/head.php");
echo "</head>";
include("../componentes/cabecalho.php");
echo "<body>";
$cod_usuario = $_GET['cod'];


$sql2 = "delete from usuarios where usu_usuario = '$cod_usuario'";
$sql4 = "delete from pessoas where pes_pessoa = '$cod_usuario'";


$conn = conecta_banco();
$resultado = $conn->query($sql2);
$resultado = $conn->query($sql4);


echo "<script>
         location.href='/grise/_funcoes/controller.php?opcao=home-usuarios';
      </script>";
	  $resultado->free();
	$conn->disconnect();
?>