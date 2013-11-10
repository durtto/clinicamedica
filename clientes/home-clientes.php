<?
session_start();
require_once("../_funcoes/funcoes.php");
echo "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml'>";
include("../componentes/head.php");
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
?>
<div id="menu-secao">
	<li>
		<a href="../_funcoes/controller.php?opcao=home-clientes" class="clientes">Clientes</a>
		Clientes > Listagem
	</li>
</div>
<?
include ("./filtros/filtro-clientes.php"); 
?>
<div id="sub-menu">	
	<li>		
		<a href="../_funcoes/controller.php?opcao=cadastro-de-clientes">Cadastro de Clientes</a>		
	</li>
</div>
<form action='#' class='org_grid grid' method='post'>
	<table>
		<thead><tr><td class='col-1'>Nome</td><td class='col-2'>Celular</td><td class='col-3'>Telefone</td><td class='col-4'>Situação</td><td colspan='1' class='grid-action'>Ações</td></tr></thead>	
		
		<tbody>
		<?		
		$sql = "SELECT cli_cliente, cli_estahativo, pes_nome, cli_contato, cli_con_celular, cli_con_comercial ". 
				"FROM clientes ".				
				"INNER JOIN ".
				"pessoas ON cli_cliente = pes_pessoa ";
		
		$nome = $_POST['nome'];
		$cliente = $_SESSION['cliente'];
		$resultados = $_SESSION['resultados_pagina'];
		$data_inicio = $_SESSION['inicio'];
		$data_fim = $_SESSION['fim'];
		$ordenacao = $_SESSION['ordenarPor'];
		$ordem = $_SESSION['ordem'];
		$cont = 0;
		
		if($cliente!= 'null' && $cliente!= '')
		{
			$sql .=		getSQL($cont)." cli_cliente = '$cliente'";
			$cont++;
		}
		if($nome!= 'null' && $nome!= '')
		{
			$sql .=		getSQL($cont)." pes_nome like '%$nome%'";
			$cont++;
		}
		
		switch ($ordenacao) {
		
			case 1:
				$sql .=" ORDER BY ";
				$sql .= " cli_cliente ";
				$sql .= " ASC ";
				break;
		
			case 2:
				$sql .=" ORDER BY ";
				$sql .= " pes_nome ";
				$sql .= " ASC ";
				break;
			default:
				$sql .=" ORDER BY ";
			$sql .= " pes_nome ";
			$sql .= " ASC ";
			break;
		}
		
		/// RECEBO A PÁGINA E O VALOR DE PAGINAÇÃO ///
		$pagina = $_GET["pagina"];
		$paginacao = $_GET["paginacao"];
		
		if($paginacao == 'on')
		{
			$sql = $_SESSION['consulta'];
		}
		//echo $sql;
		/// CONSULTA SEM LIMIT E OFFSET PARA CALCULAR TOTAL DE REGISTROS ///
		$resultado = execute_query($sql);
		$num_total_registos = $resultado -> numRows();
		
		$_SESSION['cliente-report'] = $sql;
		
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
			$resultados = 60;
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
		$conn = conecta_banco();
		$resultado = $conn->query($sql);
		$x = 0;
		while ($linha = $resultado->fetchRow()) 
		{		 			
			  $cod_cliente  = $linha[0];
			  $situacao  = $linha[1];
			  $nome_cliente = $linha[2];
			  $contato = $linha[3];			  
			  $celular = $linha[4];
			  $telefone = $linha[5];
			  
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
		<tr class="<? echo $par; ?>">
			<td class='col-1'><? echo $nome_cliente; ?> </td>
			<td class='col-3'><? echo $celular; ?> </td>
			<td class='col-3'><? echo $telefone; ?> </td>
			<td class='col-4'><? echo $situacao; ?> </td>
		<!--<td class="grid-action"><a href="/grise/_funcoes/controller.php?opcao=view-de-usuarios&cod=<? //echo $cod_usuario; ?>" class="visualizar"></a> </td>-->
		

		<td class="grid-action"><a href="../_funcoes/controller.php?opcao=edicao-de-clientes/<? echo $cod_cliente; ?>" class="editar" title="editar"></a> </td>
		</tr>
		
		<?
		
		}
		$resultado->free();
		$conn->disconnect();
		?>
		</tbody>
	</table>
</form>

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
				  echo " <a href='home-clientes.php?pagina=" . $i . "&paginacao=on'>" . $i . "</a> ";
			}
		} 
?>
	</fieldset>
	</fieldset>
</fieldset>	
</form>				

</body>
</html>	