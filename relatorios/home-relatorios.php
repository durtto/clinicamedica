<?
session_start();
require_once("../_funcoes/funcoes.php");
echo "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html id='pauta-listagem' class='pauta' xmlns='http://www.w3.org/1999/xhtml'>";
include("../componentes/head.php");

echo "</head>";
?>
<body>
<?
include("../componentes/cabecalho.php");
?>
<div id="menu-secao">
	<li>
		<a href="../_funcoes/controller.php?opcao=home-relatorios" class="relatorios">Relatórios</a>
		Relatórios
	</li>
</div>
<div id="sub-menu">	
	<li>
		<a href="../relatorios/impressao-financeiro.php">Financeiro</a>		
	</li>
    
    <li>
		<a href="../relatorios/receitas/home-receitas.php">Receitas</a>		
	</li>
    
	
</div>

</body>
</html>	