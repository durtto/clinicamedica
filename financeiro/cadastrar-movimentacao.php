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
		Fluxo de Caixa > Cadastro de Movimentação
	</li>
</div>

<div id="sub-menu">	
	<li>
		<a href="../_funcoes/controller.php?opcao=home-financeiro">Listagem</a>
	</li>
</div>

<form id="form-funcionarios" name="form-funcionarios" class="form-auto-validated" action="./insert-movimentacao.php" method="post" enctype="multipart/form-data">

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
			?>	
				 <option value='<? echo $cod_categoria;?>' >
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
					  $cod_conta  = $linha[0];			  
					  $nome_conta = $linha[1];		 
				?>
                <option value='<? echo $cod_conta; ?>'>
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
	?>	
		 <option value='<? echo $cod_forma;?>' <?=$checked?>>
		 <? echo $descricao;?> 
		 </option> 
	<?		  
		}				
	?>      
	</select>           
  </fieldset>
  </fieldset> 
    <fieldset>
	<fieldset>
	  <label for="descricao">
		Descrição
	  </label>	 
	  <textarea id="descricao" name="descricao" type="text" class="onsubmit:notnull" title="Informe uma descrição"></textarea>
	</fieldset>	
	</fieldset> 
  <fieldset> 
	<fieldset id="qtdparcelas" >
	  <label for="qtdparcelas">
		Nº de parcelas (recorrência)
	  </label>	  
	  <select id="qtdparcelas" name="qtdparcelas" class="onsubmit:notnull"> 	 
	  	<option value="1">1</option>
		<option value="2">2</option>
		<option value="3">3</option>
		<option value="4">4</option>
		<option value="5">5</option>
		<option value="6">6</option>
		<option value="7">7</option>
		<option value="8">8</option>
		<option value="9">9</option>
		<option value="10">10</option>
		<option value="11">11</option>
		<option value="12">12</option>
		<option value="18">18</option>
		<option value="24">24</option>
		<option value="36">36</option>
		<option value="48">48</option>
	</select>
	</fieldset>	
	<fieldset id="intervalo" >
	  <label for="intervalo">
		Intervalo de dias entre cada parcela
	  </label>	  
	  <select id="intervalo" name="intervalo" class="onsubmit:notnull"> 	 
	  	<option value="30">mensal</option>
		<option value="15">quinzenal</option>
		<option value="7">semanal</option>		
	</select>
	</fieldset>		  			  
  </fieldset>
	<fieldset>
	<fieldset>
	  <label for="valorparcela">
		Valor
	  </label>	 
	  <input id="valorparcela" name="valorparcela" type="text" class="decimal" title="Informe o valor da parcela">	
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
		Data de vencimento:
	  </label>	 
	  <input id="datavencimento" name="datavencimento" type="text" class="data-mask">	 
	</fieldset>
	<fieldset id="datas" >
	  <label for="dataentrada">
		Data de pagamento:
	  </label>	 
	  <input id="datapagamento" name="datapagamento" type="text" class="data-mask" >	 
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
