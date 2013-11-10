<?
session_start();
require_once("../../_funcoes/funcoes.php");
include("../../componentes/head.php");
echo "</head>";
echo "<body>";

include("../../componentes/cabecalho.php");

?>

<div id="menu-secao">
	<li>
		<a href="<?=$_CONF['realpath']?>/_funcoes/controller.php?opcao=home-contas" class="financeiro">Contas</a>
		Contas > Cadastro de Contas
	</li>
</div>

<div id="sub-menu">	
	<li>
		<a href="<?=$_CONF['realpath']?>/_funcoes/controller.php?opcao=home-contas">Listagem</a>
	</li>
</div>
<form id="form-funcionarios" name="form-funcionarios" class="form-auto-validated" action="./insert-conta.php" method="post" enctype="multipart/form-data">
<h3>
	Conta
</h3>     
        <fieldset>
        <fieldset>		         
          <fieldset class='nome onsubmit:notnull'>
            <label for='nome'>
              Nome
            </label>
           <input type="text" id="nome" name="nome" class="onsubmit:notnull">
          </fieldset> 
		  </fieldset>		
			<fieldset>		 
			<fieldset>
			<label for='nome'>
			Agência
			</label>					  
			<input type="text" id='agencia' name='agencia'/>  
			</fieldset>		 
			<fieldset>
			<label for='conta'>
			Nº da Conta
			</label>					  
			<input type="text" id='conta' name='conta'/>  
			</fieldset>
		</fieldset> 
  </fieldset>	  
   
<fieldset class="buttons">
<input value="Cancelar" class="reset action:/grise/_funcoes/controller.php?opcao=home-contas" type="reset">
<input type="submit" id='submit-button' value="Salvar" class="bt">
</fieldset>
</form>
</body>
</html>
