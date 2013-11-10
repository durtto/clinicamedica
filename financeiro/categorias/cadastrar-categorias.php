<?
session_start();
require_once("../../_funcoes/funcoes.php");
echo "<html id='servicos-cadastro' class='servicos' xmlns='http://www.w3.org/1999/xhtml'>";
include("../../componentes/head.php");
echo "<script src='../../_javascript/cadastro-de-servicos/Principal.js' type='text/javascript'></script>\n";
echo "</head>";
echo "<body >";

include("../../componentes/cabecalho.php");
?>

<div id="menu-secao">
	<li>
		<a href="<?=$_CONF['realpath']?>/_funcoes/controller.php?opcao=home-financeiro" class="financeiro">Financeiro</a>
		Categorias > Cadastro
	</li>
</div>

<div id="sub-menu">	
	<li>
		<a href="<?=$_CONF['realpath']?>/_funcoes/controller.php?opcao=home-categorias">Listagem de Categorias</a>		
	</li>
</div>

<form id="form-servicos" name="form-servicos" class="form-auto-validated" action="insert-categorias.php" method="post" enctype="multipart/form-data">

 <h3>
    Categoria de Movimentação
 </h3>      
      <fieldset>
      
        <fieldset>
       <fieldset class='categoria'>
              <label for='categoria'>
                Grupo
              </label>
              <select id='grupo' name='grupo'>
                 <option value='null'>Selecione</option>          
			<?		
				$sql = "SELECT gcat_grupo, gcat_descricao ". 
				"FROM gruposcategorias ";					
				$resultado = execute_query($sql);
				while ($linha = $resultado->fetchRow()) 
				{		 			
					  $codgrupo  = $linha[0];					  								
					  $descGrupo = $linha[1];
			?>	
				 <option value='<? echo $codgrupo;?>' >
				 <? echo $descGrupo;?> 
				 </option> 
			<?		  
				}				
			?>                  
            </select>
            </fieldset>	 
          <fieldset class='catDescricao onsubmit:notnull'>
            <label for='catDescricao'>
              Nome
            </label>
            <input id='catDescricao' maxlength='50' name='catDescricao' class='' type='text' />
          </fieldset>
        </fieldset>           
      </fieldset>

	
<fieldset class="buttons">
<input value="Cancelar" class="reset action:<?=$_CONF['realpath']?>/_funcoes/controller.php?opcao=home-categorias" type="reset">
<input type="submit" id='submit-button' value="Salvar" class="bt">
</fieldset>
</form>
</body>
</html>
