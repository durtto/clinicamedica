

<?
require_once("realpath.php");
$id = $_SESSION['id'];
$sql = "select usu_login from usuarios where usu_usuario = ".$id;
//echo $sql;
$resultado = execute_query($sql);
while ($linha = $resultado->fetchRow()) 
{		 			
	  $nome_usuario  = $linha[0];
}
$resultado->free();

?>
<div id="cabecalho">
	<a href="<?=$_CONF['realpath']?>/_funcoes/controller.php?opcao=home" class="sistema">Cl&iacute;nica M&eacute;dica</a>
	<p class="nome_usuario">Bem vindo, <b><? echo $nome_usuario;?></b>.</p>
	<a href="<?=$_CONF['realpath']?>/_funcoes/controller.php?opcao=sair" class="sair">Sair</a>
</div>


