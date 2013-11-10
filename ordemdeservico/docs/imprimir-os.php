<?
session_start();
require_once("../../_funcoes/funcoes.php");

$cod = $_GET['cod'];

$sql =			"SELECT ".
				" ord_ordemdeservico, pes_nome, ord_responsavel, sit_nome, ord_defeito, ord_dataentrada, ord_datasaida, ord_valor, ord_equipamento, ord_observacoes, cli_endereco ".				
				" FROM ordensdeservico INNER JOIN pessoas ON pes_pessoa = ord_cliente INNER JOIN situacoes ON sit_situacao = ord_situacao INNER JOIN clientes ON ord_cliente = cli_cliente INNER JOIN enderecos ON end_endereco = cli_endereco WHERE ord_ordemdeservico = $cod";
			
	$resultado = execute_query($sql);
	while ($linha = $resultado->fetchRow()) 
	{		 			
		  $codos  = $linha[0];
		  $nome_cliente  = $linha[1];
		  $cod_responsavel  = $linha[2];
		  $situacao  = $linha[3];
		  $defeito  = $linha[4];  
		  $dataentrada = $linha[5];
		  $datasaida = $linha[6];
		  $total = $linha[7];
		  $equipamento = $linha[8];
		  $observacoes = $linha[9];
		  $cod_endereco = $linha[10];
	}			
		  $total = valorparaousuario_new($total);
		  $dataentrada = dataparaousuario($dataentrada);
		  if($datasaida != '')
		  {
		  	$datasaida = dataparaousuario($datasaida);
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
      Ordem de Serviço - Nexun
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
        Ordem de Serviço
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
			  <div><fieldset id="teste">
			  <strong>Cliente:</strong><br />
			 
			   <?
			   echo $nome_cliente;									  
		       ?>
			   <br />		  
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
			   <br /><strong>Equipamento:</strong>
			   <?
			   echo $equipamento;
			   ?><br><br>
			  <strong> Defeito:</strong>
			  <b> <?
			   echo $defeito;									  
		       ?></b>
			   		
			   </fieldset></div>	   
			  </td>         
			</tr>				
		  </table>
	</div>
	<?
	$sql = "SELECT orde_produto, orde_quantidade, orde_subtotal, orde_valorunitario ". 
		"FROM ordensprodutos WHERE orde_ordemdeservico = $codos";		
	$resultado = execute_query($sql);
	if($resultado -> numRows($sql) > 0)
	{
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
		
		$i = 0;

		while($linha = $resultado->fetchRow()) 
		{		 			
			$cod_produto  = $linha[0];
			$qtd  = $linha[1];
			$subtotal  = $linha[2];
			$valor_produto = $linha[3];
			
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
				<? echo $valor_produto?>			
			</td>
			<td class="col-3"><? echo $qtd?>
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
		<td class="col-4">R$ <b><?=$total?></b></td>	
	</tr>	
 </tfoot>
</table>
</div>	
<?
}
?>					
<div id='dados-gerais'>
	 <p style="font-size:11px">
		Observações:
   <?
   echo $observacoes;									  
   ?>	
	</p>
	 	<br />  
	
	</div>	
	</body>
</html>


	  
	  
	  
	  
	  
	  
	  
	  
	  
	  
	  
	  

	
