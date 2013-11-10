<?
session_start();
require_once("../../_funcoes/funcoes.php");
echo "<html id='clientes-cadastro' class='clientes' xmlns='http://www.w3.org/1999/xhtml'>";
include("../../componentes/head.php");
echo "</head>";
echo "<body >";

include("../../componentes/cabecalho.php");
$conn = conecta_banco();
$cod = $_GET['cod'];

$sql = "select mar_marca, mar_nome from marcas where mar_marca = '$cod'";
$resultado = execute_query($sql);			
while ($linha = $resultado->fetchRow()) 
{		 			
		  $cod  = $linha[0];
		  $nome  = $linha[1];
}
?>

<div id="menu-secao">
	<li>
		<a href="../../_funcoes/controller.php?opcao=home-basicos" class="basicos">Básicos</a>		
		Marcas > Edição
	</li>
</div>

<div id="sub-menu">	
	<li>
		<a href="../../_funcoes/controller.php?opcao=home-marcas">Listagem de Marcas</a>				
	</li>
</div>

<form id="form-clientes" name="form-clientes" class="form-auto-validated" action="update-marcas.php" method="post" enctype="multipart/form-data">
<input type="hidden" name="cod" value='<? echo $cod; ?>' />      

 	<h3>
        Marca
      </h3>
	  <fieldset>
	  <fieldset>
      <fieldset>
        <legend>
          Nome 
        </legend>                 
            <input id='nome' maxlength='50' name='nome' type='text' value="<?=$nome?>"  />
          </fieldset>
        </fieldset>
      </fieldset>

    



	
<fieldset class="buttons">
<input value="Cancelar" class="reset action:../../_funcoes/controller.php?opcao=home-marcas" type="reset">
<input type="submit" id='submit-button' value="Salvar" class="bt">
</fieldset>
</form>
</body>
</html>
