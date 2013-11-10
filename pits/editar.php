<?php

session_start();
require_once("../_funcoes/funcoes.php");


include("../componentes/head.php");

echo "<script src='../_javascript/cadastro-de-pits/Edicao.js' type='text/javascript'></script>\n";

echo "</head>";
echo "<body >";

include("../componentes/cabecalho.php");


$conn = conecta_banco();
include("../model/pits.class.php");
include("../model/filtropit.class.php");
$PitsModel = new PitsModel();
$Pit = new Pit();
$Pit = $PitsModel->loadFromId($_GET['cod']);

?>

<div id="menu-secao">
	<li>
		<a href="../_funcoes/controller.php?opcao=home-pauta" class="pauta">Pauta</a>
		Pauta > Edição
	</li>
</div>

<div id="sub-menu">	
	<li>
		<a href="../_funcoes/controller.php?opcao=home-pauta">Listagem</a>				
	</li>
</div>

<form id="form-fornecedores" name="form-fornecedores" class="form-auto-validated" action="update.php" method="post" enctype="multipart/form-data">
 	<input type="hidden" name="cod" value="<?=$Pit->get('id')?>">
 	<h3>
        Editar trabalho
      </h3>
      <fieldset>
      <fieldset>
      <fieldset>
        <legend>
         Categoria de trabalho
        </legend>

         <select id='categoria' name='categoria'>
                <option value='null'>
                 Selecione
                </option>
				<?		
				$sql = "SELECT cat_categoriatrabalho, cat_descricao ". 
						"FROM categoriasdetrabalho ORDER BY cat_descricao ";			  
				$resultado = execute_query($sql);
				while ($linha = $resultado->fetchRow()) 
				{		 			
					  $codcategoria  = $linha[0];			  
					  $descricaocategoria = $linha[1];
					  
				?>
                <option value='<? echo $codcategoria; ?>' <? if($Pit->get('codcategoria') == $codcategoria){ echo "selected";}?>>
                <?  echo $descricaocategoria; ?>
                </option>
				<? 
				}
				?>
                
        </select>
      </fieldset>
      <fieldset>
        <legend>
         Cliente
        </legend>

         <select id='cliente' name='cliente'>
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
					  $nome_cliente = $linha[1];
					 
				?>
                <option value='<? echo $cod_cliente; ?>' <? if($Pit->get('codcliente') == $cod_cliente){ echo "selected";}?>>
                <?  echo $nome_cliente; ?>
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
          Título
        </legend>
        <input name='titulo' class='onsubmit:notnull' type='text' value="<?=$Pit->get('titulo')?>"/>            
      </fieldset>
      <fieldset>

        <fieldset>
          <fieldset class='forObservacoes'>
            <label for='forObservacoes'>
              Descrição
            </label>
            <textarea id='descricao' name='descricao'><?=$Pit->get('descricao')?></textarea>
          </fieldset>
        </fieldset>
      <fieldset>
      <fieldset>
        <legend>
          Prazo
        </legend>
        <input name='dataprazo' id="dataprazo" class='onsubmit:notnull data-mask' type='text'  value="<?=$Pit->get('dataprazo')?>"/>  
        <input id="lancador" name="calendario" type="button" class="bt" value="..." title="calendário">          
      </fieldset>
      <fieldset>
        <legend>
          Valor
        </legend>
        <input name='valor' class='onsubmit:notnull moeda' type='text'  value="<?=$Pit->get('valor')?>"/>            
      </fieldset>
      </fieldset>
      </fieldset>  
      
      <fieldset>
      <fieldset>
        <legend>
         Status
        </legend>
         <select id='status' name='status'>               
				<?		
				$sql = "SELECT sit_situacao, sit_nome ". 
						"FROM situacoes ".														
						"ORDER BY sit_situacao";			  
				$resultado = execute_query($sql);
				while ($linha = $resultado->fetchRow()) 
				{		 			
					  $codsituacao  = $linha[0];			  
					  $descsituacao = $linha[1];
					 
				?>
                <option value='<? echo $codsituacao; ?>' <? if($Pit->get('codstatus') == $codsituacao){ echo "selected";}?>>
                <?  echo $descsituacao; ?>
                </option>
				<? 
				}
				?>
                
        </select>
      </fieldset>
      </fieldset>  
     </fieldset>
     </fieldset>
 
 
 <div id='pagamento'>
 <h3>Condições de Pagamento</h3>
 <fieldset>   
  <fieldset>   
     <fieldset id="nparcelas" >
	  <label for="condPagamentoExtra">
		Nº de parcelas
	  </label>	  
	  <input id="parcelas" name="parcelas" type="text" class="onsubmit:notnull numbers-only" value="1" >	 
	</fieldset>	 
  
  <fieldset id="datas" >
	  <label for="dataentrada">
		Data da entrada:
	  </label>	 
	  <input id="dataentrada" name="dataentrada" type="text" class="data-mask onsubmit:notnull" value="<?=date('d/m/Y')?>">	   
	</fieldset>	
	</fieldset>	
	<fieldset>
	<fieldset>
	<label for="dataentrada">
		Categoria de Movimentação
	  </label>
	<select id='categoriademovimentacao' name='categoriademovimentacao' class='onsubmit:notnull'>
	 <option value='null'>
		Selecione uma opção
	  </option>
	<?		
		$sql = "SELECT cat_categoria, cat_descricao ". 
		"FROM categoriasdemovimentacao WHERE cat_grupo = 1 ORDER BY cat_descricao";		
		$resultado = execute_query($sql);
		while ($linha = $resultado->fetchRow()) 
		{		 			
			  $codcategoriam  = $linha[0];
			  $descricaom  = $linha[1];	
	?>	
		 <option value='<? echo $codcategoriam;?>'>
		 <? echo $descricaom;?> 
		 </option> 
	<?		  
		}				
	?>      
	</select>           
  </fieldset> 
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
  </fieldset>	
 </fieldset> 
 </div>
	
<fieldset class="buttons">
<input value="Cancelar" class="reset action:../_funcoes/controller.php?opcao=home-pauta" type="reset">
<input type="submit" id='submit-button' value="Salvar" class="bt">
</fieldset>
</form>
</body>
</html>

