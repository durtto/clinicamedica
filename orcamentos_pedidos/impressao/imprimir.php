<?
session_start();
require_once("../../_funcoes/funcoes.php");
echo "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html id='financeiro-listagem' class='pauta' xmlns='http://www.w3.org/1999/xhtml'>";
include("../../componentes/head.php");
echo "</head>";
?>


<div style="width:680px">
	<li style="font-size:12px; font-weight:normal;">
		<div align="right">
		  <?=dataporextenso()?>
	      </div>
	</li> 
	<p style="font-size:14px; font-weight:bold">
		Relatório de Pedidos
	</p> 
	
</div>

<div>
<form action='#' class='org_grid grid3' method='post'>
	<table>
		<thead>
			<tr>
				<td class='col-1'>Cód.</td>
				<td class='col-2'>Cliente</td>
				<td class='col-3'>Forma pagto.</td>
				<td class='col-4'>Data</td>
				<td class='col-5'>Total</td>				
				<td class='col-6'>Responsável</td>			
		<tbody>
		<?
			
		
		$sql = $_SESSION['pedidos-report'];		
		
		$resultado = execute_query($sql);			
		$x = 0;
		while ($linha = $resultado->fetchRow()) 
		{		 			
			  $cod_pedido  = $linha[0];
				  $nome_cliente  = $linha[1];
				  $formapagto  = $linha[2];
				  $data  = $linha[3];
				  $valor_total  = $linha[4];  
				  $cod_responsavel = $linha[5];
				
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
				<td class='col-3'><? echo $for_descricao; ?> </td>
				<td class='col-4'><? echo $data; ?> </td>			
				<td class='col-5'><? echo $valor_total; ?></td>
				<td class='col-6'><? echo $nome_usuario; ?></td>			
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