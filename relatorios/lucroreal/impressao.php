<?
session_start();
require_once("../../_funcoes/funcoes.php");
require_once("../../componentes/realpath.php");

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
    <title>Saldo Acumulado de Caixa</title>
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
        Saldo Acumulado de Caixa
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
			<tr>
			<td class='col-1'></td>
			<?
			
			
							
			$mes = $mesInicio;	
			$ano = $anoInicio;		
			$finished = false;
			while(!$finished)
			{
				?>
				<td class='col-1'><?=retornaMes($mes)." de ".$ano?></td>
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
		<td>Valor em Caixa Mês Anterior</td>							
        <?	
		
				
		
		 ///CALCULA O SALDO INICIAL ANTES DO PERÍODO///
		$sql_positivo = "select sum(com_valormovimentado) from contasmovimentacao where com_tipopagamento = 1 and com_datamovimentacao < '$anoInicio-$mesInicio-1'";		
		
		$result = execute_query($sql_positivo);
		while($line = $result->fetchRow())
		{				
			$soma_positivo_inicial = $line[0];	
		}
		
		$sql_negativo = "select sum(com_valormovimentado) from contasmovimentacao where com_tipopagamento = 2 and com_datamovimentacao < '$anoInicio-$mesInicio-1'";
		
		$result = execute_query($sql_negativo);
		while($line = $result->fetchRow())
		{				
			$soma_negativo_inicial = $line[0];	
		}
		
		$saldoinicial = $soma_positivo_inicial - $soma_negativo_inicial;					
		
		//////////////////////////////////////////////////
		
		$mes = $mesInicio;	
		$ano = $anoInicio;							
		$i = 0;	
		$finished = false;
		while(!$finished)
		{
		
			?>
            <td class='col-1'><?=valorparaousuario_new($saldoinicial)?></td>
            <?
			$totais[0][$i] = $saldoinicial;
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
			
			$sql_positivo = "select sum(com_valormovimentado) from contasmovimentacao ";
			$sql_positivo .= " WHERE com_tipopagamento = 1 AND com_datamovimentacao BETWEEN '$ano-".($mes-1)."-1' AND '".dataparaobanco(ultimoDiaMes("01/".($mes-1)."/$ano"))."' ";
			$result = execute_query($sql_positivo);
			while($line = $result->fetchRow())
			{				
				$soma_positivo = $line[0];	
			}
				
			$sql_negativo = "select sum(com_valormovimentado) from contasmovimentacao ";
			$sql_negativo .= " WHERE com_tipopagamento = 2 AND com_datamovimentacao BETWEEN '$ano-".($mes-1)."-1' AND '".dataparaobanco(ultimoDiaMes("01/".($mes-1)."/$ano"))."' ";
			
			$result = execute_query($sql_negativo);
			while($line = $result->fetchRow())
			{				
				$soma_negativo = $line[0];	
			}
			$saldoperiodo = $soma_positivo - $soma_negativo;
			$saldoinicial  +=  $saldoperiodo;			
			
			
			
			
		}
		?>
		</tr>
        <tr>
        <td>Reserva de Caixa</td>
        <?
		
		$mes = $mesInicio;	
		$ano = $anoInicio;		
								
		$i = 0;	
		$finished = false;
		while(!$finished)
		{				
			?>
            <td class='col-1'><?=valorparaousuario_new($reserva)?> -</td>
            <?
			$totais[1][$i] = $reserva;
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
        <td>Saldo Reserva</td>
        <?
			for($i=0; $i<sizeof($totais[0]); $i++)
			{
				$saldo1 = $totais[0][$i] - $totais[1][$i];
				?>
                <td class='col-1'><?=valorparaousuario_new($saldo1)?></td>
                <?
                $totais[2][$i] = $saldo1;
			} 
		?>
        </tr> 
        <tr>
        <td>Receitas no Mês</td>
        
        <?
		
		$mes = $mesInicio;	
		$ano = $anoInicio;		
								
		$i = 0;	
		$finished = false;
		while(!$finished)
		{			
				
			$sql = "select sum(com_valormovimentado) from contasmovimentacao ";
			$sql .= " WHERE com_tipopagamento = 1 AND com_datamovimentacao BETWEEN '$ano-$mes-1' AND '".dataparaobanco(ultimoDiaMes("01/$mes/$ano"))."' ";			
			$result = execute_query($sql);
			while($line = $result->fetchRow())
			{				
				$receitas = $line[0];	
			}			
			?>
            <td class='col-1'><?=valorparaousuario_new($receitas)?> +</td>
            <?
			$totais[3][$i] = $receitas;
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
        <td>Saldo Receitas</td>
        <?
		
			for($i=0; $i<sizeof($totais[0]); $i++)
			{
				$saldo2 = $totais[2][$i] + $totais[3][$i];
				?>
                <td class='col-1'><?=valorparaousuario_new($saldo2)?></td>
                <?
                $totais[4][$i] = $saldo2;
			} 
		?>
        </tr> 
		<tr>        
        <td>Despesas no Mês</td>
        
        <?
		
		$mes = $mesInicio;	
		$ano = $anoInicio;		
								
		$i = 0;	
		$finished = false;
		while(!$finished)
		{			
				
			$sql = "select sum(com_valormovimentado) from contasmovimentacao ";
			$sql .= " WHERE com_tipopagamento = 2 AND com_datamovimentacao BETWEEN '$ano-$mes-1' AND '".dataparaobanco(ultimoDiaMes("01/$mes/$ano"))."' ";			
			$result = execute_query($sql);
			while($line = $result->fetchRow())
			{				
				$despesas = $line[0];	
			}			
			?>
            <td class='col-1'><?=valorparaousuario_new($despesas)?> -</td>
            <?
			$totais[5][$i] = $despesas;
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
        <td>Saldo Final</td>
        <? 
			for($i=0; $i<sizeof($totais[0]); $i++)
			{
				$saldo3 = $totais[4][$i] - $totais[5][$i];
				?>
                <td class='col-1'><?=valorparaousuario_new($saldo3)?></td>
                <?
                $totais[6][$i] = $saldo3;
			} 
		?>
        </tr>   
         
		
	</tbody>
	</table>
 
 </div>
 
</html>
