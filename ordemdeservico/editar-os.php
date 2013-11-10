<?
session_start();
require_once("../_funcoes/funcoes.php");
include("../componentes/head.php");
echo "<script src='../_javascript/edicao-de-os/Principal.js' type='text/javascript'></script>\n";
echo "</head>";
echo "<body>";

include("../componentes/cabecalho.php");
?>
<div id="menu-secao">
	<li>
		<a href="../_funcoes/controller.php?opcao=home-orcamentos" class="pedidos">Orçamentos e Pedidos</a>
		OS > Edição
	</li>
</div>
<div id="sub-menu">		
	<li>
		<a href="../_funcoes/controller.php?opcao=home-os">Listagem de OS</a>		
	</li>
</div>
<?
$cod = $_GET['cod'];
$sql =			"SELECT ".
				" ord_ordemdeservico, ord_cliente, ord_responsavel, ord_situacao, ord_defeito, ord_dataentrada, ord_datasaida, ord_valor, ord_equipamento, ord_observacoes ".				
				" FROM ordensdeservico WHERE ord_ordemdeservico = $cod";
				
	$resultado = execute_query($sql);
	while ($linha = $resultado->fetchRow()) 
	{		 			
		  $codos  = $linha[0];
		  $cod_cliente  = $linha[1];
		  $cod_responsavel  = $linha[2];
		  $situacao  = $linha[3];
		  $defeito  = $linha[4];  
		  $dataentrada = $linha[5];
		  $datasaida = $linha[6];
		  $total = $linha[7];
		  $equipamento = $linha[8];
		  $observacoes = $linha[9];
	}			
		  $total = valorparaousuario_new($total);
		  $dataentrada = dataparaousuario($dataentrada);
		  if($datasaida != '')
		  {
		  	$datasaida = dataparaousuario($datasaida);
		  }
?>

<form id="form-funcionarios" name="form-funcionarios" class="form-auto-validated" action="./update-os.php" method="post" enctype="multipart/form-data">
<input type="hidden" name="cod" value="<?=$codos?>" />
<h3>
	Ordem de Serviço
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
				"pessoas ON cli_cliente = pes_pessoa ".							
				"ORDER BY pes_nome";			
				$resultado = execute_query($sql);
				while ($linha = $resultado->fetchRow()) 
				{		 			
					  $cliente  = $linha[0];
					  $nome_cliente  = $linha[1];	
					  if($cod_cliente == $cliente)
					{
						$selected = "selected";
					}else{ $selected = ""; }							
			?>	
				 <option value='<? echo $cod_cliente;?>' <?=$selected?> >
				 <? echo $nome_cliente;?> 
				 </option> 
			<?		  
				}				
			?>      
            </select>           
          </fieldset> 
		  </fieldset>	
		  <fieldset>		         
          <fieldset class='responsavel onsubmit:notnull'>
            <label for='responsavel'>
              Responsável técnico
            </label>
            <select id='responsavel' name='responsavel' class='onsubmit:notnull'>
             <option value='null'>
                Selecione um usuário
              </option>
			<?		
				$sql = "SELECT usu_usuario, pes_nome ". 
				"FROM usuarios ".				
				"INNER JOIN ".
				"pessoas ON usu_usuario = pes_pessoa ".							
				"ORDER BY pes_nome";			
				$resultado = execute_query($sql);
				while ($linha = $resultado->fetchRow()) 
				{		 			
					  $cod_usuario  = $linha[0];
					  $nome_usuario  = $linha[1];		
					  if($cod_usuario == $cod_responsavel)
					{
						$selected = "selected";
					}else{ $selected = ""; }						
			?>	
				 <option value='<? echo $cod_usuario;?>' <?=$selected?> >
				 <? echo $nome_usuario;?> 
				 </option> 
			<?		  
				}				
			?>      
            </select>           
          </fieldset> 
		  </fieldset>
	<fieldset>	
<fieldset id="dataentrada" >
	  <label for="dataentrada">
		Data entrada
	  </label>	 
	  <input id="dataentrada" name="dataentrada" type="text" class="onsubmit:notnull" value="<?=$dataentrada?>" disabled="disabled">	 
	</fieldset>		  			  
  </fieldset>	
 <fieldset>
   <fieldset class='situacao'>
              <label for='situacao'>
                Situação
              </label>
              <select id='situacao' name='situacao'>
              <?  
				$sql = "SELECT sit_situacao, sit_nome ". 
				"FROM situacoes";				
				$resultado1 = execute_query($sql);
				while($linha2 = $resultado1->fetchRow())
				{
					$cod_situacao = $linha2[0];
					$nome_situacao = $linha2[1];
					if($cod_situacao == $situacao)
					{
						$selected = "selected";
					}else{ $selected = ""; }
					?>
                <option value='<? echo $cod_situacao; ?>' <?=$selected?>>
                  <? echo $nome_situacao; ?>
                </option>
				<?
				}
				?>                
              </select>					
</fieldset>
<div id="saida">
 <fieldset class="datasaida" >
	  <label for="datasaida">
		Data saída
	  </label>	 
	  <input id="datasaida" name="datasaida" type="text" class="onsubmit:notnull data-mask" value="<?=$datasaida?>">	 
	</fieldset>	
	</div>	  			  
  </fieldset>	
		  <fieldset>	
<fieldset id="equipamento" >
	  <label for="equipamento">
		Equipamento
	  </label>	 
	  <input id="equipamento" name="equipamento" type="text" class="onsubmit:notnull" value="<?=$equipamento?>">	 
	</fieldset>		  			  
  </fieldset>	 
 <fieldset>
	<fieldset id="defeito" >
	  <label for="defeito">
		Defeito
	  </label>	 
	  <textarea id="defeito" name="defeito" type="text" class="onsubmit:notnull" ><?=$defeito?></textarea>	 
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
	<?
	$sql = "SELECT orde_produto, orde_quantidade, orde_subtotal, orde_valorunitario ". 
		"FROM ordensprodutos WHERE orde_ordemdeservico = $codos";		
//echo $sql;
	$resultado = execute_query($sql);
	$i = 0;
	if($resultado)
	{
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
		<td class="col-4"><input name='total' id='total' class='onsubmit:notnull input' type='text' value="<?=$total?>"></td>	
	</tr>
	<tr>
	<td colspan="9">		
	  <input value="Excluir" class="bt org-grid" id="excluir-produto" type="button">
	  </td>
	 </tr>
 </tfoot>
</table>
</div>

<fieldset id="observacoes" >
	  <label for="observacoes">
		Observações
	  </label> 
  <textarea id="observacoes" name="observacoes" type="text" ><?=$observacoes?></textarea>	 
</fieldset>	
	

<fieldset class="buttons">
<input value="Cancelar" class="reset action:../_funcoes/controller.php?opcao=home-os" type="reset">
<input type="submit" id='submit-button' value="Salvar" class="bt">
</fieldset>
</form>
</body>
</html>
