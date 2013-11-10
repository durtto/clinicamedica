<?
session_start();
require_once("../../_funcoes/funcoes.php");


$codpedido = $_GET['cod'];

$sql = "SELECT ped_pedido, ped_cliente, ped_data, ped_formapagto, ped_valortotal, cli_endereco, pes_nome, ped_valortotal, ped_descricao, ped_condicao ". 
		"FROM pedidos INNER JOIN pessoas ON pes_pessoa = ped_cliente INNER JOIN clientes ON ped_cliente = cli_cliente INNER JOIN enderecos ON end_endereco = cli_endereco WHERE ped_pedido = '$codpedido'";	
		
$resultado = execute_query($sql);
while ($linha = $resultado->fetchRow()) 
{		 			
	$codpedido = $linha[0];	
	$cod_cliente = $linha[1];
	$data = $linha[2];
	$formapagto = $linha[3];	
	$valor_total = $linha[4];
	$cod_endereco = $linha[5];
	$nome_cliente = $linha[6];
	$valortotalorcamento = $linha[7];
	$descricao = $linha[8];
	$condicao = $linha[9];
	
	$valor_total = valorparaousuario_new($valor_total);
	$valortotalorcamento = valorparaousuario_new($valortotalorcamento);
	$data = dataparaousuario($data);		 
}
$sql = "SELECT	end_endereco, end_cep, end_logradouro, end_numero, end_complemento, end_bairro ". 
				"FROM	enderecos ". 						
				"WHERE end_endereco = '$cod_endereco'";	
					
$resultado = execute_query($sql);			
while ($linha = $resultado->fetchRow()) 
{		 			
		  $cod_endereco  = $linha[0];
		  $cep  = $linha[1];
		  $logradouro  = $linha[2];
		  $numero  = $linha[3];
		  $complemento  = $linha[4];			  
		  $bairro  = $linha[5];			 		  		 			
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns='http://www.w3.org/1999/xhtml'>
  <head>
    <meta content='text/html; charset=iso-8859-1' http-equiv='Content-Type' />
    <title>
      Pedido - Nexun
    </title>
    <link rel='stylesheet' type='text/css' href='../../_css/impressao/orcamentos/print.css' />
	<? 
	require_once("../../componentes/realpath.php");
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
	echo "<script src='../../_javascript/impressao/impressao-pedido.js' type='text/javascript'></script>\n";
	?>
  </head>
  <body>
    <div id='cabecalho'>
      <img align='NEXUN' class='logo' src='../../_images/logo_.jpg' />
      <h2>
        Pedido 
      </h2>
      <p class='codigo-data'>            
		Pedido nº: &nbsp;<b><?=$cod_orcamento?></b><br />	  
       <? echo dataporextenso(); ?> 
      </p>
    </div>
	<br />
	<div id='dados-gerais'>	
		  <table>
			<tr>          
			  <td id="orcliente">			  
			  <div><fieldset id="teste"><b>
			   <?
			   echo $nome_cliente;									  
		       ?>
			   </b><br />		  
			  <input type="hidden" name="cep" id="cep" value="<?=$cep?>"	/>			
			   <?=$logradouro.", ".$numero?> - <?=$bairro?> CEP: <?=$cep?><br />	
			   </fieldset>		  
				</div>
				<div id="cid-estado">
			   
			   
		 	   </div>    
			  </td>         
			</tr>	
			<tr>          
			  <td id="orcliente">				
			   <div><fieldset id="teste">
			   <?
			   echo $descricao;									  
		       ?>		
			   </fieldset></div>	   
			  </td>         
			</tr>				
		  </table>
	</div>
	<?
	
	?>	
	<div class="grid3">
	<p><h3>Produtos</h3></p>	
	<table id="tabela">
		<thead>
		  <tr>				
			<td class="col-1">Produto</td>
			<td class="col-2">Valor</td>
			<td class="col-3">Qtde.</td>	
			<td class="col-3">Subtotal</td>									
		  </tr>
		</thead>
		<tbody>	
		<?
		$sql = "SELECT pedp_produto, pedp_quantidade, pedp_subtotal, pro_unidade, pedp_valorunitario ". 
			"FROM pedidosprodutos INNER JOIN produtos ON pro_produto = pedp_produto WHERE pedp_pedido = $codpedido";		
	
		$resultado = execute_query($sql);
		$i = 0;

		while($linha = $resultado->fetchRow()) 
		{		 			
			$cod_produto  = $linha[0];
			$qtd  = $linha[1];
			$subtotal  = $linha[2];
			$unidade = $linha[3];
			$valor_produto = $linha[4];
			
			$sql = "SELECT pro_nome, pro_valorvenda ". 
			"FROM produtos WHERE pro_produto = $cod_produto";	
			$resultado1 = execute_query($sql);
			$linha = $resultado1->fetchRow();
			$nome_produto = $linha[0];
			//$valor_produto = $linha[1];
			$valor_produto = valorparaousuario_new($valor_produto);
			$subtotal = valorparaousuario_new($subtotal);
		?>
		<tr>		  
			<td class="col-1">
				<?=$nome_produto?>
			</td>
			<td class="col-2">
				<? echo $valor_produto."/".$unidade?>			
			</td>
			<td class="col-3"><? echo $qtd." ".$unidade?>
			</td>
			<td class="col-4">
				<?=$subtotal?>
			</td>
		</tr>
		<?
		}
		?>
		</tbody>			
	<tfoot>
	<tr>
		<td class="col-1"></td>
		<td class="col-2"></td>
		<td class="col-3">Total: </td>	
		<td class="col-4">R$ <?=$valortotalorcamento?></td>	
	</tr>	
 </tfoot>
</table>	
		<p><h4>Condição de Pagamento</h4></p>	
		<table id="tabela">
		<thead>
		  <tr>			
			<td class="col-1">Condição</td>				
			<td class="col-2">Forma pagto.</td>				
			<td class="col-3">Valor</td>			
			<td class="col-4">Total</td>				
		  </tr>
		</thead>
		<tbody>	
		
			<tr class="<? echo $par; ?>">				
				<td class='col-1'>
				<?
					$sql = "SELECT con_condicao, con_descricao FROM condicoespagamento WHERE con_condicao = $condicao";	
							
					$resultado = execute_query($sql);
					while ($linha = $resultado->fetchRow()) 
					{		 			
						  $cod_condicao  = $linha[0];
						  $descricao  = $linha[1];
					}
					echo $descricao;
				?></td>
				<td class='col-2'>
				<?
				$sql = "SELECT form_formapagto, form_descricao ". 
				"FROM formaspagamento where form_formapagto = $formapagto";				
				$resultado1 = execute_query($sql);
				while($linha2 = $resultado1->fetchRow())
				{
					$for_forma = $linha2[0];
					$for_descricao = $linha2[1];	
				}
				echo $for_descricao;
					
				?></td>				
				<td class='col-3'><? 
					$valor_parcelas = $valor_total;
					if($condicoes[$i] == 2)
					{
						$valor_parcelas = str_replace(".","", $valor_parcelas);
						$valor_parcelas = str_replace(",",".", $valor_parcelas);
						$valor_parcelas = ($valor_parcelas/$qtdparcelas[$i]);
						$valor_parcelas = valorparaousuario_new($valor_parcelas);
						
						echo $qtdparcelas[$i]." x R$ ".$valor_parcelas;
					}else{
					echo "R$ $valor_parcelas";
					}
				?></td>					
				<td class='col-4'><?
				
					echo "R$ <b>$valor_total</b>";
					
				?></td>						
			</tr>
			
		</tbody>	
		</table>
		
		<p><h4>Detalhes do Pagamento</h4></p>	
		<table id="tabela">
		<thead>
		  <tr>			
			<td class="col-1">Parcela</td>				
			<td class="col-2">Vencimento</td>				
			<td class="col-3">Valor</td>			
		  </tr>
		</thead>
		<tbody>	
		<?
		$sql = "select flux_codigo, flux_parcela, flux_datavencimento, flux_formapagamento, flux_valor from fluxodecaixa where flux_codpedido = $codpedido";
		$resultado = execute_query($sql);
		
		while ($linha = $resultado->fetchRow()) 
		{	
			$cod_pedido = $linha[0];
			$parcela = $linha[1];
			$datavencimento = $linha[2];
			$formapagto = $linha[3];		
			$valorparcela = $linha[4];
		?>
			<tr class="<? echo $par; ?>">				
				<td class='col-1'>
				<?					
					echo $parcela;
				?></td>
						
				<td class='col-2'><? 
					$datavencimento = dataparaousuario($datavencimento);
					echo $datavencimento;
				?></td>					
				<td class='col-3'><?					
					$valorparcela = valorparaousuario_new($valorparcela);					
					echo "R$ $valorparcela";					
				?></td>						
			</tr>
			<?
			}
			?>
		</tbody>	
		</table>	
	</div>		
	</body>
</html>


	  
	  
	  
	  
	  
	  
	  
	  
	  
	  
	  
	  

	
