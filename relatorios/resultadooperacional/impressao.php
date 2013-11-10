<?
session_start();
require_once("../../_funcoes/funcoes.php");
require_once("../../componentes/realpath.php");
$conn = conecta_banco();
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
    <title>Relatório</title>
    <link rel='stylesheet' type='text/css' href='../../_css/impressao/orcamentos/print.css' />
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

      <img align='Nexun Informática' class='logo' src='../../_images/logo_.jpg' />
      <h2>
        Resultado Operacional
      </h2>
      <p class='codigo-data'>
        <strong id='caixa-codigo'>
          Período:
          <span id='codigo'>
            <? 
			$data_inicio = $_POST['inicio'];
			$data_fim = $_POST['fim'];
			$reserva = valorparaobanco($_POST['reserva']);			
			list($diaInicio, $mesInicio, $anoInicio) = split("/", $data_inicio);
			list($diaFim, $mesFim, $anoFim) = split("/", $data_fim);
			
			echo retornaMes($mesInicio)."/".$anoInicio." à ".retornaMes($mesFim)."/".$anoFim;		
			
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
echo "<script src='../../_javascript/wz_tooltip/wz_tooltip.js' type='text/javascript'></script>\n";
?>
<div class="grid-auto">
	<table>
		<thead>
        <?
		 ///CALCULA O SALDO INICIAL ANTES DO PERÍODO///
		$sql_positivo = "select sum(flux_valor) from fluxodecaixa where flux_tipopagamento = 1 AND
		 flux_datapagamento < '$anoInicio-$mesInicio-1'";		
		
		$result = Execute($conn, $sql_positivo);
		while($line = $result->fetchRow())
		{				
			$soma_positivo_inicial = $line[0];	
		}
		
		$sql_negativo = "select sum(flux_valor) from fluxodecaixa where flux_tipopagamento = 2 AND
		 flux_datapagamento < '$anoInicio-$mesInicio-1'";
		
		$result = Execute($conn, $sql_negativo);
		while($line = $result->fetchRow())
		{				
			$soma_negativo_inicial = $line[0];	
		}
		
		$saldoinicial = $soma_positivo_inicial - $soma_negativo_inicial;
		?>
        
        
			<tr>
			<td class='col-2'>Saldo inicial: <?=valorparaousuario_new($saldoinicial)?></td>
			<?
			
			
							
			$mes = $mesInicio;	
			$ano = $anoInicio;		
			$finished = false;
			while(!$finished)
			{
				?>
				<td class='col-1'><?=retornaMes($mes)." de ".$ano?></td><td class='col-1' align="right">(%)</td>
				<?
				$mes++;
				if($mes > 12)
				{
					$mes = 1;
					$ano++;						
				}				
				if($mes > $mesFim && $ano == $anoFim)
				{					
					$finished = true;
				}					
			}		
			?>									
			</tr>
		</thead>			
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
		
		
		
		$cont = 0;
	
		?>
  	    
		<tr>
		<td>Receita Bruta</td>							
        <?	
		
				
		
							
		
		//////////////////////////////////////////////////
		////////////RECEITA BRUTA////////////////////////
		/////////////////////////////////////////////////
		$mes = $mesInicio;	
		$ano = $anoInicio;							
		$i = 0;	
		$finished = false;
		while(!$finished)
		{		
			
			$sql = "SELECT SUM(flux_valor) FROM fluxodecaixa INNER JOIN categoriasdemovimentacao ON cat_categoria = flux_categoriamovimentacao ";
			$sql .= " WHERE flux_tipopagamento = 1 AND cat_economica = 1 AND flux_datapagamento BETWEEN '$ano-".($mes)."-1' AND '".dataparaobanco(ultimoDiaMes("01/".($mes)."/$ano"))."' ";
			
			$result = Execute($conn, $sql);
			while($line = $result->fetchRow())
			{				
				$receitabruta = $line[0];	
			}			
			?>
            <td class='col-1' align="right"><?=valorparaousuario_new($receitabruta)?></td>
            <td class='col-1' align="right">100.00%</td>
            <?
			$totais[0][$i] = $receitabruta;
			$i++;			
            $mes++;
            if($mes > 12)
            {
                $mes = 1;
                $ano++;						
            }				
            if($mes > $mesFim && $ano == $anoFim)
            {					
                $finished = true;
            }			
		}
		?>
		</tr>
        <tr>
		<td>Deduções</td>	
        <?
        //////////////////////////////////////////////////
		////////////DEDUÇÕES//////////////////////////////
		//////////////////////////////////////////////////
		$mes = $mesInicio;	
		$ano = $anoInicio;							
		$i = 0;	
		$finished = false;
		while(!$finished)
		{		
			
			$sql_positivo = "SELECT SUM(flux_valor) FROM fluxodecaixa  INNER JOIN categoriasdemovimentacao ON cat_categoria = flux_categoriamovimentacao ";
			$sql_positivo .= " WHERE flux_tipopagamento = 2 AND cat_economica = 2 AND flux_datapagamento BETWEEN '$ano-".($mes)."-1' AND '".dataparaobanco(ultimoDiaMes("01/".($mes)."/$ano"))."' ";
			$result = Execute($conn, $sql_positivo);
			while($line = $result->fetchRow())
			{				
				$deducoes = $line[0];	
			}			
			?>
            <td class='col-1' align="right"><?=valorparaousuario_new($deducoes)?></td>
            <td class='col-1' align="right"><?=round(($deducoes/$totais[0][$i])*100, 2)?>%</td>
            <?
			$totais[1][$i] = $deducoes;
			$i++;			
            $mes++;
            if($mes > 12)
            {
                $mes = 1;
                $ano++;						
            }				
            if($mes > $mesFim && $ano == $anoFim)
            {					
                $finished = true;
            }			
		}
		?>
		</tr>        
         
        <tr class="par">
        <td>Receita Líquida</td>
        <?
			for($i=0; $i<sizeof($totais[0]); $i++)
			{
				$receitaliquida = $totais[0][$i] - $totais[1][$i];
				?>
                <td class='col-1' align="right"><?=valorparaousuario_new($receitaliquida)?></td>
                <td class='col-1' align="right"><?=round(($receitaliquida/$totais[0][$i])*100, 2)?>%</td>
                <?
                $totais[2][$i] = $receitaliquida;
			} 
		?>
        </tr> 
        
        
        <tr>
		<td>Custos Variáveis</td>	
        <?
        //////////////////////////////////////////////////
		////////////CUSTOS VARIÁVEIS//////////////////////
		//////////////////////////////////////////////////
		$mes = $mesInicio;	
		$ano = $anoInicio;							
		$i = 0;	
		$finished = false;
		while(!$finished)
		{		
			
			$sql_positivo = "SELECT SUM(flux_valor) FROM fluxodecaixa  INNER JOIN categoriasdemovimentacao ON cat_categoria = flux_categoriamovimentacao ";
			$sql_positivo .= " WHERE flux_tipopagamento = 2 AND cat_economica = 3 AND flux_datapagamento BETWEEN '$ano-".($mes)."-1' AND '".dataparaobanco(ultimoDiaMes("01/".($mes)."/$ano"))."' ";
			$result = Execute($conn, $sql_positivo);
			while($line = $result->fetchRow())
			{				
				$custosvariaveis = $line[0];	
			}			
			?>
            <td class='col-1' align="right"><?=valorparaousuario_new($custosvariaveis)?></td>
            <td class='col-1' align="right"><?=round(($custosvariaveis/$totais[0][$i])*100, 2)?>%</td>
            <?
			$totais[3][$i] = $custosvariaveis;
			$i++;			
            $mes++;
            if($mes > 12)
            {
                $mes = 1;
                $ano++;						
            }				
            if($mes > $mesFim && $ano == $anoFim)
            {					
                $finished = true;
            }			
		}
		?>
		</tr> 
        
        <tr class="par">
        <td>Margem de Contribuição</td>
        <?
			for($i=0; $i<sizeof($totais[0]); $i++)
			{
				$margemcontribuicao = $totais[2][$i] - $totais[3][$i];
				?>
                <td class='col-1' align="right"><?=valorparaousuario_new($margemcontribuicao)?></td>
                <td class='col-1' align="right"><?=round(($margemcontribuicao/$totais[0][$i])*100, 2)?>%</td>
                <?
                $totais[4][$i] = $margemcontribuicao;
			} 
		?>
        </tr> 
        
        
        <tr>
		<td>Custos Fixos</td>	
        <?
        //////////////////////////////////////////////////
		////////////CUSTOS FIXOS//////////////////////////
		//////////////////////////////////////////////////
		$mes = $mesInicio;	
		$ano = $anoInicio;							
		$i = 0;	
		$finished = false;
		while(!$finished)
		{		
			
			$sql_positivo = "SELECT SUM(flux_valor) FROM fluxodecaixa  INNER JOIN categoriasdemovimentacao ON cat_categoria = flux_categoriamovimentacao ";
			$sql_positivo .= " WHERE flux_tipopagamento = 2 AND cat_economica = 4 AND flux_datapagamento BETWEEN '$ano-".($mes)."-1' AND '".dataparaobanco(ultimoDiaMes("01/".($mes)."/$ano"))."' ";
			$result = Execute($conn, $sql_positivo);
			while($line = $result->fetchRow())
			{				
				$custosfixos = $line[0];	
			}			
			?>
            <td class='col-1' align="right"><?=valorparaousuario_new($custosfixos)?></td>
            <td class='col-1' align="right"><?=round(($custosfixos/$totais[0][$i])*100, 2)?>%</td>
            <?
			$totais[5][$i] = $custosfixos;
			$i++;			
            $mes++;
            if($mes > 12)
            {
                $mes = 1;
                $ano++;						
            }				
            if($mes > $mesFim && $ano == $anoFim)
            {					
                $finished = true;
            }			
		}
		?>
		</tr> 
        
        
        
        <tr class="par">
        <td>Resultado Operacional</td>
        <?
			for($i=0; $i<sizeof($totais[0]); $i++)
			{
				$resultadooperacional = $totais[4][$i] - $totais[5][$i];
				?>
                <td class='col-1' align="right"><?=valorparaousuario_new($resultadooperacional)?></td>
                <td class='col-1' align="right"><?=round(($resultadooperacional/$totais[0][$i])*100, 2)?>%</td>
                <?
                $totais[6][$i] = $resultadooperacional;
			} 
		?>
        </tr>        
         
		<tr>
		<td>Saldo do Mês</td>	
        <?
        //////////////////////////////////////////////////
		////////////CUSTOS FIXOS//////////////////////////
		//////////////////////////////////////////////////
		$mes = $mesInicio;	
		$ano = $anoInicio;							
		$i = 0;	
		$finished = false;
		while(!$finished)
		{	
			
			$sql_positivo = "select sum(flux_valor) from fluxodecaixa where flux_tipopagamento = 1 AND
			 flux_datapagamento BETWEEN '$ano-".($mes)."-1' AND '".dataparaobanco(ultimoDiaMes("01/".($mes)."/$ano"))."'";				
			$result = Execute($conn, $sql_positivo);
			while($line = $result->fetchRow())
			{				
				$saldopositivomes = $line[0];	
			}
			//echo $sql_positivo;
			$sql_negativo = "select sum(flux_valor) from fluxodecaixa where flux_tipopagamento = 2 AND
			 flux_datapagamento BETWEEN '$ano-".($mes)."-1' AND '".dataparaobanco(ultimoDiaMes("01/".($mes)."/$ano"))."'";			
			$result = Execute($conn, $sql_negativo);
			while($line = $result->fetchRow())
			{				
				$saldonegativomes = $line[0];	
			}	
			$saldomes = $saldopositivomes - $saldonegativomes;	
			?>
            <td class='col-1' align="right"><?=valorparaousuario_new($saldomes)?></td>
            <td class='col-1' align="right"></td>
            <?
			$totais[7][$i] = $saldomes;
			$i++;			
            $mes++;
            if($mes > 12)
            {
                $mes = 1;
                $ano++;						
            }				
            if($mes > $mesFim && $ano == $anoFim)
            {					
                $finished = true;
            }			
		}
		?>
		</tr>
        
        
        <tr class="par">
        <td>Saldo Acumulado</td>
        <?
		
			for($i=0; $i<sizeof($totais[0]); $i++)
			{
				$saldoacumulado = $totais[7][$i] + $totais[8][$i-1];
				if($i==0)
				{					
					$saldoacumulado += $saldoinicial;
				}
				?>
                <td class='col-1' align="right"><?=valorparaousuario_new($saldoacumulado)?></td>
                <td class='col-1' align="right"></td>
                <?
                $totais[8][$i] = $saldoacumulado;
			} 
		?>
        </tr> 
        
	</tbody>
	</table>
 
 </div>
 
</html>
