<?
session_start();
require_once("../_funcoes/funcoes.php");
echo "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml'>";
include("../componentes/head.php");
echo "</head>";
include("../componentes/cabecalho.php");
echo "<body>";
echo "<div style='margin-left:20px'>";
print '<h3>Atenção!</h3>Não será possível realizar esta ação.<br>';
$erro = $_GET['erro'];
if($erro)
{
	echo "<b><br>$erro</b>";
	echo "<br><br><a href='javascript:history.go(-1);'>Voltar</a>";
}
echo "</div>";
?>
