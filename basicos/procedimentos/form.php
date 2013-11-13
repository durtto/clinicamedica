<?
session_start();
$dirRoot = '../../';
require_once($dirRoot."_funcoes/funcoes.php");

include($dirRoot."componentes/head.php");
require_once $dirRoot.'model/procedimentos.class.php';

$ModelProcedimentos = new ModelProcedimentos();
if($_GET['cod'])
{
	$Procedimento = new Procedimento;
	$Procedimento = $ModelProcedimentos->loadByID($_GET['cod']);	
}

?>

</head>
<body>
<?
include($dirRoot."/componentes/cabecalho.php");
$id_usuario = $_SESSION['id'];
?>
<div id="menu-secao">
	<li>
		<a href="home.php" class="basicos">Procedimentos</a>
		Procedimentos > Cadastro
	</li>
</div>
<div id="sub-menu">	
	<li>
		<a href="home.php">Listagem</a>		
	</li>
</div>

<form id="form-clientes" name="form-clientes" class="form-auto-validated" action="processa.php" method="post" enctype="multipart/form-data">
	<input type="hidden" name="cod" value='<? if($Procedimento){echo $Procedimento->get('codprocedimento'); }?>' />      

 	<h3>
        Procedimento
    </h3>
	  <fieldset>
	  <fieldset>
      <fieldset>
        <legend>
          Nome 
        </legend>                 
            <input id='nome' name='nome' type='text' value="<? if($Procedimento){ echo $Procedimento->get('nome'); }?>" />
          </fieldset>
        </fieldset>
      </fieldset>

    



	
<fieldset class="buttons">
<input value="Cancelar" class="reset action:../../_funcoes/controller.php?opcao=home-procedimentos" type="reset">
<input type="submit" id='submit-button' value="Salvar" class="bt">
</fieldset>
</form>
</body>
</html>
