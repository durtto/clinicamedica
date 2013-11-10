<?
session_start();
require_once("../_funcoes/funcoes.php");
include("../componentes/head.php");
echo "<script src='../_javascript/edicao-de-orcamentos/Second.js' type='text/javascript'></script>\n";
echo "</head>";
echo "<body>";

include("../componentes/cabecalho.php");
?>
<div id="menu-secao">
	<li>
		<a href="../_funcoes/controller.php?opcao=home-os" class="pedidos">Ordens de Serviço</a>
		OS > Forma de pagamento
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
				" ord_ordemdeservico, ord_cliente, ord_responsavel, ord_situacao, ord_defeito, ord_dataentrada, ord_datasaida, ord_valor, ord_equipamento ".				
				" FROM ordensdeservico WHERE ord_ordemdeservico = $cod";
				
	$resultado = execute_query($sql);
	while ($linha = $resultado->fetchRow()) 
	{		 			
		  $codos  = $linha[0];
		  $cod_cliente  = $linha[1];
		  $cod_responsavel  = $linha[2];
		  $cod_situacao  = $linha[3];
		  $defeito  = $linha[4];  
		  $dataentrada = $linha[5];
		  $datasaida = $linha[6];
		  $total = $linha[7];
		  $equipamento = $linha[8];
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
<input type="hidden" name="parte" value="2" />
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
		</fieldset>
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
				 		 
			?>	
		  <fieldset class='condPagamento'>
			<label class='condPagamento'>		
			  
			  <input type="radio" id='condicao' name='condicao' class="onsubmit:notnull radio" value="<?= $cod_condicao?>" />
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
	  <input id="desconto" name="desconto" type="text" class="numbers-only">	 
	</fieldset>	
	<fieldset id="nparcelas" >
	  <label for="condPagamentoExtra">
		Nº de parcelas
	  </label>
	  
	  <input id="parcelas" name="parcelas" type="text" class="onsubmit:notnull numbers-only" >	 
	</fieldset>	
	<fieldset id="juros" >
	  <label for="condPagamentoExtra">
		Nº de parcelas c/ juros
	  </label>
	  
	  <input id="parcelasjuros" name="parcelasjuros" type="text" class="onsubmit:notnull numbers-only" >	 
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
	?>	
		 <option value='<? echo $cod_forma;?>'>
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
	  <input id="dataentrada" name="dataentrada" type="text" class="data-mask onsubmit:notnull">	 
	</fieldset>	
	</fieldset>	
	<fieldset>
	 <fieldset id="intervalodias" >
	  <label for="intervalodias">
		Intervalo de dias para cada parcela
	  </label>	 
	  <input id="intervalo" name="intervalo" type="text" title="informe o intervalo entre cada parcela ex: 20, 30" class="onsubmit:notnull numbers-only">	 
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
	?>	
		 <option value='<? echo $cod_dias;?>'>
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
<input value="Cancelar" class="reset action:../_funcoes/controller.php?opcao=home-os" type="reset">
<input type="submit" id='submit-button' value="Finalizar" class="bt">
</fieldset>
</form>
</body>
</html>
