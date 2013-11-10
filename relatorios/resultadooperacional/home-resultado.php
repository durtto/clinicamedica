<?
session_start();
require_once("../../_funcoes/funcoes.php");
echo "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html id='financeiro-listagem' class='pauta' xmlns='http://www.w3.org/1999/xhtml'>";
include("../../componentes/head.php");
echo "</head>";
?>
<body>
<?
include("../../componentes/cabecalho.php");
?>
<div id="menu-secao">
	<li>
		<a href="../../_funcoes/controller.php?opcao=home-relatorios" class="relatorios">Relat&oacute;rios</a>
		Relat&oacute;rios > Resultado Operacional
	</li>
</div>
<?
include ("./filtros/filtro.php"); 
?>

</body>
</html>	