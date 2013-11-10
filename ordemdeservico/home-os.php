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

$id_usuario = $_SESSION['id'];

?>
<div id="menu-secao">
	<li>
		<a href="../_funcoes/controller.php?opcao=home-os" class="pedidos">Orçamentos & Pedidos</a>
		OS > Listagem
	</li>
</div>
<div id="sub-menu">		
<li>
		<a href="../_funcoes/controller.php?opcao=home-os">Listagem de OS</a>		
	</li>
	<li>
		<a href="../_funcoes/controller.php?opcao=cadastrar-os">Cadastrar OS</a>		
	</li>
</div>
<?
include ("./filtros/filtro-ordens.php"); 
?>
<div>
<form action='#' class='org_grid grid' method='post'>
	<table>
		<thead>
			<tr>
				<td class='col-1'>Cód.</td>
				<td class='col-2'>Cliente</td>
				<td class='col-2'>Defeito</td>					
				<td class='col-3'>Data entrada</td>				
				<td class='col-3'>Data saída</td>								
				<td class='col-4'>Situação</td>				
				<td class='col-5'>Valor</td>				
				<td class='col-6'>Técnico</td>
				<td colspan='3' class='grid-action'>Ações</td></tr></thead>			
		<tbody>
		<?
		
		function getSQL($cont)
		{
			if($cont == 0)
			{
				return " WHERE ";
			}else{
				return " AND ";
			}
		}
		
		
		$sql =			"SELECT ".
						" ord_ordemdeservico, pes_nome, ord_responsavel, ord_situacao, ord_defeito, ord_dataentrada, ord_datasaida, ord_valor ".				
						" FROM ordensdeservico INNER JOIN pessoas ON pes_pessoa = ord_cliente INNER JOIN situacoes ON sit_situacao = ord_situacao ";
		
		$cod_cliente = $_SESSION['cliente'];
		$cod_autor = $_SESSION['responsavel'];
		$cod_situacao = $_SESSION['situacao'];
		$resultados = $_SESSION['resultados_pagina'];
		
		$data_inicio = $_SESSION['inicio'];
		$data_fim = $_SESSION['fim'];
		$ordenacao = $_SESSION['ordenarPor'];
		$ordem = $_SESSION['ordem'];
		$cont = 0;
		
		if($cod_cliente!= 'null' && $cod_cliente!= '')
		{
			$sql .=		getSQL($cont)." ord_cliente = '$cod_cliente'";
			$cont++;
		}
		if($cod_situacao!= 'null' && $cod_situacao!= '')
		{
			$sql .=		getSQL($cont)." ord_situacao = '$cod_situacao'";
			$cont++;
		}
		if($cod_autor!= 'null' && $cod_autor!= '')
		{
			$sql .=		getSQL($cont)." ord_responsavel = '$cod_autor'";
			$cont++;
		}
		if($data_inicio != '' && $data_fim != '')
		{
			list($dia,$mes,$ano)= split("/",$data_inicio);
			$data_inicio = $ano."-".$mes."-".$dia;
			
			list($dia,$mes,$ano)= split("/",$data_fim);
			$data_fim = $ano."-".$mes."-".$dia;
			
			$sql .=		getSQL($cont)." (ord_dataentrada  BETWEEN '".$data_inicio."' AND '".$data_fim."')";
			$cont++;
			
		}
		else if($data_inicio == '' && $data_fim != '')
		{
			list($dia,$mes,$ano)= split("/",$data_fim);
			$data_fim = $ano."-".$mes."-".$dia;
			
			$sql .=		getSQL($cont)." ord_dataentrada  <= '".$data_fim."'";
			$cont++;
		}
		else if($data_inicio != '' && $data_fim == '')
		{
			list($dia,$mes,$ano)= split("/",$data_inicio);
			$data_inicio = $ano."-".$mes."-".$dia;
			
			$sql .=		getSQL($cont)." ord_dataentrada  <= '".$data_inicio."'";
			$cont++;
		}
		else if($data_inicio == '' && $data_fim == '') ///CASO NAO VENHA NADA DO FILTRO/// 
		{
			$data_inicio = date("d/m/Y");
			list($dia,$mes,$ano)= split("/",$data_inicio);
			if($mes > 1)
			{ $mes = $mes - 1;}
			else { $mes = 12; }
			$data_inicio = $ano."-".$mes."-".$dia;
			
			$data_fim = date("d/m/Y");
			list($dia,$mes,$ano)= split("/",$data_fim);
			$data_fim = $ano."-".$mes."-".$dia;
			
			$sql .=		getSQL($cont)." (ord_dataentrada  BETWEEN '".$data_inicio."' AND '".$data_fim."')";
			$cont++;
		}		
					
		switch ($ordenacao) {
		
			case 1:
			$sql .=" ORDER BY ";
				$sql .= " ord_ordemdeservico ";
				$sql .= $ordem;
				break;
				
			case 2:
			$sql .=" ORDER BY ";
				$sql .= " pes_nome ";
				$sql .= $ordem;
				break;
				
			case 3:
			$sql .=" ORDER BY ";
				$sql .= " ord_dataentrada ";
				$sql .= $ordem;
				break;			
			
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
		$_SESSION['os-report'] = $sql;
		if($resultado)
		{
		$num_total_registos = $resultado -> numRows();
		}
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
			$resultados = 20; 
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
		
		$resultado = execute_query($sql);
		$x = 0;
		if($resultado)
		{
			while ($linha = $resultado->fetchRow()) 
			{		 			
				  $codos  = $linha[0];
				  $nome_cliente  = $linha[1];
				  $cod_responsavel  = $linha[2];
				  $cod_situacao  = $linha[3];
				  $defeito  = $linha[4];  
				  $dataentrada = $linha[5];
				  $datasaida = $linha[6];
  				  $valor = $linha[7];
				  				
				  $valor = valorparaousuario_new($valor);
				  $dataentrada = dataparaousuario($dataentrada);
							 
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
				$sql = "SELECT sit_situacao, sit_nome ". 
					"FROM situacoes where sit_situacao = $cod_situacao";				
				$resultado1 = execute_query($sql);
				while($linha2 = $resultado1->fetchRow())
				{
					$sit_situacao = $linha2[0];
					$sitdescricao = $linha2[1];	
				}
				$sql = "SELECT	usu_usuario, pes_nome, usu_login ". 
				"FROM	usuarios ". 
				"INNER JOIN pessoas ".
				"ON usu_usuario = pes_pessoa WHERE usu_usuario = $cod_responsavel";	
				$resultado2 = execute_query($sql);				
				while ($linha = $resultado2->fetchRow()) 
				{		 			
					  $cod_usuario  = $linha[0];
					  $nome_usuario  = $linha[1];					 			  	
					  $login  = $linha[3];						  
				} 
				if($datasaida != "")
				{
					$datasaida = dataparaousuario($datasaida);
				}else{
					$datasaida = "--/--/----";
				}		
				
			 $x = $x+1;	 
			?>
			<tr class="<? echo $par; ?>">
				<td class='col-1' width="10px"><? echo $codos; ?> </td>
				<td class='col-2'><? echo $nome_cliente; ?> </td>				
				<td class='col-2'><? echo $defeito; ?> </td>													
				<td class='col-3'><? echo $dataentrada; ?> </td>			
				<td class='col-3'><? echo $datasaida; ?> </td>	
				<td class='col-4'><? echo $sitdescricao; ?> </td>		
				<td class='col-5'><? echo $valor; ?></td>
				<td class='col-6'><? echo $nome_usuario; ?></td>
				<td class="grid-action"><a href="./docs/imprimir-os.php?cod=<? echo $codos; ?>" target="_blank" class="imprimir" title="imprimir OS"></a> </td>
			<td class="grid-action"><a href="../_funcoes/controller.php?opcao=edicao-de-os/<?=$codos?>" class="editar" title="editar"></a> </td>			
			<td class="grid-action"><a href="../_funcoes/controller.php?opcao=exclusao-de-os/<?=$codos?>" class="excluir" title="excluir"></a> </td>
			</tr>		
			<?		
			}
		}else{					
		?>
			<tr class="<? echo $par; ?>">
				<td class='col-1'>Nenhuma OS cadastrada.</td>
			</tr>
		<?
		}
		
		@$resultado->free();
		?>
		</tbody>
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
				  echo " <a href='home-os.php?pagina=" . $i . "&paginacao=on'>" . $i . "</a> ";
			}
		} 
?>
	</fieldset>
	</fieldset>
</fieldset>		
</form>
</body>
</html>	