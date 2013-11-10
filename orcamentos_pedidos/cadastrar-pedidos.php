<?
session_start();
require_once("../_funcoes/funcoes.php");
include("../componentes/head.php");
echo "<script src='../_javascript/cadastro-de-pedidos/Principal.js' type='text/javascript'></script>\n";
echo "</head>";
echo "<body>";

include("../componentes/cabecalho.php");
?>
<div id="menu-secao">
	<li>
		<a href="../_funcoes/controller.php?opcao=home-pedidos" class="pedidos">Vendas</a>
		Vendas > Cadastrar venda
	</li>
</div>

<div id="sub-menu">	
	<li>
		<a href="../_funcoes/controller.php?opcao=home-pedidos">Listagem de Vendas</a>
	</li>
</div>

<form id="form-funcionarios" name="form-funcionarios" class="form-auto-validated" action="./insert-pedido.php" method="post" enctype="multipart/form-data">
<h3>
	Venda
</h3>     
        <fieldset>
        <fieldset>		         
          <fieldset class='cliente onsubmit:notnull'>
            <label for='cliente'>
              Cliente
            </label>
            <select id='cliente' name='cliente' class='onsubmit:notnull'>
             <option value='null'>
                Selecione um cliente
              </option>
			<?		
				$sql = "SELECT cli_cliente, pes_nome ". 
				"FROM clientes ".				
				"INNER JOIN ".
				"pessoas ON cli_cliente = pes_pessoa WHERE cli_estahativo = 'S'".							
				"ORDER BY pes_nome";			
				$resultado = execute_query($sql);
				while ($linha = $resultado->fetchRow()) 
				{		 			
					  $cod_cliente  = $linha[0];
					  $nome_cliente  = $linha[1];					
			?>	
				 <option value='<? echo $cod_cliente;?>' >
				 <? echo $nome_cliente;?> 
				 </option> 
			<?		  
				}				
			?>      
            </select>           
          </fieldset> 
		  </fieldset>	
	<fieldset>	
	  <fieldset class='produtos'>
              <label for='produtos'>
                Produtos
              </label>
              <select id='produtos' name='produtos'>
                <option value='null'>
                  Selecione um produto
                </option>
				<?
				$sql = "SELECT pro_produto, pro_nome ". 
				"FROM produtos ";				
				$resultado = execute_query($sql);
				while ($linha = $resultado->fetchRow()) 
				{		 			
					  $cod_produto  = $linha[0];					  
					  $nome_produto = $linha[1];
				?>
                <option value='<? echo $cod_produto; ?>'>
                  <? echo $nome_produto; ?>
                </option>
				<?
				}
				?>                
              </select>
			<input id="adicionar-produto" value="Adicionar" class="bt" type="button">
           </fieldset>
		</fieldset>		
	</fieldset>
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
    <tr>
      <td></td>
    </tr>
 	</tbody>
	<tfoot>
	<tr>
		<td>		  
		</td>
		<td class="col-1"></td>
		<td class="col-2"></td>
		<td class="col-3">Total: </td>	
		<td class="col-4"><input name='total' id='total' value='0,00' class='onsubmit:notnull input' type='text'></td>	
	</tr>
	<tr>
	<td colspan="9">		
	  <input value="Excluir" class="bt org-grid" id="excluir-produto" type="button">
	  </td>
	 </tr>
 </tfoot>
</table>
</div>
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
				  if($cod_condicao == 1)
				  {
				  	$checked = "checked";
				  }else{ $checked = "";}			 		 
			?>	
			
		  <fieldset class='condPagamento'>
			<label class='condPagamento'>		
			  
			  <input type="radio" id='condicao' name='condicao' class="radio" value="<?=$cod_condicao?>" <?=$checked?>/>
					  <?=$descricao?>
			</label>
		  </fieldset>
		 	<?
			}
			?>	 		  			  				  
	</fieldset>
	</fieldset> 	
	<fieldset>	
	<fieldset id="nparcelas" >
	  <label for="condPagamentoExtra">
		Nº de parcelas
	  </label>
	 
	  <input id="parcelas" name="parcelas" type="text" class="integer">	 
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
	  <input id="dataentrada" name="dataentrada" type="text" class="data-mask" value="<?=$dataentrada?>">	 
	</fieldset>	
	</fieldset>	
	
 </fieldset>
<fieldset class="buttons">
<input value="Cancelar" class="reset action:../_funcoes/controller.php?opcao=home-orcamentos" type="reset">
<input type="submit" id='submit-button' value="Salvar" class="bt">
</fieldset>
</form>
</body>
</html>
