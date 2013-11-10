<?
session_start();
require_once("../_funcoes/funcoes.php");
echo "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml'>";
include("../componentes/head.php");
echo "</head>";
?>
<script type='text/javascript'>
function confirma_exclusao(id) {
   var cod = id;
   if (confirm('Você tem certeza?')) {
      window.location='./delete_usuario.php?cod='+cod;
      }
   }
</script>
<body>
<?

include("../componentes/cabecalho.php");

$id_usuario = $_SESSION['id'];
///VERIFICAÇÃO DAS PERMISSÕES///
$sql = "SELECT	up_permissao ". 
				"FROM	usuarios_permissoes ". 
				"WHERE up_usuario = '$id_usuario'";	
				
$resultado = execute_query($sql);	
$i = 0;		
while ($linha = $resultado->fetchRow()) 
{		 						  
		  $permissoes[$i]  = $linha[0];			  
		  $i++;		  
}
//APLICAÇÃO DAS PERMISSOES
for($x=0;$x<sizeof($permissoes);$x++)
{					  		
	
	if($permissoes[$x] == 3)
	{														
		$link_cadastrar = "../_funcoes/controller.php?opcao=cadastro-de-usuarios";
		$link_editar = $_CONF['realpath']."/_funcoes/controller.php?opcao=edicao-de-usuarios/";		
		$link_excluir = $_CONF['realpath']."/_funcoes/controller.php?opcao=exclusao-de-usuarios/";
		
		break;																
	}else{
		$link_editar = $link_excluir = $link_cadastrar = "#";								
		
	}	
}	
if(sizeof($permissoes)<1)
{
	$link_editar = $link_excluir = $link_cadastrar = "#";	
}

?>
<div id="menu-secao">
	<li>
		<a href="<?=$_CONF['realpath']?>/_funcoes/controller.php?opcao=home-usuarios" class="usuarios">Usuários</a>
		Usuários > Listagem
	</li>
</div>

<div id="sub-menu">	
	<li>
		<a href="<?=$link_cadastrar?>">Cadastro de Usuários</a>		
	</li>
</div>
<form action='#' class='org_grid grid' method='post'>
	<table>
		<thead><tr><td class='col-1'>Nome</td><td class='col-2'>Setor</td><td class='col-3'>Login</td><td colspan='2' class='grid-action'>Ações</td></tr></thead>	
		
		<tbody>
		<?
		$sql = "SELECT	usu_usuario, pes_nome, set_nome, usu_setor, usu_login ". 
				"FROM	usuarios ". 
				"INNER JOIN pessoas ".
				"ON usu_usuario = pes_pessoa ".
				"INNER JOIN setores ".
				"ON usu_setor = set_setor";
				
		$conn = conecta_banco();
		$resultado = $conn->query($sql);
		$x = 0;
		while ($linha = $resultado->fetchRow()) 
		{		 			
			  $cod_usuario  = $linha[0];
			  $nome_usuario  = $linha[1];
			  $nome_setor  = $linha[2];
			  $cod_setor  = $linha[3];			  	
			  $login  = $linha[4];	
			 
		 	  $y = 2;	 
		 	  $resto = fmod($x, $y);	
			 if($resto == 0)
			 {
				$par = "par";
			 }
			 else
			 { 
				$par = "";
			 }	
			 
		 
		 $x = $x+1;	 
					
		?>
		<tr class="<? echo $par; ?>"><td class='col-1'><? echo $nome_usuario; ?> </td><td class='col-2'><? echo $nome_setor; ?> </td><td class='col-3'><? echo $login; ?> </td>
		<!--<td class="grid-action"><a href="/grise/_funcoes/controller.php?opcao=view-de-usuarios&cod=<? //echo $cod_usuario; ?>" class="visualizar"></a> </td>-->
		<td class="grid-action"><a href="<?=$link_editar.$cod_usuario?>" class="editar"></a> </td>
		<td class="grid-action"><a href="<?=$link_excluir.$cod_usuario?>" class="excluir"></a> </td>
		</tr>
		
		<?
		
		}
		$resultado->free();
		$conn->disconnect();
		?>
		</tbody>
	</table>
</form>
			

</body>
</html>	