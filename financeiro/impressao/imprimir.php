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
		Relatório Financeiro - Contas à Receber 
	</p> 
	
</div>

<div>
<form action='#' class='org_grid grid3' method='post'>
	<table>
		<thead>
			<tr>
				<td class='col-1'>Pedido</td>
				<td class='col-2'>Cliente</td>
				<td class='col-3'>Tipo de Conta</td>
				<td class='col-4'>Forma pagto.</td>
				<td class='col-5'>Parcela</td>
				<td class='col-6'>Valor</td>
				<td class='col-7'>Vencimento</td>				
				<td class='col-8'>Pagamento</td>		
		<tbody>
		<?
			
		
		$sql = $_SESSION['financeiro-report'];		
		
		$resultado = execute_query($sql);			
		$x = 0;
		while ($linha = $resultado->fetchRow()) 
		{		 			
			   $cod_conta  = $linha[0];
				$cod_pedido  = $linha[1];
				$parcela  = $linha[2];
				$datavencimento  = $linha[3];
				$datapagamento  = $linha[4];  
				$formapagto = $linha[5];
				$valor = $linha[6];
				$tipoconta = $linha[7];
				$nome_cliente = $linha[8];
				
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
			$sql = "SELECT tip_tipoconta, tip_descricao ". 
					"FROM tiposdeconta where tip_tipoconta = $tipoconta";				
				$resultado1 = execute_query($sql);
				while($linha2 = $resultado1->fetchRow())
				{
					$tipo = $linha2[0];
					$tipoconta_descricao = $linha2[1];	
				}			  
				$sql = "SELECT form_formapagto, form_descricao ". 
					"FROM formaspagamento where form_formapagto = $formapagto";				
				$resultado2 = execute_query($sql);
				while($linha2 = $resultado2->fetchRow())
				{
					$for_forma = $linha2[0];
					$for_descricao = $linha2[1];	
				}
				
				$sql = "SELECT ocon_qtdparcelas ". 
		"FROM orcamentoscondicoespagamento WHERE ocon_orcamento = $cod_pedido AND ocon_estahaprovado = 's'";		
				
				$resultado3 = execute_query($sql);				
				while ($linha = $resultado3->fetchRow()) 
				{		 								
					$qtdparcelas  = $linha[0];	
		
				}					
		 
		 $x = $x+1;	 
				
		?>
		<tr class="<? echo $par; ?>">
			<td class='col-1'><? echo $cod_pedido; ?> </td>
				<td class='col-2'><? echo $nome_cliente; ?> </td>
				<td class='col-3'><? echo $tipoconta_descricao; ?> </td>
				<td class='col-4'><? echo $for_descricao; ?> </td>			
				<td class='col-5'><?  if($qtdparcelas == "")
									  {
										echo "única";
										
									  }
									  else
									  {
										echo "<b>$parcela</b> de $qtdparcelas";
									  } 
				?></td>
				<td class='col-6'><? echo $valor; ?></td>					
				<td class='col-6'><? echo $datavencimento; ?></td>					
				<td class='col-6'><? echo $datapagamento; ?></td>			
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