<?
session_start();
require_once("../_funcoes/funcoes.php");
include("../componentes/head.php");
echo "<script src='../_javascript/edicao-de-orcamentos/Second.js' type='text/javascript'></script>\n";
echo "</head>";
echo "<body>";

include("../componentes/cabecalho.php");
$cod_orcamento = $_GET['cod'];
?>

<div id="menu-secao">
	<li>
		<a href="../_funcoes/controller.php?opcao=home-orcamentos" class="pedidos">Orçamentos & Pedidos</a>
		Pedidos > Edição
	</li>
</div>

<div id="sub-menu">	
	<li>
		<a href="../_funcoes/controller.php?opcao=home-pedidos">Listagem de Vendas</a>
	</li>
</div>
<?
$sql = "SELECT orc_orcamento, orc_descricao, orc_cliente, orc_data, orc_total, orc_situacao ". 
		"FROM orcamentos WHERE orc_orcamento = '$cod_orcamento'";		
$resultado = execute_query($sql);
while ($linha = $resultado->fetchRow()) 
{		 			
	$cod_orcamento  = $linha[0];
	$descricao  = $linha[1];
	$cliente  = $linha[2];
	$dataorcamento  = $linha[3];
	$valor_total  = $linha[4];
	$situacao = $linha[5];	
	
	$valor_total = valorparaousuario_new($valor_total);
	$dataorcamento = dataparaousuario($dataorcamento);		 
}
$sql = "SELECT ocon_condicaopagamento, ocon_qtdparcelas, ocon_desconto ". 
		"FROM orcamentoscondicoespagamento WHERE ocon_orcamento = $cod_orcamento AND ocon_estahaprovado = 's'";
		//echo $sql;		

$resultado = execute_query($sql);
$i = 0;
while ($linha = $resultado->fetchRow()) 
{		 			
	$condicao  = $linha[0];
	$qtdparcelas  = $linha[1];
	$desconto  = $linha[2];
	$i++;
}
$sql = "SELECT ped_pedido, pes_nome, ped_formapagto, ped_data, ped_valortotal, ped_intervalo, ped_diasapos, orc_total, ped_parceiro ". 
			"FROM orcamentos INNER JOIN pessoas ON pes_pessoa = orc_cliente INNER JOIN pedidos ON ped_pedido = orc_orcamento WHERE ped_pedido = '$cod_orcamento'";	
		
	$resultado = execute_query($sql);
	$x = 0;
	while ($linha = $resultado->fetchRow()) 
	{		 			
		  $cod_pedido  = $linha[0];
		  $nome_cliente  = $linha[1];
		  $formapagto  = $linha[2];
		  $datapedido  = $linha[3];
		  $valor_total  = $linha[4];  
		  $intervalo = $linha[5];
		  $diasapos = $linha[6];
		  $valortotalorcamento = $linha[7];
		  $parceiro = $linha[8];
		
		  $valor_total = valorparaousuario_new($valor_total);
		  $valortotalorcamento = valorparaousuario_new($valortotalorcamento);
		  $datapedido = dataparaousuario($datapedido);
	}
$sql = "SELECT flux_datavencimento, flux_valor ". 
			"FROM fluxodecaixa WHERE flux_codigo = '$cod_orcamento' AND flux_parcela = 1";	
			
$resultado = execute_query($sql);
$x = 0;
while ($linha = $resultado->fetchRow()) 
{		 			
	  $data_vencimento  = $linha[0];
	  $valor_entrada  = $linha[1];
			
	  $valor_entrada = valorparaousuario_new($valor_entrada);
	  $dataentrada = dataparaousuario($data_vencimento);
}
?>
<form id="form-funcionarios" name="form-funcionarios" class="form-auto-validated" action="./update-pedido.php" method="post" enctype="multipart/form-data">
<input type="hidden" name="cod" value="<?=$cod_pedido?>"/>
<input type="hidden" name="total" value="<?=$valortotalorcamento?>"/>
<input type="hidden" name="datapedido" value="<?=$datapedido?>"/>
<h3>
	Pedido
</h3>     
        <fieldset>
        <fieldset>		         
          <fieldset class='cliente onsubmit:notnull'>
            <label for='cliente'>
              Cliente
            </label>
            <select id='cliente' name='cliente' class='onsubmit:notnull' disabled="disabled">
             <option value='null'>
                Selecione um cliente
              </option>
			<?		
				$sql = "SELECT cli_cliente, pes_nome ". 
				"FROM clientes ".				
				"INNER JOIN ".
				"pessoas ON cli_cliente = pes_pessoa ".							
				"ORDER BY pes_nome";			
				$resultado = execute_query($sql);
				while ($linha = $resultado->fetchRow()) 
				{		 			
					  $cod_cliente  = $linha[0];
					  $nome_cliente  = $linha[1];	
					if($cod_cliente == $cliente)
					{
						$selected = "selected";
					}else{ $selected = ""; }				
			?>	
				 <option value='<? echo $cod_cliente;?>' <?=$selected?>>
				 <? echo $nome_cliente;?> 
				 </option> 
			<?		  
				}				
			?>      
            </select>           
          </fieldset> 
		  </fieldset>		 
		</fieldset>
<?
$sql = "SELECT pedp_produto, pedp_quantidade, pedp_subtotal, pedp_valorunitario ". 
		"FROM pedidosprodutos WHERE pedp_pedido = $cod_pedido";		
//echo $sql;
$resultado = execute_query($sql);
if($resultado -> numRows($sql) > 0)
{
?>	
<div class='org_grid grid4'>
  <table id="tabela">
	<thead>
	  <tr>
		<td class="ckecks" width="20px">
		 </td>
		<td class="col-1">Produto</td>
		<td class="col-2">Valor</td>
		<td class="col-3">Qtde.</td>	
		<td class="col-3">Subtotal</td>	
	  </tr>
	</thead>
	<tbody>
	<?
	
	$i = 0;
	while ($linha = $resultado->fetchRow()) 
	{		 			
		$cod_produto  = $linha[0];
		$qtd  = $linha[1];
		$subtotal  = $linha[2];
		$valor_produto = $linha[3];
		
		$sql = "SELECT pro_nome, pro_valorvenda, pro_unidade ". 
		"FROM produtos WHERE pro_produto = $cod_produto";	
		$resultado1 = execute_query($sql);
		$linha = $resultado1->fetchRow();
		$nome_produto = $linha[0];
		//$valor_produto = $linha[1];
		$unidade = $linha[2];
		$valor_produto = valorparaousuario_new($valor_produto);
		$subtotal = valorparaousuario_new($subtotal);
	?>
    <tr>
      <td class="par"><input name='produto[]' value='<?=$cod_produto?>' class='checkbox to_check_checkAll' type='checkbox'>
	  <input name='produto_[]' value='<?=$cod_produto?>' type='hidden'>
	  </td>
	    <td class="col-1">
	  	<?=$nome_produto?>
		</td>
	  	<td class="col-2">
	  	<input name='valor[]' id='<?=$cod_produto?>' value='<?=$valor_produto?>' type='text' class='onsubmit:notnull input moeda'>/<?=$unidade?>
		</td>
		<td class="col-3">
		<input name='quantidade[]' id='<?=$cod_produto?>' value='<?=$qtd?>' class='onsubmit:notnull input' type='text'>
		</td>
		<td class="col-4">
		<input name='subtotal[]' id='<?=$cod_produto?>' value='<?=$subtotal?>' class='onsubmit:notnull input' type='text'>
		</td>
    </tr>
	<?
	}
	?>
 	</tbody>
	<tfoot>
	<tr>
		<td>		  
		</td>
		<td class="col-1"></td>
		<td class="col-2"></td>
		<td class="col-3">Total: </td>	
		<td class="col-4"><input name='total' id='total' class='onsubmit:notnull input' type='text' value="<?=$valor_total?>"></td>	
	</tr>
	<tr>
	<td colspan="9">		
	  <input value="Excluir" class="bt org-grid" id="excluir-produto" type="button">
	  </td>
	 </tr>
 </tfoot>
</table>
</div>
<?
}
?>

<fieldset>		 
<fieldset>
	<legend>
	 Condições de Pagamento
	</legend>	
	<fieldset class='onsubmit:notnull'>
	<?		
			$sql = "SELECT con_condicao, con_descricao FROM condicoespagamento";				
			$resultado = execute_query($sql);
			while ($linha = $resultado->fetchRow()) 
			{		 			
				  $cod_condicao  = $linha[0];
				  $descricao  = $linha[1];
				  if($cod_condicao == $condicao)
				  {
				  	$checked = "checked";
				  }else{ $checked = "";}			 		 
			?>	
			
		  <fieldset class='condPagamento'>
			<label class='condPagamento'>		
			  
			  <input type="radio" id='condicao' name='condicao' class="onsubmit:notnull radio" value="<?= $cod_condicao?>" <?=$checked?>/>
					  <?=$descricao?>
			</label>
		  </fieldset>
		 	<?
			}
			?>	 		  			  				  
	</fieldset>
	</fieldset> 	
	<fieldset>
	<fieldset id="descontoa" >
	  <label for="condPagamentoExtra">
		Desconto à vista (%)
	  </label>
	  <?
	  		$sql = "SELECT ocon_desconto FROM orcamentoscondicoespagamento WHERE ocon_orcamento = $cod_orcamento AND ocon_condicaopagamento = 1";				
			$resultado = execute_query($sql);
			$linha = $resultado->fetchRow();
			$desconto = $linha[0];			
	  ?>
	  <input id="desconto" name="desconto" type="text" class="numbers-only" value="<?=$desconto?>">	 
	</fieldset>	
	<fieldset id="nparcelas" >
	  <label for="condPagamentoExtra">
		Nº de parcelas
	  </label>
	  <?
	  		$sql = "SELECT ocon_qtdparcelas FROM orcamentoscondicoespagamento WHERE ocon_orcamento = $cod_orcamento AND ocon_condicaopagamento = 2";				
			$resultado = execute_query($sql);
			$linha = $resultado->fetchRow();
			$parcelas = $linha[0];			
	  ?>
	  <input id="parcelas" name="parcelas" type="text" class="onsubmit:notnull numbers-only" value="<?=$parcelas?>">	 
	</fieldset>	
	<fieldset id="juros" >
	  <label for="condPagamentoExtra">
		Nº de parcelas c/ juros
	  </label>
	  <?
	  		$sql = "SELECT ocon_qtdparcelas FROM orcamentoscondicoespagamento WHERE ocon_orcamento = $cod_orcamento AND ocon_condicaopagamento = 3";		
				
			$resultado = execute_query($sql);
			$linha = $resultado->fetchRow();
			$parcelasjuros = $linha[0];			
	  ?>
	  <input id="parcelasjuros" name="parcelasjuros" type="text" class="onsubmit:notnull numbers-only" value="<?=$parcelasjuros?>">	 
	</fieldset>			  			  
  </fieldset>
  <fieldset>
  <fieldset class='formapagto onsubmit:notnull'>
	<label for='formapagto'>
	  Forma de pagamento
	</label>
	<select id='formapagto' name='formapagto' class='onsubmit:notnull'>
	 <option value='null'>
		Selecione uma opção
	  </option>
	<?		
		$sql = "SELECT form_formapagto, form_descricao ". 
		"FROM formaspagamento";		
		$resultado = execute_query($sql);
		while ($linha = $resultado->fetchRow()) 
		{		 			
			  $cod_forma  = $linha[0];
			  $descricao  = $linha[1];
			  if($cod_forma == $formapagto)
			  {
				$checked = "selected";
			  }else{ $checked = "";}	echo $formapagto;
	?>	
		 <option value='<? echo $cod_forma;?>' <?=$checked?>>
		 <? echo $descricao;?> 
		 </option> 
	<?		  
		}				
	?>      
	</select>           
  </fieldset> 
  <fieldset id="datas" >
	  <label for="dataentrada">
		Data da entrada:
	  </label>	 
	  <input id="dataentrada" name="dataentrada" type="text" class="data-mask onsubmit:notnull" value="<?=$dataentrada?>">	 
	</fieldset>	
	</fieldset>	
	<fieldset>
	 <fieldset id="intervalodias" >
	  <label for="intervalodias">
		Intervalo de dias para cada parcela
	  </label>	 
	  <input id="intervalo" name="intervalo" type="text" title="informe o intervalo entre cada parcela ex: 20, 30" class="onsubmit:notnull numbers-only" value="<?=$intervalo?>">	 
	</fieldset>
	<fieldset id='dias'>
	<label for='dias'>
	  Dias após
	</label>
	<select id='diasparcela' name='diasparcela' class='onsubmit:notnull'>
	 <option value='null'>
		Selecione uma opção
	  </option>
	<?		
		$sql = "SELECT dias_diasapos, dias_descricao ". 
		"FROM diasapospagamento";		
		$resultado = execute_query($sql);
		while ($linha = $resultado->fetchRow()) 
		{		 			
			  $cod_dias  = $linha[0];
			  $descricao  = $linha[1];	
			  if($cod_dias == $diasapos)
			  {
				$checked = "selected";
			  }else{ $checked = "";}
	?>	
		 <option value='<? echo $cod_dias;?>' <?=$checked?>>
		 <? echo $descricao;?> 
		 </option> 
	<?		  
		}				
	?>      
	</select>           
  </fieldset>  	
 </fieldset> 
 </fieldset>
   
<fieldset class="buttons">
<input value="Cancelar" class="reset action:../_funcoes/controller.php?opcao=home-pedidos" type="reset">
<input type="submit" id='submit-button' value="Salvar" class="bt">
</fieldset>
</form>
</body>
</html>
