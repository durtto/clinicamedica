<?
session_start();
require_once("../../_funcoes/funcoes.php");

$cod_orcamento = $_GET['cod'];

$sql = "SELECT orc_orcamento, orc_descricao, pes_nome, orc_data, orc_total, orc_situacao, orc_responsavel, cli_endereco ". 
		"FROM orcamentos INNER JOIN pessoas ON pes_pessoa = orc_cliente INNER JOIN clientes ON orc_cliente = cli_cliente INNER JOIN enderecos ON end_endereco = cli_endereco WHERE orc_orcamento = '$cod_orcamento'";
	
$resultado = execute_query($sql);
while ($linha = $resultado->fetchRow()) 
{		 			
	$cod_orcamento  = $linha[0];
	$descricao  = $linha[1];
	$nome_cliente  = $linha[2];
	$data  = $linha[3];
	$valor_total  = $linha[4];
	$situacao = $linha[5];	
	$cod_usuario = $linha[6];
	$cod_endereco = $linha[7];
	
	$valor_total = valorparaousuario_new($valor_total);
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
      Or&ccedil;amento - Nexun
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
        Orçamento
      </h2>
      <p class='codigo-data'>            
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
		$sql = "SELECT orcpro_produto, orcpro_quantidade, orcpro_subtotal, pro_unidade, orcpro_valorunitario ". 
			"FROM orcamentos_produtos INNER JOIN produtos ON pro_produto = orcpro_produto WHERE orcpro_orcamento = $cod_orcamento";		
	
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
		<td class="col-3"><strong>Total:</strong> </td>	
		<td class="col-4">R$ <b><?=$valor_total?></b></td>	
	</tr>	
 </tfoot>
</table>
				
		<?		
		
		
		$sql = "SELECT ocon_condicaopagamento, ocon_qtdparcelas, ocon_desconto ". 
		"FROM orcamentoscondicoespagamento WHERE ocon_orcamento = $cod_orcamento";		

		$resultado = execute_query($sql);
		$i = 0;
		while ($linha = $resultado->fetchRow()) 
		{		 			
			$condicoes[$i]  = $linha[0];
			$qtdparcelas[$i]  = $linha[1];
			$desconto[$i]  = $linha[2];
			$i++;
		}	
		?>	
		<p><h4>Condições de Pagamento</h4></p>	
		<table id="tabela">
		<thead>
		  <tr>			
			<td class="col-1">Condição</td>				
			<td class="col-2">Desconto</td>				
			<td class="col-3">Valor</td>			
			<td class="col-4">Total</td>				
		  </tr>
		</thead>
		<tbody>	
		<?
		for($i=0;$i<sizeof($condicoes);$i++)
		{
		?>
			<tr class="<? echo $par; ?>">				
				<td class='col-1'>
				<?
					$sql = "SELECT con_condicao, con_descricao FROM condicoespagamento WHERE con_condicao = $condicoes[$i]";				
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
					if($condicoes[$i] == 1)
					{
						echo $desconto[$i]."%";
					}else{
						echo "-";
					}
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
					}else if($condicoes[$i] == 3)
					{
						$juro = 2.5;
						$valor_juro = (valorparaobanco($valor_total) * $juro/100);
						$valor_parcelas = str_replace(".","", $valor_parcelas);
						$valor_parcelas = str_replace(",",".", $valor_parcelas);
						$valor_parcelas = ($valor_parcelas/$qtdparcelas[$i]);
						$valor_parcelas = $valor_parcelas + $valor_juro;
						$valor_parcelas = valorparaousuario_new($valor_parcelas);
						
						echo $qtdparcelas[$i]." x R$ ".$valor_parcelas;
					}else{
						echo "R$ $valor_parcelas";
					}
				?></td>					
				<td class='col-4'><?
					$valoraux = $valor_total;
					if($condicoes[$i] == 1)
					{
						$valoraux = str_replace(".","", $valoraux);
						$valoraux = str_replace(",",".", $valoraux);
						$valoraux = $valoraux - ($valoraux*($desconto[$i]/100));
						$valoraux = valorparaousuario_new($valoraux);
					}else if($condicoes[$i] == 3)
					{						
						$valoraux = $qtdparcelas[$i] * valorparaobanco($valor_parcelas);
						$valoraux = valorparaousuario_new($valoraux);
					}
					echo "R$ <b>$valoraux</b>";
					
				?></td>						
			</tr>
			<?
			}
			?>
		</tbody>	
		</table>
	
	</div>	
	 <div id='dados-gerais'>
	 <p style="font-size:9px">
		Validade deste orçamento: 10 dias
	</p>
	 	<br />  
	 <p class='entrega'>
		Atenciosamente,
	</p>	
	<p class='entrega'>
<?
	$sql = "SELECT	usu_usuario, pes_nome, usu_login ". 
	"FROM	usuarios ". 
	"INNER JOIN pessoas ".
	"ON usu_usuario = pes_pessoa WHERE usu_usuario = $cod_usuario";								
	$resultado = execute_query($sql);				
	while ($linha = $resultado->fetchRow()) 
	{		 			
		  $cod_usuario  = $linha[0];
		  $nome_usuario  = $linha[1];					 			  	
		  $login  = $linha[3];						  
	}
	echo $nome_usuario; 
?>		<br />
			Nexun Informática</p>
	</div>	
	</body>
</html>


	  
	  
	  
	  
	  
	  
	  
	  
	  
	  
	  
	  

	
