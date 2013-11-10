<?
session_start();
require_once("../_funcoes/funcoes.php");
require_once("../componentes/realpath.php");

if($_POST['sacado'] != '')
{
	$_SESSION['sacado'] = $_POST['sacado'];
}
if($_POST['resultadosPorPagina'] != '')
{
	$_SESSION['resultados_pagina'] = $_POST['resultadosPorPagina'];
}
if($_POST['mesInicio'] != '')
{
	$_SESSION['mesInicio'] = $_POST['mesInicio'];
}
if($_POST['mesFim'] != '')
{
	$_SESSION['mesFim'] = $_POST['mesFim']; 
}
if($_POST['exibir'] != '')
{
	$_SESSION['exibir'] = $_POST['exibir'];
}
if( $_POST['ano'] != '' )
{
	$_SESSION['ano'] = $_POST['ano'];
}
if($_POST['ordenarPor'] != '')
{
	$_SESSION['ordenarPor'] = $_POST['ordenarPor'];
}
if($_POST['categorias'] != '')
{
	$_SESSION['categorias'] = $_POST['categorias'];
}
if($_POST['contas'] != '')
{
	$_SESSION['contas'] = $_POST['contas'];	
}

$inicio = $_SESSION['inicio'];
$fim = $_SESSION['fim'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns='http://www.w3.org/1999/xhtml'>
  <head>
    <meta content='text/html; charset=iso-8859-1' http-equiv='Content-Type' />
    <title>
      Relatório Financeiro - Nexun Informática
    </title>
    <link rel='stylesheet' type='text/css' href='../_css/impressao/orcamentos/print.css' />
	<?
	echo "<script src='".$_CONF['realpath']."/_javascript/library.js' type='text/javascript'></script>\n";
	echo "<script src='".$_CONF['realpath']."/_javascript/event-listener.js' type='text/javascript'></script>\n";
	echo "<script src='".$_CONF['realpath']."/_javascript/prototype.js' type='text/javascript'></script>\n";
	echo "<script src='".$_CONF['realpath']."/_javascript/GridComponent.js' type='text/javascript'></script>\n";
	echo "<script src='".$_CONF['realpath']."/_javascript/incremental-search.js' type='text/javascript'></script>\n";
	echo "<script src='".$_CONF['realpath']."/_javascript/Main.js' type='text/javascript'></script>\n";
	echo "<script src='".$_CONF['realpath']."/_javascript/Default.js' type='text/javascript'></script>\n";
	echo "<script src='".$_CONF['realpath']."/_javascript/Validator.js' type='text/javascript'></script>\n";
	echo "<script src='".$_CONF['realpath']."/_javascript/dom.js' type='text/javascript'></script>\n";
	echo "<script src='".$_CONF['realpath']."/_javascript/domnavigation.js' type='text/javascript'></script>\n";
	?>
  </head>
  <body>
    <div id='cabecalho'>

      <img align='Nexun Informática' class='logo' src='../_images/logo_.jpg' />
      <h2>
        Relatório Financeiro
      </h2>
      <p class='codigo-data'>
        <strong id='caixa-codigo'>
          Período:
          <span id='codigo'>
            <? 
			$ano = $_POST['ano'];
			$mesInicio = $_POST['mesInicio'];
			$mesFim = $_POST['mesFim'];
			echo retornaMes($mesInicio)." à ".retornaMes($mesFim)."/".$ano;		
			
			?>
          </span>

        </strong>
        <strong id='caixa-data'>          
          <span id='data'>
            <? echo dataporextenso(); ?>
          </span>
        </strong>
      </p>
    </div>
    <div class="grid3">	
    </div>
<?
echo "<script src='../_javascript/wz_tooltip/wz_tooltip.js' type='text/javascript'></script>\n";
?>
<div class="grid">
	<table>
		<thead>
			<tr>
			<td class='col-1'></td>
			<?
			
			if($mesInicio < $mesFim)
			{
				for($i=$mesInicio; $i<=$mesFim; $i++)
				{
				?>
					<td class='col-1'><?=retornaMes($i)?></td>
				<?
				}			
			}
			?>
				
									
			</tr>
		</thead>			
		<tbody>
		<?
		
		
		
		
		
		$cont = 0;
	
						
		/*________BUSCA O SALDO ATUAL PARA FAZER AS PROJEÇÕES__________*/			
		/*$sql_saldo = "SELECT cai_saldoatual FROM caixa";
		$resultado1 = execute_query($sql_saldo);
		$linha1 = $resultado1->fetchRow();
		$saldoatual  = $linha1[0];*/
		/*____________________________________________________________*/		
									
		
		$cod_sacado = $_POST['sacado'];		
		$resultados = $_POST['resultados_pagina'];		
		$data_inicio = $_POST['inicio'];
		$data_fim = $_POST['fim'];
		$exibir = $_POST['exibir'];
		$ordem = $_POST['ordem'];
		$ordenacao = $_POST['ordenarPor'];
		$categorias = $_POST['categorias'];
		$cod_conta = $_POST['contas'];
		
		
		if($categoria!= 'null' && $categoria!= '')
		{
			$sql .=		getSQL($cont)." flux_categoriamovimentacao = '$categoria'";
			$cont++;
			$sql_total_pos .=		getSQL($cont)." flux_categoriamovimentacao = '$categoria'";
			$cont++;
			$sql_total_neg .=		getSQL($cont)." flux_categoriademovimentacao = '$categoria'";
			$cont++;
		}
		///CAMPO USADO PARA FILTRAR A DATA///
		if($exibir == 2)
		{			
			$campodata = " flux_datapagamento ";			
		}else{
			$campodata = " flux_datavencimento ";
		}
		
		
		
		/////AQUI CALCULO O SALDO ATUAL ATÉ A DATA INICIAL DA CONSULTA, PARA ADICIONAR AO SALDO ATUAL////
		$sql_positivo = "select sum(flux_valor) from fluxodecaixa ";
		$sql_positivo .= getSQL($cont)." flux_tipopagamento = 1 and flux_datapagamento < '$ano-$mesInicio-1' ";
		$cont++;
		
		if($cod_conta!= 'null' && $cod_conta!= '')
		{
			$sql_positivo .=		getSQL($cont)." flux_codconta = '$cod_conta'";
			$cont++;
		}
		switch ($exibir) {				
			case 2:			
				$sql_positivo .= getSQL($cont)." flux_estahpago = 'S'";
				$cont++;				
				break;
				
			case 3:			
				$sql_positivo .= getSQL($cont)." flux_estahpago = 'N'";
				$cont++;				
				break;			
		}
		if($categorias)
		{				
			if($categorias != 'null' && $categorias != '')
			{				
				$sql_positivo .=		getSQL($cont)." flux_categoriamovimentacao = '$categorias'";
				$cont++;				
			}			
		}	

		$result = execute_query($sql_positivo);
		while($line = $result->fetchRow())
		{				
			$soma_positivo = $line[0];	
		}
				
		$sql_negativo = "select sum(flux_valor) from fluxodecaixa ";
		$sql_negativo .= " WHERE flux_tipopagamento = 2 and flux_datapagamento < '$ano-$mesInicio-1' ";
		$cont++;
		
		if($cod_conta!= 'null' && $cod_conta!= '')
		{
			$sql_negativo .=		getSQL($cont)." flux_codconta = '$cod_conta'";
			$cont++;
		}
		
		switch ($exibir) {				
			case 2:			
				$sql_negativo .= getSQL($cont)." flux_estahpago = 'S'";
				$cont++;				
				break;
				
			case 3:			
				$sql_negativo .= getSQL($cont)." flux_estahpago = 'N'";
				$cont++;				
				break;			
		}	
		if($categorias)
		{		
			if($categorias != 'null' && $categorias != '')
			{				
				$sql_negativo .=		getSQL($cont)." flux_categoriamovimentacao = '$categorias'";
				$cont++;
			}			
		}	
		//echo $sql_negativo;
		$result = execute_query($sql_negativo);
		while($line = $result->fetchRow())
		{				
			$soma_negativo = $line[0];	
		}
		$saldo_inicial = $soma_positivo - $soma_negativo;
		
		
		
		
		///////////ENTRADAS/////////////
		$sql_desc = "SELECT distinct(gcat_descricao), cat_categoria, cat_descricao ". 
					"	FROM categoriasdemovimentacao ".
					"	INNER JOIN gruposcategorias ON gcat_grupo = cat_grupo ";
		$cont = 0;	
		if($categorias)
		{				
			if($categorias != 'null' && $categorias != '')
			{				
				$sql_desc .=		getSQL($cont)." cat_categoria = '$categorias'";
				$cont++;
			}			
		}			
		$sql_desc .= getSQL($cont)." cat_grupo = 1 ";
		$sql_desc .= "	ORDER BY cat_descricao ";	

		$x = 0;				
		$qtdcategorias = ""; 	
		$grupocat = 1;		
		$resultado3 = execute_query($sql_desc);
		while($linha2 = $resultado3->fetchRow())
		{	
			$grupodescricao = $linha2[0];
			$cod_categoria = $linha2[1];					
			$catdescricao = $linha2[2];
			$qtdcategorias++;
			
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
  		     
			 if($grupocat == 1)
			 {
			?>
			<tr class="<? echo $par; ?>">
				<td class='col-1'><strong><?=$grupodescricao?> </strong></td>
			</tr>
			<?
			}
			$grupocat = 0;
			?>
			<tr class="<? echo $par; ?>">
				<td class='col-1'><?=$catdescricao?> </td>
			<?
				
				for($i=$mesInicio; $i<=$mesFim; $i++)
				{
				
					$sql_positivo = "select sum(flux_valor) from fluxodecaixa where flux_tipopagamento = 1 ".
					" AND flux_categoriamovimentacao = $cod_categoria AND ".$campodata." BETWEEN '$ano-$i-1' AND '".dataparaobanco(ultimoDiaMes("01/$i/$ano"))."'";
					//echo "2009-$i-".ultimoDiaMes("01/$i/2009")." - ".ultimoDiaMes("01/01/2009")."<br>";
					//echo date("t/m/Y", mktime(0, 0, 0, 2, 1, 2008)); 	
					switch ($exibir) {				
						case 2:			
							$sql_positivo .= " AND flux_estahpago = 'S'";
							$cont++;				
							break;
							
						case 3:			
							$sql_positivo .= " AND flux_estahpago = 'N'";
							$cont++;				
							break;			
					}	
					//echo $sql_positivo;								
					$result = execute_query($sql_positivo);
					while($line = $result->fetchRow())
					{				
						$soma_positivo = $line[0];	
					}	
					
					$sql_negativo = "select sum(flux_valor) from fluxodecaixa where flux_tipopagamento = 2 ".
					" AND flux_categoriamovimentacao = $cod_categoria AND ".$campodata." BETWEEN '$ano-$i-1' AND '".dataparaobanco(ultimoDiaMes("01/$i/$ano"))."'";
					switch ($exibir) {				
						case 2:			
							$sql_negativo .= " AND flux_estahpago = 'S'";
							$cont++;				
							break;
							
						case 3:			
							$sql_negativo .= " AND flux_estahpago = 'N'";
							$cont++;				
							break;			
					}	
					$result = execute_query($sql_negativo);
					while($line = $result->fetchRow())
					{				
						$soma_negativo = $line[0];	
					}	
					?>
					<td class='col-1'>
					
					<?
					if($soma_negativo != 0 && $soma_positivo == 0)
					{
						echo "<font color='#FF0000'> ".valorparaousuario_new($soma_negativo)."</font>";
						$subtotais[$x][$i-1] -= $soma_negativo;
						
					}else if($soma_positivo != 0 && $soma_negativo == 0){					

						echo "<font color='#0000FF'> ".valorparaousuario_new($soma_positivo)."</font>";
						$subtotais[$x][$i-1] += $soma_positivo;
						
					}else if($soma_positivo == 0 && $soma_negativo == 0){					
						echo valorparaousuario_new($soma_positivo);
												
					}else{
						$saldo = ($soma_positivo-$soma_negativo);
						?>
						
						<a target="_blank" onmouseover="Tip('C <?=valorparaousuario_new($soma_positivo)?> - D <?=valorparaousuario_new($soma_negativo)?> = <?=valorparaousuario_new($saldo)?>')" onmouseout="UnTip()">
						<?						
						if($saldo < 0)
						{						
							echo "<font color='#FF0000'> S ".valorparaousuario_new($saldo)."</font>";
							///Aqui somo pois o valor está com sinal negativo///
							$subtotais[$x][$i-1] += $saldo;
						}else{
							echo "<font color='#0000FF'> S ".valorparaousuario_new($saldo)."</font>";
							$subtotais[$x][$i-1] += $saldo;
						}
						?>
						</a>
						<?						
					}
					?>
					</td>
					<?
				}			
			?>				
			</tr>
			<?
			
			///DETALHAMENTO DAS MOVIMENTACOES NAS SUBCATEGORIAS, APENAS SE FOR SELECIONADO UMA CATEGORIA NO FILTRO///			
			if($categorias != 'null' && $categorias != '')
			{
				$sql_sub = " SELECT subc_subcategoria, subc_subdescricao ".
						   " FROM subcategoriasmovimentacao WHERE subc_categoria = ". $cod_categoria;
				$resultado4 = execute_query($sql_sub);
				if($resultado4->numRows()>0)
				{	
					while($linha3 = $resultado4->fetchRow())
					{	
						$subcategoria = $linha3[0];				
						$subdescricao = utf8_decode($linha3[1]);
					
					
					?>
						<tr class="<? //echo $par; ?>">
							<td class='col-1'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;<?=$subdescricao?> </td>
						<?
							
							for($i=$mesInicio; $i<=$mesFim; $i++)
							{
							
								$sql_positivo = "select sum(flux_valor) from fluxodecaixa where flux_tipopagamento = 1 ".
								" AND flux_subcategoriamovimentacao = $subcategoria AND ".$campodata." BETWEEN '$ano-$i-1' AND '".dataparaobanco(ultimoDiaMes("01/$i/$ano"))."'";
								//echo "2009-$i-".ultimoDiaMes("01/$i/2009")." - ".ultimoDiaMes("01/01/2009")."<br>";
								//echo date("t/m/Y", mktime(0, 0, 0, 2, 1, 2008)); 	
								switch ($exibir) {				
									case 2:			
										$sql_positivo .= " AND flux_estahpago = 'S'";
										$cont++;				
										break;
										
									case 3:			
										$sql_positivo .= " AND flux_estahpago = 'N'";
										$cont++;				
										break;			
								}	
														
								$result = execute_query($sql_positivo);
								while($line = $result->fetchRow())
								{				
									$soma_positivo = $line[0];	
								}	
								
								$sql_negativo = "select sum(flux_valor) from fluxodecaixa where flux_tipopagamento = 2 ".
								" AND flux_subcategoriademovimentacao = $subcategoria AND ".$campodata." BETWEEN '$ano-$i-1' AND '".dataparaobanco(ultimoDiaMes("01/$i/$ano"))."'";
								switch ($exibir) {				
									case 2:			
										$sql_negativo .= " AND flux_estahpago = 'S'";
										$cont++;				
										break;
										
									case 3:			
										$sql_negativo .= " AND flux_estahpago = 'N'";
										$cont++;				
										break;			
								}	
								//echo $sql_negativo;
								$result = execute_query($sql_negativo);
								while($line = $result->fetchRow())
								{				
									$soma_negativo = $line[0];	
								}	
								?>
								<td class='col-1'>
								
								<?
								if($soma_negativo != 0 && $soma_positivo == 0)
								{
									echo "<font color='#FF0000'> ".valorparaousuario_new($soma_negativo)."</font>";
									//$subtotalsaida[$x][$i-1] -= $soma_negativo;
									
								}else if($soma_positivo != 0 && $soma_negativo == 0){					
			
									echo "<font color='#0000FF'> ".valorparaousuario_new($soma_positivo)."</font>";
									//$subtotalsaida[$x][$i-1] += $soma_positivo;
									
								}else if($soma_positivo == 0 && $soma_negativo == 0){					
									//echo valorparaousuario_new($soma_positivo);
															
								}else{
									$saldo = ($soma_positivo-$soma_negativo);
									?>
									
									<a target="_blank" onmouseover="Tip('C <?=valorparaousuario_new($soma_positivo)?> - D <?=valorparaousuario_new($soma_negativo)?> = <?=valorparaousuario_new($saldo)?>')" onmouseout="UnTip()">
									<?						
									if($saldo < 0)
									{						
										echo "<font color='#FF0000'> S ".valorparaousuario_new($saldo)."</font>";
										///Aqui somo pois o valor está com sinal negativo///
										//$subtotalsaida[$x][$i-1] += $saldo;
									}else{
										echo "<font color='#0000FF'> S ".valorparaousuario_new($saldo)."</font>";
										//$subtotalsaida[$x][$i-1] += $saldo;
									}
									?>
									</a>
									<?						
								}
								?>
								</td>
								<?
							}
							?>
							</tr>
						<?		
						}
				}
			}		
			$x = $x+1;	 
		}
		
		?>
		<tr>
		<td>&nbsp;</td>
		</tr>
		
		<tr>
			<td class='col-1'>Subtotal Entradas</td>
		<?
		///SUBTOTAL NO PERÍODO///
		for($i=$mesInicio; $i<=$mesFim; $i++)
		{	
			$totalnoperiodo = 0;
			for($x=0; $x<$qtdcategorias; $x++)
			{			
				$totalnoperiodo += $subtotais[$x][$i-1];
			}
			$subentradas[$i] = $totalnoperiodo;			
			?>			
			<td class='col-1'><? echo valorparaousuario_new($totalnoperiodo); ?></td>
			<?
		}	
		?>
		</tr>		
		<tr>
		<td>&nbsp;</td>
		</tr>			
		<?
		///////////SAIDAS/////////////
		$sql_desc = "SELECT distinct(gcat_descricao), cat_categoria, cat_descricao ". 
					"	FROM categoriasdemovimentacao ".
					"	INNER JOIN gruposcategorias ON gcat_grupo = cat_grupo ";
			
		if($categorias)
		{		
		$cont = 0;	
			if($categorias != 'null' && $categorias != '')
			{				
				$sql_desc .=		getSQL($cont)." cat_categoria = '$categorias'";
				$cont++;
			}				
		}
		$sql_desc .= getSQL($cont)." cat_grupo = 2 ";	
		$sql_desc .= "	ORDER BY cat_descricao ";	

		$x = 0;				
		$qtdcategorias = ""; 	
		$grupocat = 1;		
		$resultado3 = execute_query($sql_desc);
		while($linha2 = $resultado3->fetchRow())
		{	
			$grupodescricao = $linha2[0];
			$cod_categoria = $linha2[1];					
			$catdescricao = $linha2[2];
			$qtdcategorias++;
			
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
  		     
			 if($grupocat == 1)
			 {
			?>
			<tr class="<? echo $par; ?>">
				<td class='col-1'><strong><?=$grupodescricao?> </strong></td>
			</tr>
			<?
			}
			$grupocat = 0;
			?>
			<tr class="<? echo $par; ?>">
				<td class='col-1'><?=$catdescricao?> </td>
			<?
				
				for($i=$mesInicio; $i<=$mesFim; $i++)
				{
				
					$sql_positivo = "select sum(flux_valor) from fluxodecaixa where flux_tipopagamento = 1 ".
					" AND flux_categoriamovimentacao = $cod_categoria AND ".$campodata." BETWEEN '$ano-$i-1' AND '".dataparaobanco(ultimoDiaMes("01/$i/$ano"))."'";
					//echo "2009-$i-".ultimoDiaMes("01/$i/2009")." - ".ultimoDiaMes("01/01/2009")."<br>";
					//echo date("t/m/Y", mktime(0, 0, 0, 2, 1, 2008)); 	
					switch ($exibir) {				
						case 2:			
							$sql_positivo .= " AND flux_estahpago = 'S'";
							$cont++;				
							break;
							
						case 3:			
							$sql_positivo .= " AND flux_estahpago = 'N'";
							$cont++;				
							break;			
					}	
											
					$result = execute_query($sql_positivo);
					while($line = $result->fetchRow())
					{				
						$soma_positivo = $line[0];	
					}	
					
					$sql_negativo = "select sum(flux_valor) from fluxodecaixa where flux_tipopagamento = 2 ".
					" AND flux_categoriamovimentacao = $cod_categoria AND ".$campodata." BETWEEN '$ano-$i-1' AND '".dataparaobanco(ultimoDiaMes("01/$i/$ano"))."'";
					switch ($exibir) {				
						case 2:			
							$sql_negativo .= " AND flux_estahpago = 'S'";
							$cont++;				
							break;
							
						case 3:			
							$sql_negativo .= " AND flux_estahpago = 'N'";
							$cont++;				
							break;			
					}	
					$result = execute_query($sql_negativo);
					while($line = $result->fetchRow())
					{				
						$soma_negativo = $line[0];	
					}	
					?>
					<td class='col-1'>
					
					<?
					if($soma_negativo != 0 && $soma_positivo == 0)
					{
						echo "<font color='#FF0000'> ".valorparaousuario_new($soma_negativo)."</font>";
						$subtotalsaida[$x][$i-1] -= $soma_negativo;
						
					}else if($soma_positivo != 0 && $soma_negativo == 0){					

						echo "<font color='#0000FF'> ".valorparaousuario_new($soma_positivo)."</font>";
						$subtotalsaida[$x][$i-1] += $soma_positivo;
						
					}else if($soma_positivo == 0 && $soma_negativo == 0){					
						echo valorparaousuario_new($soma_positivo);
												
					}else{
						$saldo = ($soma_positivo-$soma_negativo);
						?>
						
						<a target="_blank" onmouseover="Tip('C <?=valorparaousuario_new($soma_positivo)?> - D <?=valorparaousuario_new($soma_negativo)?> = <?=valorparaousuario_new($saldo)?>')" onmouseout="UnTip()">
						<?						
						if($saldo < 0)
						{						
							echo "<font color='#FF0000'> S ".valorparaousuario_new($saldo)."</font>";
							///Aqui somo pois o valor está com sinal negativo///
							$subtotalsaida[$x][$i-1] += $saldo;
						}else{
							echo "<font color='#0000FF'> S ".valorparaousuario_new($saldo)."</font>";
							$subtotalsaida[$x][$i-1] += $saldo;
						}
						?>
						</a>
						<?						
					}
					?>
					</td>
					<?
				}			
			?>				
			</tr>
			<?
			///DETALHAMENTO DAS MOVIMENTACOES NAS SUBCATEGORIAS, APENAS SE FOR SELECIONADO UMA CATEGORIA NO FILTRO///			
			if($categorias != 'null' && $categorias != '')
			{
				$sql_sub = " SELECT subc_subcategoria, subc_subdescricao ".
						   " FROM subcategoriasmovimentacao WHERE subc_categoria = ". $cod_categoria;
				$resultado4 = execute_query($sql_sub);
				if($resultado4->numRows()>0)
				{	
					while($linha3 = $resultado4->fetchRow())
					{	
						$subcategoria = $linha3[0];				
						$subdescricao = utf8_decode($linha3[1]);
					
					
					?>
						<tr class="<? //echo $par; ?>">
							<td class='col-1'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;<?=$subdescricao?> </td>
						<?
							
							for($i=$mesInicio; $i<=$mesFim; $i++)
							{
							
								$sql_positivo = "select sum(flux_valor) from fluxodecaixa where flux_tipopagamento = 1 ".
								" AND flux_subcategoriademovimentacao = $subcategoria AND ".$campodata." BETWEEN '$ano-$i-1' AND '".dataparaobanco(ultimoDiaMes("01/$i/$ano"))."'";
								//echo "2009-$i-".ultimoDiaMes("01/$i/2009")." - ".ultimoDiaMes("01/01/2009")."<br>";
								//echo date("t/m/Y", mktime(0, 0, 0, 2, 1, 2008)); 	
								switch ($exibir) {				
									case 2:			
										$sql_positivo .= " AND flux_estahpago = 'S'";
										$cont++;				
										break;
										
									case 3:			
										$sql_positivo .= " AND flux_estahpago = 'N'";
										$cont++;				
										break;			
								}	
														
								$result = execute_query($sql_positivo);
								while($line = $result->fetchRow())
								{				
									$soma_positivo = $line[0];	
								}	
								
								$sql_negativo = "select sum(flux_valor) from fluxodecaixa where flux_tipopagamento = 2 ".
								" AND flux_subcategoriademovimentacao = $subcategoria AND ".$campodata." BETWEEN '$ano-$i-1' AND '".dataparaobanco(ultimoDiaMes("01/$i/$ano"))."'";
								switch ($exibir) {				
									case 2:			
										$sql_negativo .= " AND flux_estahpago = 'S'";
										$cont++;				
										break;
										
									case 3:			
										$sql_negativo .= " AND flux_estahpago = 'N'";
										$cont++;				
										break;			
								}	
								//echo $sql_negativo;
								$result = execute_query($sql_negativo);
								while($line = $result->fetchRow())
								{				
									$soma_negativo = $line[0];	
								}	
								?>
								<td class='col-1'>
								
								<?
								if($soma_negativo != 0 && $soma_positivo == 0)
								{
									echo "<font color='#FF0000'> ".valorparaousuario_new($soma_negativo)."</font>";
									//$subtotalsaida[$x][$i-1] -= $soma_negativo;
									
								}else if($soma_positivo != 0 && $soma_negativo == 0){					
			
									echo "<font color='#0000FF'> ".valorparaousuario_new($soma_positivo)."</font>";
									//$subtotalsaida[$x][$i-1] += $soma_positivo;
									
								}else if($soma_positivo == 0 && $soma_negativo == 0){					
									//echo valorparaousuario_new($soma_positivo);
															
								}else{
									$saldo = ($soma_positivo-$soma_negativo);
									?>
									
									<a target="_blank" onmouseover="Tip('C <?=valorparaousuario_new($soma_positivo)?> - D <?=valorparaousuario_new($soma_negativo)?> = <?=valorparaousuario_new($saldo)?>')" onmouseout="UnTip()">
									<?						
									if($saldo < 0)
									{						
										echo "<font color='#FF0000'> S ".valorparaousuario_new($saldo)."</font>";
										///Aqui somo pois o valor está com sinal negativo///
										//$subtotalsaida[$x][$i-1] += $saldo;
									}else{
										echo "<font color='#0000FF'> S ".valorparaousuario_new($saldo)."</font>";
										//$subtotalsaida[$x][$i-1] += $saldo;
									}
									?>
									</a>
									<?						
								}
								?>
								</td>
								<?
							}
							?>
							</tr>
						<?		
						}
				}
			}	
						   
			$x = $x+1;	 
		}
		
		?>
		<tr>
		<td>&nbsp;</td>
		</tr>
		
		<tr>
			<td class='col-1'>Subtotal Saídas</td>
		<?
		///SUBTOTAL NO PERÍODO///
		for($i=$mesInicio; $i<=$mesFim; $i++)
		{	
			$totalnoperiodo = 0;
			for($x=0; $x<$qtdcategorias; $x++)
			{			
				$totalnoperiodo += $subtotalsaida[$x][$i-1];
			}			
			$subsaidas[$i] = $totalnoperiodo;
			?>			
			
			<td class='col-1'><? echo valorparaousuario_new($totalnoperiodo); ?></td>
			<?
		}	
		?>
		</tr>
		<tr>
		<td>&nbsp;</td>
		</tr>
		<tr class="<? /*echo $par;*/ ?>">
			<td class='col-1'>Saldo do Mês (A-B)</td>
		<?
		///SALDO: SUBTOTAL A - SUBTOTAL B////
		$saldo = 0;
		for($i=$mesInicio; $i<=$mesFim; $i++)
		{	
			$saldo = $subentradas[$i] + $subsaidas[$i];
				
			?>			
			<td class='col-1'><? echo valorparaousuario_new($saldo); ?></td>
			<?
		}	
		?>
		</tr>	
		<tr>
		<td>&nbsp;</td>
		</tr>			
		<tr class="<? /*echo $par;*/ ?>">
			<td class='col-1'>Saldo Mês Anterior</td>
			<td class='col-1'><? echo valorparaousuario_new($saldo_inicial); ?></td>		<?
		///SALDO: SUBTOTAL A - SUBTOTAL B////		
		$saldo = $saldo_inicial;
		for($i=$mesInicio; $i<=$mesFim-1; $i++)
		{	
			$saldo += $subentradas[$i] + $subsaidas[$i];
				
			?>			
			<td class='col-1'><? echo valorparaousuario_new($saldo); ?></td>
			<?
		}	
		?>
		</tr>		
		
		<tr class="<? echo $par; ?>">
			<td class='col-1'>Saldo Final</td>
		<?
		///SALDO: SALDO INICIAL + (SUBTOTAL A - SUBTOTAL B)////
		$saldo = $saldo_inicial;
		for($i=$mesInicio; $i<=$mesFim; $i++)
		{	
			$saldo += $subentradas[$i] + $subsaidas[$i];
				
			?>			
			<td class='col-1'><? echo valorparaousuario_new($saldo); ?></td>
			<?
		}	
		?>
		</tr>		
		
		<tr>
		<td>&nbsp;</td>
		</tr>
		 <tr>
		<td><strong>Saldo das Contas no Período</strong></td>
		 </tr>
		 <?
		$sql = "SELECT con_conta, con_nome ". 
				"FROM contas ".								
				"ORDER BY con_nome";	
		$resultado = execute_query($sql);			
		$x = 0;
		while ($linha = $resultado->fetchRow()) 
		{		 			
			  $con_conta = $linha[0];
			  $con_nome  = $linha[1];
			  $contas++;
			  
			   
			   ///CALCULA O SALDO INICIAL ANTES DO PERÍODO///
			   $sql_positivo = "select sum(com_valormovimentado) from contasmovimentacao where com_conta = $con_conta and com_tipopagamento = 1 and com_datamovimentacao < '$ano-$mesInicio-1'";		
				
				$result = execute_query($sql_positivo);
				while($line = $result->fetchRow())
				{				
					$soma_positivo_inicial = $line[0];	
				}
				
				$sql_negativo = "select sum(com_valormovimentado) from contasmovimentacao where com_conta = $con_conta and com_tipopagamento = 2 and com_datamovimentacao < '$ano-$mesInicio-1'";
				
				$result = execute_query($sql_negativo);
				while($line = $result->fetchRow())
				{				
					$soma_negativo_inicial = $line[0];	
				}
			
				$saldoinicialconta = $soma_positivo_inicial - $soma_negativo_inicial;			
				$saldo = $saldoinicialconta;

				//////////////////////////////////////////////////
		?>
		 <tr>
		<td><?=$con_nome?></td>		
		<?			
			for($i=$mesInicio; $i<=$mesFim; $i++)
			{	
			/////AQUI CALCULO O SALDO DAS CONTAS NO PERÍODO CONSULTADO////		 
			
				$sql_positivo = "select sum(com_valormovimentado) from contasmovimentacao where com_conta = $con_conta and com_tipopagamento = 1 and com_datamovimentacao BETWEEN '$ano-$mesInicio-1' AND '".dataparaobanco(ultimoDiaMes("01/$i/$ano"))."' ";		
				
				$result = execute_query($sql_positivo);
				while($line = $result->fetchRow())
				{				
					$soma_positivo1 = $line[0];	
				}
				
				$sql_negativo = "select sum(com_valormovimentado) from contasmovimentacao where com_conta = $con_conta and com_tipopagamento = 2 and com_datamovimentacao BETWEEN '$ano-$mesInicio-1' AND '".dataparaobanco(ultimoDiaMes("01/$i/$ano"))."' ";
				
				$result = execute_query($sql_negativo);
				while($line = $result->fetchRow())
				{				
					$soma_negativo1 = $line[0];	
				}
			
				$saldocontaperiodo = $soma_positivo1 - $soma_negativo1;	
										
				$saldocontaperiodo =  $saldo + $saldocontaperiodo;
								
				$subtotais_contas[$x][$i-1] += $saldocontaperiodo;
							
				?>			
			<td>
			<? 
			echo valorparaousuario_new($saldocontaperiodo);					
			?>	  
			</td>
			<?
			}
			?>		
		 </tr>
		 <?
		}
	?>
	<tr class="<? echo $par; ?>">
			<td class='col-1'>Saldo</td>
		<?
		////SALDO DAS CONTAS////
		for($i=$mesInicio; $i<=$mesFim; $i++)
		{		
			$total = 0;		
			for($x=0; $x<$contas; $x++)
			{			
				$total += $subtotais_contas[$x][$i-1];
			}
			
		?>
			<td class='col-1'><? echo valorparaousuario_new($total); ?></td>
		<?
		}
	?>
	</tr>
	</tbody>
	</table>
 
 </div>
 
</html>
