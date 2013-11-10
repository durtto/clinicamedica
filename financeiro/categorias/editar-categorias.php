<?
session_start();
require_once("../../_funcoes/funcoes.php");
echo "<html id='servicos-cadastro' class='servicos' xmlns='http://www.w3.org/1999/xhtml'>";
include("../../componentes/head.php");
echo "</head>";
echo "<body >";

include("../../componentes/cabecalho.php");

$cod = $_GET['cod'];

$sql = "select cat_categoria, cat_descricao from categoriasdemovimentacao where cat_categoria = $cod";
$resultado = execute_query($sql);
while ($linha = $resultado->fetchRow()) 
{		 			
	$codcategoria = $linha[0];
	$descricao = $linha[1];
}

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

<form id="form-servicos" name="form-servicos" class="form-auto-validated" action="update-categorias.php" method="post" enctype="multipart/form-data">
<input type="hidden" name="cod" value="<?=$cod?>" />

 <h3>
    Categoria de Movimentação
 </h3>      
      <fieldset>
        <fieldset>
          <fieldset class='catDescricao onsubmit:notnull'>
            <label for='catDescricao'>
              Nome
            </label>
            <input id='catDescricao' maxlength='50' name='catDescricao' class='' type='text' value="<?=$descricao?>" />
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
