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
    <title>
      Relatório - Nexun Informática
    </title>
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
        Relatório de Receitas
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
echo "<script src='../../_javascript/wz_tooltip/wz_tooltip.js' type='text/javascript'></script>\n";
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
				
				<td class='col-1'>Total</td>					
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
		
		
		$sql = "SELECT cat_categoria, cat_descricao FROM categoriasdemovimentacao WHERE cat_grupo = 1";
		$resulato = Execute($conn, $sql);
		while($linha = $resulato->fetchRow())
		{				
			$codcategoria = $linha[0];
			$descricaocategoria = $linha[1];
			
			?>
			<tr class="<? echo $par; ?>">
				<td class='col-1'><?=$descricaocategoria?></td>
			<?
				
				for($i=$mesInicio; $i<=$mesFim; $i++)
				{
				
					$sql = "SELECT sum(flux_valor) FROM fluxodecaixa WHERE flux_categoriamovimentacao = ".$codcategoria." AND ".
					" flux_datavencimento BETWEEN '$ano-$i-1' AND '".dataparaobanco(ultimoDiaMes("01/$i/$ano"))."'";
											
					$result = Execute($conn, $sql);
					$line = $result->fetchRow();
									
					$subtotalcategoria = $line[0];	
									
					?>
					<td class='col-1'>
					
					<?
						echo "<font color='#0000FF'> ".valorparaousuario_new($subtotalcategoria)."</font>";
						$totalcategoria += $subtotalcategoria;
						$subtotais[$i-1] += $subtotalcategoria;
					?>
					
					</td>
					<?
				}			
			?>		
            <td class='col-1'><?=valorparaousuario_new($totalcategoria)?> </td>		
			</tr>
		<? 
		}
		?>	
		<tr>
		<td>&nbsp;</td>
		</tr>
		
		<tr>
			<td class='col-1'>Subtotal</td>
		<?
		$totalnoperiodo = 0;
		///SUBTOTAL NO PERÍODO///
		for($i=$mesInicio; $i<=$mesFim; $i++)
		{	
			
			$totalnoperiodo += $subtotais[$i-1];
			
				
			?>			
			<td class='col-1'><? echo valorparaousuario_new($subtotais[$i-1]); ?></td>
			<?
		}	
		?>
		</tr>	
        <tr>
		<td>&nbsp;</td>
		</tr>	
		<tr>
		<td>Total no Período:</td>		
        <td><? echo valorparaousuario_new($totalnoperiodo); ?></td>
		</tr>
        <tr>
		<td>&nbsp;</td>
		</tr>	
		<tr>
        <tr>
		<td>Média Mensal:</td>		
        <td><? 
				$media = $totalnoperiodo/sizeof($subtotais);
				echo valorparaousuario_new($media); ?></td>
		</tr>			
		
			
		
		
	</tbody>
	</table>
 
 </div>
 
</html>
