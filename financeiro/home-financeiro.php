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
		<a href="<?=$_CONF['realpath']?>/_funcoes/controller.php?opcao=home-financeiro" class="financeiro">Financeiro</a>
		Fluxo de Caixa > Listagem
	</li>
</div>
<div id="sub-menu">	
	<li>
		<a href="<?=$_CONF['realpath']?>/_funcoes/controller.php?opcao=cadastro-de-movimentacao">Cadastrar Movimentação</a>		
	</li>
	<li>
		<a href="<?=$_CONF['realpath']?>/_funcoes/controller.php?opcao=home-categorias">Categorias</a>		
	</li>
	<li>
		<a href="<?=$_CONF['realpath']?>/_funcoes/controller.php?opcao=home-contas">Contas</a>		
	</li>
	
</div>
<?
include ("./filtros/filtro-financeiro.php"); 
?>
<div>
<form action='#' class='org_grid grid' method='post'>
	<table>
		<thead>
			<tr>
				<td class='col-1'>Cód.</td>
				<td class='col-2'>Sacado</td>
				<td class='col-3'>Categoria</td>
				<td class='col-4'>Descrição</td>						
				<td class='col-5'>Forma pagto.</td>
				<td class='col-5'>Parcela</td>
				<td class='col-5'>Débito</td>
				<td class='col-5'>Crédito</td>
				<td class='col-5'>Saldo</td>
				<td class='col-8'>Vencimento</td>				
				<td class='col-9'>Pagamento</td>				
				<td colspan='2' class='grid-action'>Ações</td></tr></thead>			
		<tbody>
		<?
		
		
		$conn = conecta_banco();
		$cont = 0;
		$sql =			"SELECT ".
						" flux_fluxodecaixa, flux_codigo, flux_parcela, pes_nome, flux_datavencimento, flux_datapagamento, flux_tipopagamento, flux_formapagamento, flux_valor, flux_qtdparcelas, flux_categoriamovimentacao, flux_descricao ".				
						" FROM fluxodecaixa ".
						//" INNER JOIN orcamentos ON flux_codorcamentoaprovado = orc_orcamento ".
						" INNER JOIN pessoas ON pes_pessoa = flux_codpessoa ";
						
		/*________BUSCA O SALDO ATUAL PARA FAZER AS PROJEÇÕES__________*/			
		/*
		$sql1 = "SELECT SUM(con_saldoatual) FROM contas ";
		$resultado = Execute($conn, $sql1);
		while ($linha = $resultado->fetchRow()) 
		{		 			
			$saldoatual  = $linha[0];
		}
		/*____________________________________________________________*/		
									
		$sql_total_pos = "SELECT SUM(flux_valor) FROM fluxodecaixa WHERE flux_tipopagamento = 1";			
		
		$sql_total_neg = "SELECT SUM(flux_valor) FROM fluxodecaixa WHERE flux_tipopagamento = 2";		
			
		
		$cod_sacado = $_SESSION['sacado'];		
		$resultados = $_SESSION['resultados_pagina'];		
		$data_inicio = $_SESSION['inicio'];
		$data_fim = $_SESSION['fim'];
		$exibir = $_SESSION['exibir'];
		$ordem = $_SESSION['ordem'];
		$ordenacao = $_SESSION['ordenarPor'];
		$categoria = $_SESSION['categoria'];
		
		
		if($cod_sacado!= 'null' && $cod_sacado!= '')
		{
			$sql .=		getSQL($cont)." flux_codpessoa = '$cod_sacado'";
			$cont++;
			$sql_total_pos .=		getSQL($cont)." flux_codpessoa = '$cod_sacado'";
			$cont++;
			$sql_total_neg .=		getSQL($cont)." flux_codpessoa = '$cod_sacado'";
			$cont++;
			
		}
		if($categoria!= 'null' && $categoria!= '')
		{
			$sql .=		getSQL($cont)." flux_categoriamovimentacao = '$categoria'";
			$cont++;
			$sql_total_pos .=		getSQL($cont)." flux_categoriamovimentacao = '$categoria'";
			$cont++;
			$sql_total_neg .=		getSQL($cont)." flux_categoriamovimentacao = '$categoria'";
			$cont++;
		}
		
		if($data_inicio != '' && $data_fim != '')
		{
			list($dia,$mes,$ano)= split("/",$data_inicio);
			$data_inicio = $ano."-".$mes."-".$dia;
			
			list($dia,$mes,$ano)= split("/",$data_fim);
			$data_fim = $ano."-".$mes."-".$dia;
			
			$sql .=		getSQL($cont)." (flux_datavencimento  BETWEEN '".$data_inicio."' AND '".$data_fim."')";
			$cont++;
			$sql_total_pos .= getSQL($cont)." (flux_datavencimento  BETWEEN '".$data_inicio."' AND '".$data_fim."')";
			$cont++;
			$sql_total_neg .= getSQL($cont)." (flux_datavencimento  BETWEEN '".$data_inicio."' AND '".$data_fim."')";
			$cont++;
			
		}
		else if($data_inicio == '' && $data_fim != '')
		{
			list($dia,$mes,$ano)= split("/",$data_fim);
			$data_fim = $ano."-".$mes."-".$dia;
			
			$sql .=		getSQL($cont)." flux_datavencimento  <= '".$data_fim."'";
			$cont++;
			$sql_total_pos .= getSQL($cont)." flux_datavencimento  <= '".$data_fim."'";
			$cont++;
			$sql_total_neg .= getSQL($cont)." flux_datavencimento  <= '".$data_fim."'";
			$cont++;
		}
		else if($data_inicio != '' && $data_fim == '')
		{
			list($dia,$mes,$ano)= split("/",$data_inicio);
			$data_inicio = $ano."-".$mes."-".$dia;
			
			$sql .=		getSQL($cont)." flux_datavencimento  <= '".$data_inicio."'";
			$cont++;
			$sql_total_pos .= getSQL($cont)." flux_datavencimento  <= '".$data_inicio."'";
			$cont++;
			$sql_total_neg .= getSQL($cont)." flux_datavencimento  <= '".$data_inicio."'";
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
			
			$sql .=		getSQL($cont)." (flux_datavencimento  BETWEEN '".$data_inicio."' AND '".$data_fim."')";
			$cont++;
			$sql_total_pos .= getSQL($cont)." (flux_datavencimento  BETWEEN '".$data_inicio."' AND '".$data_fim."')";
			$cont++;
			$sql_total_neg .= getSQL($cont)." (flux_datavencimento  BETWEEN '".$data_inicio."' AND '".$data_fim."')";
			$cont++;
		}		
					
		switch ($exibir) {				
			case 2:			
				$sql .= getSQL($cont)."flux_estahpago = 'S'";
				$cont++;
				$sql_total_pos .= getSQL($cont)."flux_estahpago = 'S'";
				$cont++;
				$sql_total_neg .= getSQL($cont)."flux_estahpago = 'S'";
				$cont++;
				break;
				
			case 3:			
				$sql .= getSQL($cont)."flux_estahpago = 'N'";
				$cont++;
				$sql_total_pos .= getSQL($cont)."flux_estahpago = 'N'";
				$cont++;
				$sql_total_neg .= getSQL($cont)."flux_estahpago = 'N'";
				$cont++;
				break;			
			
		}
		switch ($ordenacao) {		
			case 1:
			$sql .=" ORDER BY ";
				$sql .= " flux_fluxodecaixa ";
				
				break;
				
			case 2:
			$sql .=" ORDER BY ";
				$sql .= " flux_codpessoa ";
				
				break;
				
			case 3:
			$sql .=" ORDER BY ";
				$sql .= " flux_datavencimento ";
				
				break;						
		}
		$sql .= $ordem;
				
		/// RECEBO A PÁGINA E O VALOR DE PAGINAÇÃO ///
		$pagina = $_GET["pagina"];
		$paginacao = $_GET["paginacao"];
		
		if($paginacao == 'on')
		{
			$sql = $_SESSION['consulta'];
		}
		/// CONSULTA SEM LIMIT E OFFSET PARA CALCULAR TOTAL DE REGISTROS ///
		//echo $sql;
		$resultado = Execute($conn, $sql);
		$_SESSION['financeiro-report'] = $sql;		
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
		//echo $sql;
		/////AQUI CALCULO O SALDO ATUAL ATÉ A DATA INICIAL DA CONSULTA, PARA ADICIONAR AO SALDO ATUAL////
		$sql_positivo = "select sum(flux_valor) from fluxodecaixa where flux_tipopagamento = 1 and flux_datapagamento < '$data_inicio'";	
		$result = Execute($conn, $sql_positivo);
		while($line = $result->fetchRow())
		{				
			$soma_positivo = $line[0];	
		}
		$sql_negativo = "select sum(flux_valor) from fluxodecaixa where flux_tipopagamento = 2 and flux_datapagamento < '$data_inicio'";	
		$result = Execute($conn, $sql_negativo);
		while($line = $result->fetchRow())
		{				
			$soma_negativo = $line[0];	
		}
		$saldo_in = $soma_positivo - $soma_negativo;
		$saldoatual = $saldoatual + $saldo_in;
		?>
		<tr>
		<td></td><td></td><td></td><td>Saldo inicial</td><td></td>
		<td></td><td></td><td></td>
		<td><?=valorparaousuario_new($saldoatual)?></td>
		<td></td>
		  <td></td>
		 </tr>
		<?
		$total_paginas = ceil($num_total_registos / $resultados); 		

		$resultado = Execute($conn, $sql);
		$x = 0;
		if($resultado->numRows()>0)
		{
			while ($linha = $resultado->fetchRow()) 
			{		 			
				  $cod_fluxodecaixa  = $linha[0];
				  $cod_conta  = $linha[1];
				  $parcela  = $linha[2];
				  $nomesacado  = $linha[3];
				  $datavencimento  = $linha[4];  
				  $datapagamento = $linha[5];
				  $tipopagamento = $linha[6];
				  $formapagto = $linha[7];
				  $valor = $linha[8];
				  $qtdparcelas = $linha[9];				  
				  $codcategoria = $linha[10];
				  $descfluxo = $linha[11];
				
				  $valor = valorparaousuario_new($valor);
				  $datavencimento = dataparaousuario($datavencimento);
				  
				  if($datapagamento != "")
				  {
				  	$datapagamento = dataparaousuario($datapagamento);
				  }else{
				  	$datapagamento = "--/--/----";
				  }
							 
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
							  
				$sql = "SELECT form_descricao ". 
					"FROM formaspagamento where form_formapagto = $formapagto";	
					//echo $sql;			
				$result = execute_query($sql);
				$line = $result->fetchRow();				
				$for_descricao = $line[0];	
				
				if($codcategoria != 'null' && $codcategoria != "")
				{
					$sql = "SELECT cat_descricao ". 
						"FROM categoriasdemovimentacao where cat_categoria = $codcategoria";	
								
					$resultado3 = execute_query($sql);
					while($linha2 = $resultado3->fetchRow())
					{					
						$catdescricao = $linha2[0];	
					}					
				}
				
			 $x = $x+1;	 
			?>
			<tr class="<? echo $par; ?>">
				<td class='col-1' width="20px"><? echo $cod_fluxodecaixa."-".$cod_conta; ?> </td>
				<td class='col-2'><? echo $nomesacado; ?> </td>				
				<td class='col-3'><? echo $catdescricao; ?> </td>				
				<td class='col-2'><? echo $descfluxo; ?> </td>				
				<td class='col-5'><? echo $for_descricao; ?> </td>			
				<td class='col-5'><?  if($qtdparcelas == 1)
									  {
										echo "única";
										
									  }
									  else
									  {
										echo "<b>$parcela</b> de $qtdparcelas";
									  } 
				?>
				</td>
				<?
				//VERIFICA SE O VALOR É CRÉDITO OU DÉBITO//
				if($tipopagamento == 2)
				{
					?><td class='col-5'><? echo $valor; ?></td>					
				<? }else{
					?><td class='col-5'>--</td>					
				<? }
				if($tipopagamento == 1)
				{
					?><td class='col-5'><? echo $valor; ?></td>					
				<? }else{
					?><td class='col-5'>--</td>					
				<? } 
				//CALCULA O SALDO//
				if($tipopagamento == 1)
				{
				?>
				<td class='col-5'>
				<? 				
					$valor = valorparaobanco($valor);
					$saldoatual = $saldoatual + $valor;
					echo valorparaousuario_new($saldoatual);
				?>
				</td>					
				<? 
				}else{
				?>
				<td class='col-5'>
				<?
					$valor = valorparaobanco($valor);
					$saldoatual = $saldoatual - $valor;
					echo valorparaousuario_new($saldoatual);
				?>
				</td>					
				<? } ?>			
				<td class='col-7'><? echo $datavencimento; ?></td>					
				<td class='col-8'><? echo $datapagamento; ?></td>								
				<td class="grid-action"><a href="../_funcoes/controller.php?opcao=edicao-de-movimentacao/<? echo $cod_fluxodecaixa; ?>" class="editar" title="editar"></a> </td>
				<td class="grid-action"><a href="../_funcoes/controller.php?opcao=deletar-movimentacao/<? echo $cod_fluxodecaixa; ?>" class="excluir" title="excluir"></a> </td>				
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
				
		<tr>
		<td></td><td></td><td></td><td>Subtotal</td><td></td>
		<td></td>
		<td>	
		<? 
		$resultado = execute_query($sql_total_neg);	
		if($resultado->numRows()>0)
		{	
			while ($linha = $resultado->fetchRow()) 
			{		 			
				  $total_negativo  = $linha[0];
			}
		}		
		$total_negativo = valorparaousuario_new($total_negativo);
		if($total_negativo >0 )
		{
			echo $total_negativo;
		}else{ echo "--"; }
		?>	  
		</td>
		<td>	
		<?		
		$resultado = execute_query($sql_total_pos);	
		if($resultado->numRows()>0)
		{	
			while ($linha = $resultado->fetchRow()) 
			{		 			
				  $total_credito  = $linha[0];
			}
		}		
		$total_credito = valorparaousuario_new($total_credito);
		if($total_credito >0 )
		{
			echo $total_credito;
		}else{ echo "--"; }
		?>	  
		  </td>
		  <td><?=valorparaousuario_new($saldoatual)?></td><td></td>
		  <td></td>
		 </tr>
		 <tr>	
		 <td>&nbsp;</td><td></td><td></td><td></td><td></td>
		<td></td>
		<td>			
		</td>
		<td>		
		  </td>
		  <td></td><td></td>
		  <td></td>		
		</tr>	
			
		 <?
		 $sql = "SELECT con_conta, con_nome, con_saldoatual ". 
				"FROM contas ".								
				"ORDER BY con_nome";	
		$resultado = execute_query($sql);			
		while ($linha = $resultado->fetchRow()) 
		{		 			
			  $con_nome  = $linha[1];
			  $con_saldo  = $linha[2];
		 ?>
		 <tr>
		<td></td><td></td><td></td><td><?=$con_nome?></td><td></td>
		<td></td>
		<td>	
		<? 
		echo valorparaousuario_new($con_saldo);		
		?>	  
		</td>
		<td>		
		  </td>
		  <td></td><td></td>
		  <td></td>
		 </tr>
		<?
		}
		?>
		<tr>
		<td></td><td></td><td></td><td>Total</td><td></td>
		<td></td>
		<td>	
		<? 
		 $sql = "SELECT sum(con_saldoatual) ". 
				"FROM contas ";							
		$resultado = execute_query($sql);			
		while ($linha = $resultado->fetchRow()) 
		{
			$total = $linha[0];
		}
		echo valorparaousuario_new($total);		
		?>	  
		</td>
		<td>		
		  </td>
		  <td></td><td></td>
		  <td></td>
		 </tr>
		</tbody>
		<tfoot>		
		<tr>
		<td></td>
		<td>		
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
				  echo " <a href='home-financeiro.php?pagina=" . $i . "&paginacao=on'>" . $i . "</a> ";
			}
		} 
?>
	</fieldset>
	</fieldset>
</fieldset>		
</form>
</body>
</html>	