<?
session_start();
require_once("../_funcoes/funcoes.php");
echo "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html id='pauta-listagem' class='pauta' xmlns='http://www.w3.org/1999/xhtml'>";
include("../componentes/head.php");
echo "<script src='../_javascript/cadastro-de-estoque/Principal.js' type='text/javascript'></script>\n";
echo "</head>";
?>
<body>
<?
include("../componentes/cabecalho.php");

$id_usuario = $_SESSION['id'];
///VERIFICAÇÃO DAS PERMISSÕES///
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
//PERMISSOES
for($x=0;$x<sizeof($permissoes);$x++)
{					  		
	if($permissoes[$x] == 2)
	{														
		$link_editar = "../_funcoes/controller.php?opcao=edicao-de-pedido/";		
		$link_excluir = "../_funcoes/controller.php?opcao=exclusao-de-pedido/";
						
		break;																
	}else{
		$link_editar = $link_excluir = $link_cadastrar = "#";								
	}
}
?>
<div id="menu-secao">
	<li>
		<a href="../_funcoes/controller.php?opcao=home-pedidos" class="pedidos">Vendas</a>
		Vendas > Listagem
	</li>
</div>
<div id="sub-menu">	
	
	<li>
		<a href="../_funcoes/controller.php?opcao=cadastrar-pedidos">Cadastrar venda</a>		
	</li>
</div>
<?
include ("./filtros/filtro-pedido.php"); 
?>
<div>
<form action='#' class='org_grid grid' method='post'>
	<table>
		<thead>
			<tr>
				<td class='col-1'>Cód.</td>
				<td class='col-2'>Cliente</td>
				<td class='col-2'>Descrição</td>
				<td class='col-3'>Forma pagto.</td>
				<td class='col-4'>Data</td>
				<td class='col-5'>Total</td>				
				<td class='col-6'>Responsável</td>				
				<td colspan='3' class='grid-action'>Ações</td></tr></thead>			
		<tbody>
		<?
			
		
		$sql =			"SELECT ".
						" ped_pedido, pes_nome, ped_formapagto, ped_data, ped_valortotal, ped_responsavel, ped_descricao, ped_os ".				
						" FROM pedidos INNER JOIN pessoas ON pes_pessoa = ped_cliente ";
		
		$cod_cliente = $_SESSION['cliente'];
		$cod_autor = $_SESSION['responsavel'];
		//$cod_setor = $_SESSION['setor'];
		$resultados = $_SESSION['resultados_pagina'];
		for($i=0; $i<6; $i++)
		{
			if($_SESSION['situacao_'.$i]  != "")
			{
				$situacoes[] = $_SESSION['situacao_'.$i];
			}
		}
		$data_inicio = $_SESSION['inicio'];
		$data_fim = $_SESSION['fim'];
		$ordenacao = $_SESSION['ordenarPor'];
		$ordem = $_SESSION['ordem'];
		$cont = 0;
		
		if($cod_cliente!= 'null' && $cod_cliente!= '')
		{
			$sql .=		getSQL($cont)." ped_cliente = '$cod_cliente'";
			$cont++;
		}
		if($cod_autor!= 'null' && $cod_autor!= '')
		{
			$sql .=		getSQL($cont)." ped_responsavel = '$cod_autor'";
			$cont++;
		}
		if($data_inicio != '' && $data_fim != '')
		{
			list($dia,$mes,$ano)= split("/",$data_inicio);
			$data_inicio = $ano."-".$mes."-".$dia;
			
			list($dia,$mes,$ano)= split("/",$data_fim);
			$data_fim = $ano."-".$mes."-".$dia;
			
			$sql .=		getSQL($cont)." (ped_data  BETWEEN '".$data_inicio."' AND '".$data_fim."')";
			$cont++;
			
		}
		else if($data_inicio == '' && $data_fim != '')
		{
			list($dia,$mes,$ano)= split("/",$data_fim);
			$data_fim = $ano."-".$mes."-".$dia;
			
			$sql .=		getSQL($cont)." ped_data  <= '".$data_fim."'";
			$cont++;
		}
		else if($data_inicio != '' && $data_fim == '')
		{
			list($dia,$mes,$ano)= split("/",$data_inicio);
			$data_inicio = $ano."-".$mes."-".$dia;
			
			$sql .=		getSQL($cont)." ped_data  <= '".$data_inicio."'";
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
			
			$sql .=		getSQL($cont)." (ped_data  BETWEEN '".$data_inicio."' AND '".$data_fim."')";
			$cont++;
		}		
					
		switch ($ordenacao) {
		
			case 1:
			$sql .=" ORDER BY ";
				$sql .= " ped_pedido ";
				$sql .= $ordem;
				break;
				
			case 2:
			$sql .=" ORDER BY ";
				$sql .= " pes_nome ";
				$sql .= $ordem;
				break;
				
			case 3:
			$sql .=" ORDER BY ";
				$sql .= " ped_data ";
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
		$_SESSION['pedidos-report'] = $sql;
		$num_total_registos = $resultado -> numRows();
		
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
		if($resultado->numRows()>0)
		{
			while ($linha = $resultado->fetchRow()) 
			{		 			
				  $cod_pedido  = $linha[0];
				  $nome_cliente  = $linha[1];
				  $formapagto  = $linha[2];
				  $data  = $linha[3];
				  $valor_total  = $linha[4];  
				  $cod_responsavel = $linha[5];
				  $descricao = $linha[6];
				  $cod_os = $linha[7];
				  				
				  $valor_total = valorparaousuario_new($valor_total);
				  $data = dataparaousuario($data);
							 
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
				$sql = "SELECT form_formapagto, form_descricao ". 
					"FROM formaspagamento where form_formapagto = $formapagto";				
				$resultado1 = execute_query($sql);
				while($linha2 = $resultado1->fetchRow())
				{
					$for_forma = $linha2[0];
					$for_descricao = $linha2[1];	
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
			 $x = $x+1;	 
			?>
			<tr class="<? echo $par; ?>">
				<td class='col-1' width="10px"><? echo $cod_pedido; ?> </td>
				<td class='col-2'><? echo $nome_cliente; ?> </td>				
				<td class='col-2'><? echo $descricao; ?> </td>				
				<td class='col-3'><? echo $for_descricao; ?> </td>
				<td class='col-4'><? echo $data; ?> </td>			
				<td class='col-5'><? echo $valor_total; ?></td>
				<td class='col-6'><? echo $nome_usuario; ?></td>	
			<?
				if($cod_os != "")
				{
				///NÃO EXIBE OPÇÕES DE EDIÇÃO E EXCLUSÃO DO PEDIDO///
			?>	
			<td class="grid-action"></td>
			<td class="grid-action"></td>
			<td class="grid-action"><a href="<?=$link_excluir.$cod_pedido?>" class="excluir" title="excluir"></a> </td>
			<?
				}else{
			?>
								
			<td class="grid-action"><a href="./docs/gerar-pedido.php?cod=<? echo $cod_pedido; ?>" target="_blank" class="imprimir" title="gerar pedido"></a> </td>
			<td class="grid-action"><a href="<?=$link_editar.$cod_pedido?>" class="editar" title="editar"></a> </td>			
			<td class="grid-action"><a href="<?=$link_excluir.$cod_pedido?>" class="excluir" title="excluir"></a> </td>
			</tr>		
			<?
				}		
			}
		}else{					
		?>
			<tr class="<? echo $par; ?>">
				<td class='col-1'>Nenhum pedido cadastrado.</td>
			</tr>
		<?
		}
		
		$resultado->free();
		?>
		</tbody>
		<tfoot>		
		<tr>
		<td colspan="9">		
		  <input value="Versão para impressão" class="bt org-grid action:./impressao/imprimir.php" id="imprimir-financeiro" type="button">
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
				  echo " <a href='home-pedidos.php?pagina=" . $i . "&paginacao=on'>" . $i . "</a> ";
			}
		} 
?>
	</fieldset>
	</fieldset>
</fieldset>		
</form>
</body>
</html>	