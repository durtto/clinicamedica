<?
session_start();
require_once("../../_funcoes/funcoes.php");
echo "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html id='financeiro-listagem' class='pauta' xmlns='http://www.w3.org/1999/xhtml'>";
include("../../componentes/head.php");
echo "</head>";
?>
<body>

<div style="width:680px">
	<li style="font-size:12px; font-weight:normal;">
		<div align="right">
		  <?=dataporextenso()?>
	      </div>
	</li> 
	<p style="font-size:14px; font-weight:bold">
		Relatório de Produtos 
	</p> 
	
</div>

<div>
<form action='#' class='org_grid grid3' method='post'>
	<table>
		<thead>
			<tr>
				<td class='col-1'>Nome</td>				
				<td class='col-3'>Categoria</td>
				<td class='col-2'>Marca</td>
				<td class='col-3'>Qtde.</td>
				<td class='col-4'>Valor</td>	
		<tbody>
		<?
			
		
		$sql = $_SESSION['estoque-report'];		
		
		$resultado = execute_query($sql);			
		$x = 0;
		while ($linha = $resultado->fetchRow()) 
		{		 			
			  $cod_produto  = $linha[0];
			  $nome_produto  = $linha[1];
			  $descricao  = $linha[2];
			  $qtde  = $linha[3];
			  $unidade = $linha[4];
			  $valor  = $linha[5];	
			  $nome_marca = $linha[6];	
			  $nome_categoria = $linha[7];	  	
			  $valor = valorparaousuario_new($valor);			 
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
			 if(strlen($descricao)>80)
			 {
			 	$descricao = substr($descricao,0,80)."...";
			 }
		 
		 $x = $x+1;	 
				
		?>
		<tr class="<? echo $par; ?>">
			<td class='col-1'><? echo $nome_produto; ?> </td>			
			<td class='col-3'><? echo $nome_categoria; ?> </td>
			<td class='col-2'><? echo $nome_marca; ?> </td>
			<td class='col-3'><? echo $qtde.$unidade; ?> </td>
			<td class='col-4'><? echo $valor; ?> </td>	
		</tr>		
		<?		
		}
		$resultado->free();
		
		?>
		</tbody>		
	</table>
</form>
</div>

</body>
</html>	