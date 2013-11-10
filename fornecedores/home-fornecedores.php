<?
session_start();
require_once("../_funcoes/funcoes.php");
echo "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml'>";
include("../componentes/head.php");
echo "</head>";
?>
<script type='text/javascript'>

</script>
<body>
<?

include("../componentes/cabecalho.php");
?>
<div id="menu-secao">
	<li>
		<a href="../_funcoes/controller.php?opcao=home-fornecedores" class="fornecedores">Fornecedores</a>
		Fornecedores > Listagem
	</li>
</div>

<div id="sub-menu">	
	<li>
		<a href="../_funcoes/controller.php?opcao=cadastro-de-fornecedores">Cadastro de Fornecedores</a>		
	</li>
</div>
<form action='#' class='org_grid grid' method='post'>
	<table>
		<thead><tr><td class='col-1'>Nome</td><td class='col-2'>Contato</td><td class='col-3'>Telefone</td><td class='col-4'>Situação</td><td colspan='2' class='grid-action'>Ações</td></tr></thead>	
		
		<tbody>
		<?		
		$sql = "SELECT for_fornecedor, for_estahativo, pes_nome, for_contato, for_con_comercial ". 
				"FROM fornecedores ".				
				"INNER JOIN ".
				"pessoas ON for_fornecedor = pes_pessoa ".							
				"ORDER BY pes_nome";
		
		$conn = conecta_banco();
		$resultado = $conn->query($sql);
		$x = 0;
		while ($linha = $resultado->fetchRow()) 
		{		 			
			  $cod_fornecedor  = $linha[0];
			  $situacao  = $linha[1];
			  $nome_fornecedor = $linha[2];
			  $contato = $linha[3];			  
			  $telefone = $linha[4];
			 if($situacao == "S")
			 {
			 	$situacao = "ativo";
			 }else{ $situacao = "inativo";}
			 
			
			 
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
		<tr class="<? echo $par; ?>"><td class='col-1'><? echo $nome_fornecedor; ?> </td><td class='col-2'><? echo $contato; ?> </td><td class='col-3'><? echo $telefone; ?> </td><td class='col-4'><? echo $situacao; ?> </td>
		<!--<td class="grid-action"><a href="/grise/_funcoes/controller.php?opcao=view-de-usuarios&cod=<? //echo $cod_usuario; ?>" class="visualizar"></a> </td>-->
		
		<td class="grid-action"><a href="../_funcoes/controller.php?opcao=visualiza-fornecedores/<? echo $cod_fornecedor; ?>" class="visualizar" title="visualizar"></a> </td>
		<td class="grid-action"><a href="../_funcoes/controller.php?opcao=edicao-de-fornecedores/<? echo $cod_fornecedor; ?>" class="editar" title="editar"></a> </td>
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