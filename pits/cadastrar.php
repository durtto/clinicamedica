<?php

session_start();
require_once("../_funcoes/funcoes.php");
echo "<html id='fornecedores-cadastro' class='fornecedores' xmlns='http://www.w3.org/1999/xhtml'>";

include("../componentes/head.php");

echo "<script src='../_javascript/cadastro-de-pits/Edicao.js' type='text/javascript'></script>\n";

echo "</head>";
echo "<body >";

include("../componentes/cabecalho.php");


$conn = conecta_banco();
?>

<div id="menu-secao">
	<li>
		<a href="../_funcoes/controller.php?opcao=home-pauta" class="pauta">Pauta</a>
		Pauta > Cadastro
	</li>
</div>

<div id="sub-menu">	
	<li>
		<a href="../_funcoes/controller.php?opcao=home-pauta">Listagem</a>				
	</li>
</div>

<form id="form-fornecedores" name="form-fornecedores" class="form-auto-validated" action="insert.php" method="post" enctype="multipart/form-data">
 	<h3>
        Novo trabalho
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
                <option value='<? echo $codcategoria; ?>' <?=$selected?>>
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
						"pessoas ON cli_cliente = pes_pessoa WHERE cli_estahativo = 's'".								
						"ORDER BY pes_nome";			  
				$resultado = execute_query($sql);
				while ($linha = $resultado->fetchRow()) 
				{		 			
					  $cod_cliente  = $linha[0];			  
					  $nome_cliente = $linha[1];
					  if($cod_cliente == $_SESSION['cliente'])
					  {
					  		$selected = "selected='seleted'";
					  }else{ $selected = "";}
				?>
                <option value='<? echo $cod_cliente; ?>' <?=$selected?>>
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
        <input name='titulo' class='onsubmit:notnull' type='text'  />            
      </fieldset>
      <fieldset>

        <fieldset>
          <fieldset class='forObservacoes'>
            <label for='forObservacoes'>
              Descrição
            </label>
            <textarea id='descricao' name='descricao'></textarea>
          </fieldset>
        </fieldset>
      <fieldset>
      <fieldset>
        <legend>
          Prazo
        </legend>
        <input name='dataprazo' class='onsubmit:notnull data-mask' type='text' id="dataprazo" />      
        <input id="lancador" name="calendario" type="button" class="bt" value="..." title="calendário">          
              
      </fieldset>
      <fieldset>
        <legend>
          Valor
        </legend>
        <input name='valor' class='onsubmit:notnull moeda' type='text'  />            
      </fieldset>
      </fieldset>    
     </fieldset>
	
<fieldset class="buttons">
<input value="Cancelar" class="reset action:../_funcoes/controller.php?opcao=home-pauta" type="reset">
<input type="submit" id='submit-button' value="Salvar" class="bt">
</fieldset>
</form>
</body>
</html>
