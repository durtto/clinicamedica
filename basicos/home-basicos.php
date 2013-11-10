<?
session_start();
require_once("../_funcoes/funcoes.php");

echo "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml'>";
include("../componentes/head.php");
echo "</head>";
?>
<body>
<?

include("../componentes/cabecalho.php");
?>
<div id="menu-secao">
	<li>
		<a href="../_funcoes/controller.php?opcao=home-basicos" class="basicos">Básicos</a>
		Básicos > Principal
	</li>
</div>

<div id="sub-menu">	
	<li>
		<a href="../_funcoes/controller.php?opcao=home-marcas">Marcas</a>		
		<a href="../_funcoes/controller.php?opcao=home-setores">Setores</a>		
	</li>
</div>

			

</body>
</html>	