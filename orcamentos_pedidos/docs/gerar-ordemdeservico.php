<?
session_start();
require_once("../../_funcoes/funcoes.php");


$cod_orcamento = $_GET['cod'];

$sql = "SELECT orc_orcamento, orc_cliente, ped_data, ped_formapagto, ped_valortotal, cli_endereco, pes_nome, orc_total, orc_descricao ". 
		"FROM orcamentos INNER JOIN pessoas ON pes_pessoa = orc_cliente INNER JOIN clientes ON orc_cliente = cli_cliente INNER JOIN pedidos ON ped_pedido = orc_orcamento INNER JOIN enderecos ON end_endereco = cli_endereco WHERE orc_orcamento = '$cod_orcamento'";	
		
$resultado = execute_query($sql);
while ($linha = $resultado->fetchRow()) 
{		 			
	$cod_orcamento = $linha[0];	
	$cod_cliente = $linha[1];
	$data = $linha[2];
	$formapagto = $linha[3];	
	$valor_total = $linha[4];
	$cod_endereco = $linha[5];
	$nome_cliente = $linha[6];
	$valortotalorcamento = $linha[7];
	$descricao = $linha[8];
	
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
      Pedido - DecorCasa
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
      <img align='DecorCasa' class='logo' src='../../_images/logo_.jpg' />
      <h2>
        Ordem de Serviço 
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
	<p>Início	____________________________ &nbsp;&nbsp;&nbsp; Término 	____________________________</p>
	<p>Executor ___________________________</p>
            
	
	<p><h3>Produtos</h3></p>	
	<table id="tabela">
		<thead>
		  <tr>				
			<td class="col-1">Produto</td>
			<td class="col-2">Quantidade</td>
			<td class="col-3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>	
			<td class="col-3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>									
		  </tr>
		</thead>
		<tbody>	
		<?
		$sql = "SELECT orcpro_produto, orcpro_quantidade, orcpro_subtotal, pro_unidade ". 
			"FROM orcamentos_produtos INNER JOIN produtos ON pro_produto = orcpro_produto WHERE orcpro_orcamento = $cod_orcamento";		
	
		$resultado = execute_query($sql);
		$i = 0;

		while($linha = $resultado->fetchRow()) 
		{		 			
			$cod_produto  = $linha[0];
			$qtd  = $linha[1];
			$subtotal  = $linha[2];
			$unidade = $linha[3];
			
			$sql = "SELECT pro_nome, pro_valorvenda ". 
			"FROM produtos WHERE pro_produto = $cod_produto";	
			$resultado1 = execute_query($sql);
			$linha = $resultado1->fetchRow();
			$nome_produto = $linha[0];
			$valor_produto = $linha[1];
			$valor_produto = valorparaousuario_new($valor_produto);
			$subtotal = valorparaousuario_new($subtotal);
		?>
		<tr>		  
			<td class="col-1">
				<?=$nome_produto?>
			</td>
			<td class="col-2">
				<? echo $qtd." ".$unidade?>	
			</td>
			<td class="col-3">
			</td>
			<td class="col-4">
				
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
		<td class="col-3"> </td>	
		<td class="col-4"></td>	
	</tr>	
 </tfoot>
</table>
<p>Obs. do Cliente:</p>
<p>____________________________________________________________________________________________<br /><br />
____________________________________________________________________________________________<br /><br />
____________________________________________________________________________________________</p>
<p><br />________________________________<br />
	Visto Cliente</p>
	
	</div>		
	</body>
</html>


	  
	  
	  
	  
	  
	  
	  
	  
	  
	  
	  
	  

	
