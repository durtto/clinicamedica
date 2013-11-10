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
		Produtos > Edição
	</li>
</div>

<div id="sub-menu">	
	<li>
		<a href="../_funcoes/controller.php?opcao=home-estoque">Listagem de Produtos</a>
	</li>
</div>

<form id="form-funcionarios" name="form-funcionarios" class="form-auto-validated" action="./update-estoque.php" method="post" enctype="multipart/form-data">
      
<?
	$cod = $_GET['cod'];
	$sql = "SELECT	pro_produto, pro_nome, pro_descricao, pro_quantidade, pro_unidade, pro_valorvenda, pro_valorcompra, pro_marca, pro_codbarras, pro_categoriaproduto, pro_margem ". 
				"FROM	produtos WHERE pro_produto = '$cod'";
				
	$conn = conecta_banco();
	$resultado = $conn->query($sql);
	$x = 0;
	while ($linha = $resultado->fetchRow()) 
	{		 			
		  $cod_produto  = $linha[0];
		  $nome_produto  = $linha[1];
		  $descricao  = $linha[2];
		  $quantidade  = $linha[3];
		  $unidade = $linha[4];
		  $valor_venda  = $linha[5];	
		  $valor_compra  = $linha[6];	
		  $cod_marca = $linha[7];		 
		  $cod_barras = $linha[8];
		  $cod_categoria = $linha[9];
		  $margem = $linha[10];
		 			
		  $valor_venda = valorparaousuario_new($valor_venda);
		  $valor_compra = valorparaousuario_new($valor_compra);
		  $margem = valorparaousuario_new($margem);
		  
	}

?>
<h3>
	Produto
</h3>    
		<input type="hidden" name="cod" value="<?=$cod_produto?>"/>
        <fieldset>
        <fieldset>	
		<fieldset class='categoria onsubmit:notnull'>
            <label for='categoria'>
              Categoria
            </label>
            <select id='categoria' name='categoria' class='onsubmit:notnull'>
             <option value='null'>
                Selecione uma categoria
              </option>
			<?		
				$sql = "SELECT catpro_categoriaproduto, catpro_descricao FROM categoriasdeprodutos";				
				$resultado = execute_query($sql);
				while ($linha = $resultado->fetchRow()) 
				{		 			
					  $categoria  = $linha[0];
					  $descricao_categoria  = $linha[1];					
					  if($categoria == $cod_categoria)
					  {
					  	$selected = "selected";
					  }else{ $selected = ""; }
			?>	
				 <option value='<? echo $categoria;?>' <?=$selected?>>
				 <? echo $descricao_categoria;?> 
				 </option> 
			<?		  
				}				
				
			?>      
            </select>           
          </fieldset>         	         
          <fieldset class='marca onsubmit:notnull'>
            <label for='marca'>
              Marca
            </label>
            <select id='marca' name='marca' class='onsubmit:notnull'>
             <option value='null'>
                Selecione uma marca
              </option>
			<?		
				$sql = "SELECT mar_marca, mar_nome FROM marcas";				
				$resultado = execute_query($sql);
				while ($linha = $resultado->fetchRow()) 
				{		 			
					  $mar_marca  = $linha[0];
					  $mar_nome  = $linha[1];					
					  if($mar_marca == $cod_marca)
					  {
					  	$selected = "selected";
					  }else{ $selected = ""; }
			?>	
				 <option value='<? echo $mar_marca;?>' <?=$selected?>>
				 <? echo $mar_nome;?> 
				 </option> 
			<?		  
				}				
				
			?>      
            </select>           
          </fieldset>  
		  	                   
        </fieldset>
		<fieldset>
          <fieldset class='nome onsubmit:notnull'>
            <label for='nome'>
              Nome
            </label>
            <input id='nome' maxlength='60' name='nome'  type='text' value="<?=$nome_produto?>" />
          </fieldset>                 
       
          <fieldset class='codbarras onsubmit:notnull'>
            <label for='codbarras'>
              Cód. de Barras
            </label>
            <input id='codbarras' maxlength='80' name='codbarras' class='' type='text' value="<?=$cod_barras?>" />
          </fieldset>                 
        </fieldset>
      
        <fieldset>        
         <fieldset class='telefone onsubmit:notnull telefone-ddd-mask'>
            <label for='telefone'>
              Descrição
            </label>
            <textarea id='descricao' name='descricao'><?=$descricao?> </textarea> 
          </fieldset>		   
         </fieldset>
     
        
			<fieldset>
        <fieldset class='logradouro onsubmit:notnull'>
            <label for='logradouro'>
              Unidade
            </label>
            <input id='un' maxlength='10' name='un' type='text' title="Informe a unidade, ex: un, m², m³" value="<?=$unidade?>"/>
          </fieldset>  
          <fieldset class='numero onsubmit:notnull'>
            <label for='numero'>
              Quantidade
            </label>
            <input id='quantidade' name='quantidade' class="integer" type='text' title="Informe a quantidade em estoque" value="<?=$quantidade?>" />
          </fieldset> 
        </fieldset> 
		<fieldset> 
		<fieldset class='conCelular telefone-ddd-mask'>
            <label for='conCelular'>
              Valor Compra
            </label>
            <input id='vcompra' name='vcompra' class='decimal' type='text' value="<?=$valor_compra?>"/>
          </fieldset>	     
		  <fieldset class='margem'>
            <label for='margem'>
              Margem (%)
            </label>
            <input id='margem' name='margem' class='decimal' type='text' value="<?=$margem?>"/>  
          </fieldset> 
		         
         <fieldset class='celular telefone-ddd-mask'>
            <label for='celular'>
              Valor Venda
            </label>
            <input id='vvenda' name='vvenda' class='decimal' type='text' value="<?=$valor_venda?>"/>  
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
