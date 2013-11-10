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
		<a href="../_funcoes/controller.php?opcao=home-financeiro" class="financeiro">Financeiro</a>
		Fluxo de Caixa > Edição de Movimentação
	</li>
</div>

<div id="sub-menu">	
	<li>
		<a href="../_funcoes/controller.php?opcao=home-financeiro">Listagem</a>
	</li>
</div>

<form id="form-funcionarios" name="form-funcionarios" class="form-auto-validated" action="./update-movimentacao.php" method="post" enctype="multipart/form-data">
<?
$cod_conta = $_GET['cod'];
$sql =			"SELECT ".
						" flux_fluxodecaixa, flux_codigo, flux_parcela, flux_codpessoa, flux_datavencimento, flux_datapagamento, flux_tipopagamento, flux_formapagamento, flux_valor, flux_qtdparcelas, flux_codconta, flux_categoriamovimentacao, flux_descricao ".				
						" FROM fluxodecaixa ".
						//" INNER JOIN orcamentos ON flux_codorcamentoaprovado = orc_orcamento ".
						" INNER JOIN pessoas ON pes_pessoa = flux_codpessoa ".
						" WHERE flux_fluxodecaixa = $cod_conta";
					
$resultado = execute_query($sql);
while ($linha = $resultado->fetchRow()) 
{		 			
	  $cod_fluxodecaixa  = $linha[0];
	  $cod_conta  = $linha[1];
	  $parcela  = $linha[2];
	  $sacado  = $linha[3];
	  $datavencimento  = $linha[4];  
	  $datapagamento = $linha[5];
	  $tipopagamento = $linha[6];
	  $formapagto = $linha[7];
	  $valor = $linha[8];
	  $qtdparcelas = $linha[9];
	   $conta = $linha[10];
	  $categoria = $linha[11];
	  $descfluxo = $linha[12];
	
	  $valor = valorparaousuario_new($valor);
	  $datavencimento = dataparaousuario($datavencimento);
	  
	  if($datapagamento != "")
	  {
		$datapagamento = dataparaousuario($datapagamento);
	  }
}

?>
<input type="hidden" name="cod" value="<?=$cod_conta?>">
<input type="hidden" name="cod_fluxo" value="<?=$cod_fluxodecaixa?>">
<h3>
	Movimentação
</h3>     
        <fieldset>
        <fieldset>		         
          <fieldset class='sacado onsubmit:notnull'>
            <label for='sacado'>
              Sacado
            </label>
            <select id='sacado' name='sacado' class='onsubmit:notnull'>  
			 <option value='null'>---=== Clientes ===---</option>          
			<?		
				$sql = "SELECT cli_cliente, pes_nome ". 
				"FROM clientes ".				
				"INNER JOIN ".
				"pessoas ON cli_cliente = pes_pessoa ".								
				"WHERE cli_estahativo = 's' ORDER BY pes_nome";
					
				$resultado = execute_query($sql);
				while ($linha = $resultado->fetchRow()) 
				{		 			
					  $cod_cliente  = $linha[0];
					  $nome_cliente  = $linha[1];	
					  if($sacado == $cod_cliente)
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
			<option value='null'>---=== Fornecedores ===---</option>          
			
			<?		
				$sql = "SELECT for_fornecedor, for_estahativo, pes_nome ". 
				"FROM fornecedores ".				
				"INNER JOIN ".
				"pessoas ON for_fornecedor = pes_pessoa ".							
				"ORDER BY pes_nome";
					
				$resultado = execute_query($sql);
				while ($linha = $resultado->fetchRow()) 
				{		 			
					  $cod_fornecedor  = $linha[0];
					  $nome_fornecedor  = $linha[2];
					  if($sacado == $cod_fornecedor)
					  {
					  	$selected = "selected";
					  }else{ $selected = ""; }									
			?>	
				 <option value='<? echo $cod_fornecedor;?>' <?=$selected?> >
				 <? echo $nome_fornecedor;?> 
				 </option> 
			<?		  
				}				
			?>      
            </select>           
          </fieldset> 
		  </fieldset> 
		  <fieldset>
		   <fieldset class='categoria'>
              <label for='categoria'>
                Categoria
              </label>
              <select id='categoria' name='categoria' class="onsubmit:notnull">    
			  <option value='null' >Selecione uma categoria</option>              
			<?		
				$sql = "SELECT cat_categoria, cat_descricao, gcat_descricao ". 
				"FROM categoriasdemovimentacao INNER JOIN gruposcategorias ON gcat_grupo = cat_grupo ORDER BY cat_grupo, cat_descricao";				
				$resultado = execute_query($sql);
				while ($linha = $resultado->fetchRow()) 
				{		 			
					  $cod_categoria  = $linha[0];
					  $descricao  = $linha[1];	
					  $descGrupo = $linha[2];
					   if($cod_categoria == $categoria)
					  {
					  	$selected = "selected";
					  }else{ $selected = ""; }							
			?>	
				 <option value='<? echo $cod_categoria;?>' <?=$selected?> >
				 <? echo $descGrupo." - ".$descricao;?> 
				 </option> 
			<?		  
				}				
			?>                  
            </select>
            </fieldset>	
			</fieldset>                 
          <fieldset>
		   <fieldset class='conta'>
              <label for='conta'>
                Conta (origem/destino)
              </label>
              <select id='conta' name='conta'>   
			  	<option value="null">Nenhuma conta</option>
				 <?
				$sql = "SELECT con_conta, con_nome ". 
						"FROM contas ".								
						"ORDER BY con_nome";		  
				
				$resultado = execute_query($sql);
				while ($linha = $resultado->fetchRow()) 
				{		 			
					  $codconta  = $linha[0];			  
					  $nome_conta = $linha[1];	
					  
					  if($codconta == $conta)
					  {
					  	$selected = "selected";
					  }else{ $selected = ""; }		 
				?>
                <option value='<? echo $codconta; ?>' <?=$selected?>>
                <?  echo $nome_conta; ?>
                </option>
				<? 
				}
				?>
                
              </select>
            </fieldset>	
			</fieldset>		
<fieldset>		 
<fieldset>
	<legend>
	Tipo de Movimentação
	</legend>	
	<fieldset class='onsubmit:notnull'>
	<?		
			$sql = "SELECT tip_tipoconta, tip_descricao ". 
					"FROM tiposdeconta";				
			$resultado1 = execute_query($sql);
			while($linha2 = $resultado1->fetchRow())
			{
				$tipo = $linha2[0];
				$tipoconta_descricao = $linha2[1];	
				if($tipo == $tipopagamento)
				  {
					$checked = "checked";
				  }else{ $checked = ""; }									 		 
			?>	
			
		  <fieldset class='condPagamento'>
			<label class='condPagamento'>		
			  
			  <input type="radio" id='tipopagamento' name='tipopagamento' class="onsubmit:notnull radio" value="<?= $tipo?>" <?=$checked?> />
					  <?=$tipoconta_descricao?>
			</label>
		  </fieldset>
		 	<?
			}
			?>	 		  			  				  
	</fieldset>
  </fieldset> 
  </fieldset>	
  <fieldset>
  <fieldset class='formapagto onsubmit:notnull'>
	<label for='formapagto'>
	  Forma de pagamento
	</label>
	<select id='formapagto' name='formapagto' class='onsubmit:notnull'>	
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
				$selected = "selected";
				}else{ $selected = ""; }		  
	?>	
		 <option value='<? echo $cod_forma;?>' <?=$selected?>>
		 <? echo $descricao;?> 
		 </option> 
	<?		  
		}				
	?>      
	</select>           
  </fieldset>
  </fieldset>   
	<fieldset>
	<fieldset >
	  <label for="parcela">
		Parcela
	  </label>	 
	   <input id="parcela" name="parcela" type="text" class="onsubmit:notnull numbers-only" value="<?=$parcela?>" disabled="disabled">
	</fieldset>	
	</fieldset>
	<fieldset>	
	<fieldset >
	  <label for="descricao">
		Descrição
	  </label>	 
	   <textarea id="descricao" name="descricao" type="text" class="onsubmit:notnull"><?=$descfluxo?></textarea>
	</fieldset>				
	</fieldset>			
	<fieldset>
	<fieldset>
	  <label for="valorparcela">
		Valor
	  </label>	 
	  <input id="valorparcela" name="valorparcela" type="text" class="decimal" title="Informe o valor da parcela" value="<?=$valor?>">	 
	</fieldset>	
	<fieldset id="gerar" >
	  <label for="gerar">
	  &nbsp;		
	  </label>	 
	  <input id="gerarrecibo" name="gerarrecibo" type="checkbox" class="radio">Gerar recibo
	</fieldset>					  
  </fieldset>
  <fieldset>
  <fieldset id="datas" >
	  <label for="dataentrada">
		Data da vencimento:
	  </label>	 
	  <input id="datavencimento" name="datavencimento" type="text" class="data-mask" value="<?=$datavencimento?>">	 
	</fieldset>
	<fieldset id="datas" >
	  <label for="dataentrada">
		Data da pagamento:
	  </label>	 
	  <input id="datapagamento" name="datapagamento" type="text" class="data-mask" value="<?=$datapagamento?>">	 
	</fieldset>		
	</fieldset>		
 </fieldset>
   
<fieldset class="buttons">
<input value="Cancelar" class="reset action:../_funcoes/controller.php?opcao=home-financeiro" type="reset">
<input type="submit" id='submit-button' value="Salvar" class="bt">
</fieldset>
</form>
</body>
</html>
