<?
session_start();
require_once("../_funcoes/funcoes.php");
include("../componentes/head.php");
echo "<script src='../_javascript/cadastro-de-estoque/Principal.js' type='text/javascript'></script>\n";
echo "</head>";
echo "<body>";

include("../componentes/cabecalho.php");
?>

<div id="menu-secao">
	<li>
		<a href="../_funcoes/controller.php?opcao=home-estoque" class="produtos">Estoque</a>
		Produtos > Cadastro
	</li>
</div>

<div id="sub-menu">	
	<li>
		<a href="../_funcoes/controller.php?opcao=home-estoque">Listagem de Produtos</a>
	</li>
</div>

<form id="form-funcionarios" name="form-funcionarios" class="form-auto-validated" action="./insert-estoque.php" method="post" enctype="multipart/form-data">
      

<h3>
	Produto
</h3>     
        <fieldset>
        <fieldset>	
		<fieldset class='categoria onsubmit:notnull'>
            <label for='categoria'>
              Categoria
            </label>
            <select id='categoria' name='categoria' class='onsubmit:notnull'>
             <?		
				$sql = "SELECT catpro_categoriaproduto, catpro_descricao FROM categoriasdeprodutos";				
				$resultado = execute_query($sql);
				while ($linha = $resultado->fetchRow()) 
				{		 			
					  $categoria  = $linha[0];
					  $descricao  = $linha[1];					
					
			?>	
				 <option value='<? echo $categoria;?>'>
				 <? echo $descricao;?> 
				 </option> 
			<?		  
				}				
				
			?>      
            </select>           
          </fieldset>         	        	         
          <fieldset class='marca onsubmit:notnull'>
            <label>
              Marca
            </label>
            <select id='marca' name='marca' class='onsubmit:notnull'>
             <option value='null'>
                Selecione uma marca
              </option>
			<?		
				$sql = "SELECT mar_marca, mar_nome FROM marcas ORDER BY mar_nome";				
				$resultado = execute_query($sql);
				while ($linha = $resultado->fetchRow()) 
				{		 			
					  $mar_marca  = $linha[0];
					  $mar_nome  = $linha[1];					
			?>	
				 <option value='<? echo $mar_marca;?>' >
				 <? echo $mar_nome;?> 
				 </option> 
			<?		  
				}				
				
			?>      
            </select>           
          </fieldset> 
		             
        </fieldset>
		<fieldset>
          <fieldset class='codbarras onsubmit:notnull'>
            <label for='codbarras'>
              Cód. de Barras
            </label>
            <input id='codbarras' maxlength='80' name='codbarras' class='' type='text' />
         </fieldset>

          <fieldset class='nome onsubmit:notnull'>
            <label for='nome'>
              Nome
            </label>
            <input id='nome' maxlength='60' name='nome' type='text' />
          </fieldset>                 
        </fieldset>
      
        <fieldset>        
         <fieldset class='telefone onsubmit:notnull telefone-ddd-mask'>
            <label for='telefone'>
              Descrição
            </label>
            <textarea id='descricao' name='descricao'> </textarea> 
          </fieldset>		   
         </fieldset>
     
        
		<fieldset>	
        <fieldset class='logradouro onsubmit:notnull'>
            <label for='logradouro'>
              Unidade
            </label>
            <input id='un' maxlength='10' name='un' type='text' title="Informe a unidade, ex: un, m², m³" value="un"/>
          </fieldset>  
          <fieldset class='numero onsubmit:notnull'>
            <label for='numero'>
              Quantidade
            </label>
            <input id='quantidade' name='quantidade' type='text' title="Informe a quantidade em estoque" />
          </fieldset> 
        </fieldset> 
		<fieldset> 
		<fieldset class='conCelular telefone-ddd-mask'>
            <label for='conCelular'>
              Valor Compra
            </label>
            <input id='vcompra' name='vcompra' class='decimal' type='text'  />
          </fieldset>	  
		   <fieldset class='margem'>
            <label for='margem'>
              Margem (%)
            </label>
            <input id='margem' name='margem' class='decimal' type='text' />  
          </fieldset> 		  
         <fieldset class='celular telefone-ddd-mask'>
            <label for='celular'>
              Valor Venda
            </label>
            <input id='vvenda' name='vvenda' class='decimal' type='text' />  
          </fieldset>      
	</fieldset>	
	</fieldset>	
      
<fieldset class="buttons">
<input value="Cancelar" class="reset action:../_funcoes/controller.php?opcao=home-estoque" type="reset">
<input type="submit" id='submit-button' value="Salvar" class="bt">
</fieldset>
</form>
</body>
</html>
