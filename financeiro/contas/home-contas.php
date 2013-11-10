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
		<a href="<?=$_CONF['realpath']?>/_funcoes/controller.php?opcao=home-financeiro" class="financeiro">Financeiro</a>
		Contas > Listagem
	</li>
</div>
<div id="sub-menu">	
<li>
		<a href="<?=$_CONF['realpath']?>/_funcoes/controller.php?opcao=home-contas">Listagem de Contas</a>		
	</li>
	<li>
		<a href="<?=$_CONF['realpath']?>/_funcoes/controller.php?opcao=cadastro-de-contas">Cadastro de Contas</a>		
	</li>
</div>
<?
include ("./filtros/filtro-contas.php"); 
?>
<div>
<form action='#' class='org_grid grid' method='post'>
	<table>
		<thead>
			<tr>
				<td class='col-1'>Data</td>
				<td class='col-2'>Conta</td>
				<td class='col-3'>Cód. Movimentação</td>
				<td class='col-4'>Débito</td>
				<td class='col-5'>Crédito</td>
				<td class='col-6'>Saldo</td>								
				<td colspan='1' class='grid-action'>Ações</td></tr></thead>			
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
						" com_movimentacao, com_conta, com_valormovimentado, com_saldo, com_tipopagamento, com_fluxodecaixa, con_nome, com_datamovimentacao ".				
						" FROM contasmovimentacao ".
						" INNER JOIN contas ON com_conta = con_conta ".
						" INNER JOIN fluxodecaixa ON com_fluxodecaixa = flux_fluxodecaixa ".
						" INNER JOIN tiposdeconta ON com_tipopagamento = tip_tipoconta ";
		
		$cod_conta = $_SESSION['contas'];
		$data_inicio = $_SESSION['inicio'];
		$data_fim = $_SESSION['fim'];
		$exibir = $_SESSION['exibir'];
		$ordem = $_SESSION['ordem'];
		$cont = 0;
		
	
		if($cod_conta!= 'null' && $cod_conta!= '')
		{
			$sql .=		getSQL($cont)." con_conta = '$cod_conta'";
			$cont++;
		}else{
			$cod_conta = 1;
			$sql .=		getSQL($cont)." con_conta = '$cod_conta'";
			$cont++;
		}
		if($data_inicio != '' && $data_fim != '')
		{
			list($dia,$mes,$ano)= split("/",$data_inicio);
			$data_inicio = $ano."-".$mes."-".$dia;
			
			list($dia,$mes,$ano)= split("/",$data_fim);
			$data_fim = $ano."-".$mes."-".$dia;
			
			$sql .=		getSQL($cont)." (com_datamovimentacao  BETWEEN '".$data_inicio."' AND '".$data_fim."')";
			$cont++;
			
		}
		else if($data_inicio == '' && $data_fim != '')
		{
			list($dia,$mes,$ano)= split("/",$data_fim);
			$data_fim = $ano."-".$mes."-".$dia;
			
			$sql .=		getSQL($cont)." com_datamovimentacao  <= '".$data_fim."'";
			$cont++;
		}
		else if($data_inicio != '' && $data_fim == '')
		{
			list($dia,$mes,$ano)= split("/",$data_inicio);
			$data_inicio = $ano."-".$mes."-".$dia;
			
			$sql .=		getSQL($cont)." com_datamovimentacao  <= '".$data_inicio."'";
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
			
			$sql .=		getSQL($cont)." (com_datamovimentacao  BETWEEN '".$data_inicio."' AND '".$data_fim."')";
			$cont++;
		}		
					
		
		$sql .= " ORDER BY com_movimentacao ".$ordem;
		/// RECEBO A PÁGINA E O VALOR DE PAGINAÇÃO ///
		$pagina = $_GET["pagina"];
		$paginacao = $_GET["paginacao"];		
		
		/// CONSULTA SEM LIMIT E OFFSET PARA CALCULAR TOTAL DE REGISTROS ///
		//echo $sql;
		$resultado = execute_query($sql);
		$_SESSION['financeiro-report'] = $sql;
//		$num_total_registos = $resultado -> numRows();
		
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
		//echo $sql;	
		$resultado = execute_query($sql);
		$x = 0;
		if($resultado->numRows()>0)
		{
			while ($linha = $resultado->fetchRow()) 
			{		 			
				  $cod_movimentacaoconta  = $linha[0];
				  $cod_conta  = $linha[1];
				  $valor  = $linha[2];
				  $saldo  = $linha[3];
				  $tipopagamento  = $linha[4];  
				  $cod_fluxodecaixa = $linha[5];
				  $nome_conta = $linha[6];
				  $datamovimentacao = $linha[7];
				  $nome_cliente = $linha[8];
				
				  $valor = valorparaousuario_new($valor);
				  $saldo = valorparaousuario_new($saldo);
				  $datamovimentacao = dataparaousuario($datamovimentacao);		 
							 
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
				<td class='col-1'><? echo $datamovimentacao; ?> </td>
				<td class='col-2'><? echo $nome_conta; ?> </td>
				<td class='col-3'><? echo $cod_fluxodecaixa."-".$cod_movimentacaoconta; ?> </td>
				<? 
				if($tipopagamento == "1")
				{
				?>
				<td class='col-4'>----</td>
				<?
				}else{
				?>
				<td class='col-4'><?=$valor?></td>
				<?
				}
				?>
				
				<? 
				if($tipopagamento == "2")
				{
				?>
				<td class='col-5'>----</td>
				<?
				}else{
				?>
				<td class='col-5'><?=$valor?></td>
				<?
				}
				?>
				<td class='col-6'><? echo $saldo; ?> </td>										
				<td class="grid-action"><a href="../_funcoes/controller.php?opcao=edicao-de-conta/<? echo $cod_conta; ?>" class="editar" title="editar"></a> </td>					
			</tr>		
			<?		
			}
		}else{					
		?>
			<tr class="<? echo $par; ?>">
				<td class='col-1'>Nenhuma movimentação no período.</td>
			</tr>
		<?
		}
		
		$resultado->free();
		?>
		</tbody>
		<tfoot>		
		<tr>
		<td></td><td></td><td></td><td></td><td>Saldo atual:</td>
		<td>
		<?
		$sql = "select con_saldoatual from contas where con_conta = $cod_conta";
		$resultado2 = execute_query($sql);
		while($linha2 = $resultado2->fetchRow())
		{
			$saldoatual = $linha2[0];
		}
		echo "<b>".valorparaousuario_new($saldoatual)."</b>";		
		?>
		</td>
		 </tr>
		<tr>
		<td colspan="9">		
		  <input value="Versão para impressão" class="bt org-grid action:./impressao/imprimir.php" id="imprimir-financeiro" type="button">
		  </td>
		 </tr>
	 </tfoot>
	</table>
</form>
</div>

</body>
</html>	