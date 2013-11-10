<?
session_start();
require_once("../_funcoes/funcoes.php");
echo "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html id='pauta-listagem' class='pauta' xmlns='http://www.w3.org/1999/xhtml'>";
include("../componentes/head.php");
echo "<script src='../_javascript/cadastro-de-estoque/Principal.js' type='text/javascript'></script>\n";
echo "</head>";
?>
<script type='text/javascript'>
function confirma_exclusao(id) {
   var cod = id;
   if (confirm('Você tem certeza?')) {
      window.location='./delete_usuario.php?cod='+cod;
      }
   }
</script>
<body>
<?
include("../componentes/cabecalho.php");
$id_usuario = $_SESSION['id'];
///VERIFICAÇÃO E APLICAÇÃO DO CONTROLE DE PERMISSÕES///
$sql = "SELECT	up_permissao ". 
				"FROM	usuarios_permissoes ". 
				"WHERE up_usuario = '$id_usuario'";
				
$resultado = execute_query($sql);	
$i = 0;		
while ($linha = $resultado->fetchRow()) 
{		 						  
		  $permissoes[$i]  = $linha[0];	
		  $i++;		  
}
for($x=0;$x<sizeof($permissoes);$x++)
{					  		
	if($permissoes[$x] == 1)
	{														
		$link_cadastrar = "../_funcoes/controller.php?opcao=cadastro-de-estoque";
		$link_editar = "../_funcoes/controller.php?opcao=edicao-de-estoque/";		
		$link_excluir = "../_funcoes/controller.php?opcao=exclusao-de-estoque/";
						
		break;																
	}else{
		$link_editar = $link_excluir = $link_cadastrar = $link_alteracao = "#";								
	}
}
$sql = "SELECT	usu_ehadministrador ". 
				"FROM	usuarios ". 
				"WHERE usu_usuario = '$id_usuario'";
				
$resultado = execute_query($sql);	
while ($linha = $resultado->fetchRow()) 
{		 						  
	$administrador  = $linha[0];	
}
if($administrador == "on")
{
	$link_alteracao = "../_funcoes/controller.php?opcao=alterar-precos/";
}else{
	$link_alteracao = "#";
	///NÃO PERMITO ALTERAÇÃO NO ESTOQUE PARA QUE NÃO É ADM.///
	$link_editar = "#";	
}
if(sizeof($permissoes)<1)
{
	$link_editar = $link_excluir = $link_cadastrar = "#";	
}
?>
<div id="menu-secao">
	<li>
		<a href="../_funcoes/controller.php?opcao=home-estoque" class="produtos">Estoque</a>
		Estoque > Listagem
	</li>
</div>

<div id="sub-menu">	
	<li>
		<a href="<?=$link_cadastrar?>">Cadastro de Produtos</a>		
	</li>
	<li>
		<a href="<?=$link_alteracao?>">Alteração de Preços</a>		
	</li>
</div>
<?
include ("./filtros/filtro-estoque.php"); 
?>
<div>
<form action='#' class='org_grid grid' method='post'>
	<table>
		<thead>
			<tr>
				<td class='col-1'>Nome</td>
				<td class='col-2'>Descrição</td>				
				<td class='col-3'>Categoria</td>
				<td class='col-3'>Marca</td>
				<td class='col-3'>Fornecedor</td>
				<td class='col-3'>Qtde.</td>
				<td class='col-3'>Valor</td>				
				<td colspan='2' class='grid-action'>Ações</td></tr></thead>	
		
		<tbody>
		<?
			
		
		$sql = "SELECT	pro_produto, pro_nome, pro_descricao, pro_quantidade, pro_unidade, pro_valorvenda, mar_nome, catpro_descricao, pro_valorcompra, pes_nome, pro_codbarras ". 
				"FROM	produtos 
				INNER JOIN marcas ON mar_marca = pro_marca 
				LEFT JOIN pessoas ON pes_pessoa = pro_fornecedor 
				INNER JOIN categoriasdeprodutos ON catpro_categoriaproduto = pro_categoriaproduto ";
		
		$produto = $_POST['produto'];
		$marca = $_SESSION['marca'];		
		$fornecedor = $_SESSION['fornecedor'];		
		$categoriaproduto = $_SESSION['categoriaproduto'];
		$codbarras = $_SESSION['codbarras'];
		$resultados = $_SESSION['resultados_pagina'];
		$etiquetas = $_POST['etiquetas'];
		for($i=0; $i<6; $i++)
		{
			if($_SESSION['situacao_'.$i]  != "")
			{
				$situacoes[] = $_SESSION['situacao_'.$i];
			}
		}		
		$ordenacao = $_SESSION['ordenarPor'];
		$ordem = $_SESSION['ordem'];
		$cont = 0;
		
		if($marca!= 'null' && $marca!= '')
		{
			$sql .=		getSQL($cont)." pro_marca = '$marca'";
			$cont++;
		}
		if($fornecedor!= 'null' && $fornecedor!= '')
		{
			$sql .=		getSQL($cont)." pro_fornecedor = '$fornecedor'";
			$cont++;
		}
		if($categoriaproduto!= 'null' && $categoriaproduto!= '')
		{
			$sql .=		getSQL($cont)." pro_categoriaproduto = '$categoriaproduto'";
			$cont++;
		}
		if($produto!= 'null' && $produto!= '')
		{
			$sql .=		getSQL($cont)." pro_nome like '%$produto%'";
			$cont++;
		}	
		if($codbarras!= 'null' && $codbarras!= '')
		{
			$sql .=		getSQL($cont)." pro_codbarras = '$codbarras'";
			$cont++;
		}	
		switch ($ordenacao) {
		
			case 1:
			$sql .=" ORDER BY ";
				$sql .= " pro_produto ";
				$sql .= $ordem;
				break;
				
			case 2:
			$sql .=" ORDER BY ";
				$sql .= " pro_nome ";
				$sql .= $ordem;
				break;
				
			case 3:
			$sql .=" ORDER BY ";
				$sql .= " pro_marca ";
				$sql .= $ordem;
				break;			
			default:
			$sql .=" ORDER BY ";
				$sql .= " pro_nome ";
				$sql .= $ordem;
			
		}
	
		/// RECEBO A PÁGINA E O VALOR DE PAGINAÇÃO ///
		$pagina = $_GET["pagina"];
		$paginacao = $_GET["paginacao"];
		
		if($paginacao == 'on')
		{
			$sql = $_SESSION['consulta'];
		}
		
		/// CONSULTA SEM LIMIT E OFFSET PARA CALCULAR TOTAL DE REGISTROS ///
		$resultado = execute_query($sql);
		$num_total_registos = $resultado -> numRows();
		
		$_SESSION['estoque-report'] = $sql;
		
		if($resultados != '')	//RESULTADOS POR PÁGINA//
		{	
			$_SESSION['rsp'] = $resultados;
		}
		
		if($paginacao == 'on') // SE ESTÁ PAGINANDO, RECEBE A CONSULTA SEM LIMIT E OFFSET Q ESTÁ NA SEÇÃO, E A QTD. RESULTADOS POR PÁGINA //
		{
			$sql = $_SESSION['consulta'];	
			$resultados = $_SESSION['rsp'];	
			
		}
		// SE RESULTADOS POR PÁGINA ESTIVER VAZIO OU NÃO BUSCOU DA SESSÃO, ATRIBUI 20 POR PADRÃO E JOGA NA SESSÃO TB //
		if($resultados < 1) 
		{ 
			$resultados = 80; 
			$_SESSION['rsp'] = $resultados;
		}
		// PROCEDE A PAGINAÇÃO //
		if (!$pagina) 
		{ 
			$inicio = 0;
			$pagina=1;
		}
		else {
			$inicio = ($pagina - 1) * $resultados;	
		} 
		
		// JOGA A CONSULTA BÁSICA NA SEÇÃO //
		$_SESSION['consulta'] = $sql;
		//$sql .=" GROUP BY sete_pit ";
		// ADICION LIMIT E OFFSET NA CONSULTA BÁSICA //
		$sql .=		" LIMIT $resultados";
		$sql .=		" OFFSET $inicio";
		
		$total_paginas = ceil($num_total_registos / $resultados); 
		$_SESSION['produtos'] = $sql;		
		if($etiquetas == 'on')			
		{
		
		echo "<script>
				 window.open('./impressao/etiquetas.php');
		  </script>";
		  
		}
		$conn = conecta_banco();
		$resultado = $conn->query($sql);
		$x = 0;
   	    $subtotalcompra = 0;
		while ($linha = $resultado->fetchRow()) 
		{		 			
			  $cod_produto  = $linha[0];
			  $nome_produto  = $linha[1];
			  $descricao  = $linha[2];
			  $qtde  = $linha[3];
			  $unidade = $linha[4];
			  $valor  = $linha[5];	
			  $nome_marca = $linha[6];	
			  $nome_categoria = $linha[7];
			  $valorcompra = $linha[8];
			  $nomefornecedor = $linha[9];
			  	  	
				
			  $subtotalcompra += ($valorcompra * $qtde);
			  $valor = valorparaousuario_new($valor);			 
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
			 if(strlen($descricao)>80)
			 {
			 	$descricao = substr($descricao,0,80)."...";
			 }
			 
		 
		 $x = $x+1;	 
				
		?>
		<tr class="<? echo $par; ?>">
			<td class='col-2'><? echo $nome_produto; ?> </td>
			<td class='col-2'><? echo $descricao; ?> </td>
			<td class='col-3'><? echo $nome_categoria; ?> </td>
			<td class='col-3'><? echo $nome_marca; ?> </td>
			<td class='col-3'><? echo $nomefornecedor; ?> </td>
			
			<td class='col-8'>
			<? 
				$pos = strpos($qtde, "-");
				if($pos === false)
				{
					echo $qtde;				
				}else{
					 	?> <font color="#FF0000"><?=$qtde?></font>
				<?
				}
				
				
				$totalemestoque += $qtde;
			?> </td>
			<td class='col-3'><? echo $valor; ?> </td>
				
		<td class="grid-action"><a href="<?=$link_editar.$cod_produto?>" class="editar" title="editar"></a> </td>
		<td class="grid-action"><a href="<?=$link_excluir.$cod_produto?>" class="excluir" title="excluir"></a> </td>
		</tr>		
		<?		
		}
		$resultado->free();
		$conn->disconnect();
		if($administrador == "on")
		{
		?>
		<tr class="<? echo $par; ?>">
			<td class='col-1'></td>
			<td class='col-2'></td>
			<td class='col-3'></td>
			<td class='col-3'></td>			
			<td class='col-3'><b>Qtde. Total:</b></td>
			<td class='col-4'><b>Subtotal de Compra:</b></td>
		</tr>
		<tr class="<? echo $par; ?>">
			<td class='col-1'></td>
			<td class='col-2'></td>
			<td class='col-3'></td>
			<td class='col-3'></td>			

			<td class='col-4'><?=$totalemestoque?></td>
			<td class='col-4'><?=valorparaousuario_new($subtotalcompra)?></td>
		</tr>
		<?
		}
		?>
		</tbody>
		
		<tfoot>		
		<tr>
		<td colspan="9">		
		  <input value="Versão para impressão" class="bt org-grid action:./impressao/imprimir.php" id="imprimir-estoque" type="button">
		  </td>
		 </tr>
	 </tfoot>
	</table>
</form>
</div>
<form id="form-paginacao">
<h3>
Paginação
</h3>
<fieldset>
<fieldset>
  <fieldset class="inicioRegistros">
	<label for="inicioRegistros">
	  Ir para
	</label>	
<?
		if ($total_paginas>0){
			for ($i=1;$i<=$total_paginas;$i++){
			   if ($pagina == $i)
				  //se mostro o índice da página atual, não coloco link
				  echo "".$pagina . " ";
			   else
				  //se o índice não corresponde com a página mostrada atualmente, coloco o link para ir a essa página
				  echo " <a href='home-estoque.php?pagina=" . $i . "&paginacao=on'>" . $i . "</a> ";
			}
		} 
?>
	</fieldset>
	</fieldset>
</fieldset>	
</form>				

</body>
</html>	