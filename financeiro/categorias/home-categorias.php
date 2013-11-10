<?
session_start();
require_once("../../_funcoes/funcoes.php");
echo "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html id='servicos-listagem' class='servicos' xmlns='http://www.w3.org/1999/xhtml'>";
include("../../componentes/head.php");
echo "</head>";
?>

<body>
<?

include("../../componentes/cabecalho.php");
?>
<div id="menu-secao">
	<li>
		<a href="<?=$_CONF['realpath']?>/_funcoes/controller.php?opcao=home-financeiro" class="financeiro">Financeiro</a>
		Categorias > Listagem
	</li>
</div>

<div id="sub-menu">	
	<li>
		<a href="<?=$_CONF['realpath']?>/_funcoes/controller.php?opcao=cadastro-de-categorias">Cadastro de Categorias</a>		
	</li>
</div>

<form action='#' class='org_grid grid' method='post'>
	<table>
		<thead><tr><td class='col-1'>Descrição</td><td colspan='2' class='grid-action'>Ações</td></tr></thead>	
		
		<tbody>
		<?
		
		$sql = "SELECT cat_categoria, cat_descricao ". 
				"FROM categoriasdemovimentacao ".				
				"ORDER BY cat_descricao";		
				
		$conn = conecta_banco();
		$resultado = $conn->query($sql);
		$x = 0;
		if($resultado ->numRows() > 0)
		{
			while ($linha = $resultado->fetchRow()) 
			{		 			
				  $cod_categoria  = $linha[0];
				  $descricao  = $linha[1];
								
				  
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
			<tr class="<? echo $par; ?>"><td class='col-1'><? echo $descricao; ?> </td>	
			
			<td class="grid-action"><a href="<?=$_CONF['realpath']?>/_funcoes/controller.php?opcao=edicao-de-categorias/<? echo $cod_categoria; ?>" class="editar"></a> </td>
			<td class="grid-action"><a href="<?=$_CONF['realpath']?>/_funcoes/controller.php?opcao=exclusao-de-categorias/<? echo $cod_categoria; ?>" class="excluir"></a> </td>
			</tr>
			
			<?
			
			}
		}else{
		?>
			<tr><td class='col-1'>Nenhuma categoria cadastrada.</td>	
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