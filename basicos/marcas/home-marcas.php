<?
session_start();
require_once("../../_funcoes/funcoes.php");

echo "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml'>";
include("../../componentes/head.php");
echo "</head>";
?>
<body>
<?

include("../../componentes/cabecalho.php");
?>
<div id="menu-secao">
	<li>
		<a href="../../_funcoes/controller.php?opcao=home-basicos" class="basicos">Cadastros Básicos</a>
		Marcas > Listagem
	</li>
</div>

<div id="sub-menu">	
	<li>
		<a href="../../_funcoes/controller.php?opcao=cadastro-de-marcas">Cadastro de Marcas</a>		
	</li>
</div>
<form action='#' class='org_grid grid' method='post'>
	<table>
		<thead><tr><td class='col-2'>Nome</td><td colspan='2' class='grid-action'>Ações</td></tr></thead>	
		
		<tbody>
		<?
		$sql = "SELECT	mar_marca, mar_nome ". 
				"FROM	marcas ORDER BY mar_nome";				
		$conn = conecta_banco();
		$resultado = $conn->query($sql);
		$x = 0;
		while ($linha = $resultado->fetchRow()) 
		{		 			
			  $cod_marca  = $linha[0];
			  $nome_marca  = $linha[1];
			 
		 	  $y = 2;	 
		 	  $resto = fmod($x, $y);	
			 if($resto == 0)
			 {
				$par = "par";
			 }
			 else
			 { 
				$par = "";
			 }		 
		 $x = $x+1;	 
		?>
		<tr class="<? echo $par; ?>"><td class='col-2'><? echo $nome_marca; ?> </td>	
		<td class="grid-action"><a href="../../_funcoes/controller.php?opcao=edicao-de-marcas/<? echo $cod_marca; ?>" class="editar"></a> </td>
		<td class="grid-action"><a href="../../_funcoes/controller.php?opcao=exclusao-de-marcas/<? echo $cod_marca; ?>" class="excluir"></a> </td>
		</tr>		
		<?		
		}
		$resultado->free();
		$conn->disconnect();
		?>
		</tbody>
	</table>
</form>
			

</body>
</html>	