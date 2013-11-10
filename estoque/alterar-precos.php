<?
session_start();
require_once("../_funcoes/funcoes.php");
include("../componentes/head.php");
echo "</head>";
echo "<body>";

include("../componentes/cabecalho.php");
?>

<div id="menu-secao">
	<li>
		<a href="../_funcoes/controller.php?opcao=home-estoque" class="produtos">Estoque</a>
		Produtos > Alteração de Preços
	</li>
</div>

<div id="sub-menu">	
	<li>
		<a href="../_funcoes/controller.php?opcao=home-estoque">Listagem de Produtos</a>
	</li>
</div>

<form id="form-funcionarios" name="form-funcionarios" class="form-auto-validated" action="./update-price-estoque.php" method="post" enctype="multipart/form-data">
      

<h3>
	Alteração de Preços
</h3>     
        <fieldset>
        <fieldset>		         
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
          <fieldset class='percentual onsubmit:notnull'>
            <label for='percentual'>
              Percentual (%)
            </label>
            <select id='percentual' name='percentual' class='onsubmit:notnull'>
             <option value='-30'>
                -30%
              </option>	
			  <option value='-25'>
                -25%
              </option>	
			  <option value='-20'>
                -20%
              </option>	
			  <option value='-15'>
                -15%
              </option>	
			  <option value='-10'>
                -10%
              </option>
			  <option value='-5'>
                -5%
              </option>			  		
			  <option value='null' selected="selected">
                Selecione uma porcentagem
              </option>	
			  <option value='+5'>
                +5%
              </option>	
			  <option value='+10'>
                +10%
              </option>	
			  <option value='+15'>
                +15%
              </option>	
			  <option value='+20'>
                +20%
              </option>
			  <option value='+25'>
                +25%
              </option>
			  <option value='+30'>
                +30%
              </option>			
            </select>         
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
