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
    <title>
      Relatório
    </title>
    <link rel='stylesheet' type='text/css' href='<?=$_CONF['realpath']?>/_css/impressao/orcamentos/print.css' />
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

      <img align='Nexun Informática' class='logo' src='<?=$_CONF['realpath']?>/_images/logo_.jpg' />
      <h2>
        Clientes por Produto
      </h2>
      <p class='codigo-data'>
        <strong id='caixa-codigo'>
          

        </strong>
        <strong id='caixa-data'>          
          <span id='data'>
            <? echo dataporextenso(); ?>
          </span>
        </strong>
      </p>
    </div>
    
<h4>Produto:<br />	
<?

$sql = "SELECT pro_nome, mar_nome FROM produtos INNER JOIN marcas ON mar_marca = pro_marca ";

if($_POST['produto'] != "null")
{
	$sql .= " WHERE pro_produto = ".$_POST['produto'];
}else{
	if($_POST['codbarras'])
	{
		$sql .= " WHERE pro_codbarras = ".$_POST['codbarras'];
	}
}
				
$resultado = execute_query($sql);	
while ($linha = $resultado->fetchRow()) 
{		 			
	$nomeproduto = $linha[0];
	$marcaproduto = $linha[1];
}
echo $marcaproduto." > ".$nomeproduto;
?>
</h4>
<div>
<form action='#' class='org_grid grid3' method='post'>
	<table>
		<thead>
			<tr>				
				<td class='col-2'>Cliente</td>
				<td class='col-1'>Data</td>
				<td class='col-3'>Qtde.</td>
			</tr>
		</thead>				
		<tbody> 		
		<?
			
		
		$sql = "SELECT pes_nome, sum(pedp_quantidade), ped_data FROM pedidosprodutos
				INNER JOIN produtos ON pro_produto = pedp_produto
				INNER JOIN pedidos ON ped_pedido = pedp_pedido
				INNER JOIN pessoas ON pes_pessoa = ped_cliente ";
				
		if($_POST['produto'] != "null")
		{
			$sql .= " WHERE pro_produto = ".$_POST['produto'];
		}else{
			if($_POST['codbarras'])
			{
				$sql .= " WHERE pro_codbarras = ".$_POST['codbarras'];
			}
		}
		
		$sql .= " GROUP BY pes_nome ORDER BY ped_data ".$_POST['ordem'];
			
		$resultado = execute_query($sql);			
		$x = 0;
		while ($linha = $resultado->fetchRow()) 
		{		 			
			 
			  $cliente  = $linha[0];			  
			  $qtde = $linha[1];
			  $data = $linha[2];
			  
			  $data = dataparaousuario($data);
			  	 
			  $total += $qtde; 
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
			<td class='col-3'><? echo $cliente; ?> </td>
			<td class='col-1'><? echo $data; ?> </td>
			<td class='col-4'><? echo $qtde; ?> </td>	
		</tr>		
		<?		
		}
		$resultado->free();
		
		?>
		<tr class="<? echo $par; ?>">			
			<td></td>
			<td class='col-3'>Total: </td>
			<td class='col-4'><b><? echo $total; ?></b></td>	
		</tr>	
		</tbody>		
	</table>
</form>
</div>