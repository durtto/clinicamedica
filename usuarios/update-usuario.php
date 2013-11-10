<?
session_start();
require_once("../_funcoes/funcoes.php");

$conn = conecta_banco();
$cod = $_POST['cod'];
$cod_endereco = $_POST['cod_endereco'];
$nome = $_POST['nome'];
$setor = $_POST['setor'];
$login = $_POST['login'];
$senha = $_POST['senha'];
$repetirSenha = $_POST['repetirSenha'];
if($senha != $repetirSenha)
{
	$erroSenha = "Senha e repetição de senha diferem.";
}
$logradouro = $_POST['logradouro'];
$numero = $_POST['numero'];
$bairro = $_POST['bairro'];
$complemento = $_POST['complemento'];
$cep = $_POST['cep'];
$cidade = $_POST['cidade'];
$estado = $_POST['estado'];
$pais = '1';
$ehadministrador = $_POST['ehadministrador'];
$permissoes = $_POST['permissoes'];

$telefone = $_POST['telefone'];
$celular = $_POST['celular'];
$email = $_POST['email'];
if($erroSenha == '')
{
	$sql1 = "update pessoas set pes_nome = '$nome' where pes_pessoa = '$cod'";
	
	$sql2 = "update enderecos set end_logradouro = '$logradouro', end_numero ='$numero', end_bairro = '$bairro', end_complemento = '$complemento', end_cep = '$cep', end_cidade = '$cidade', end_estado = '$estado' where end_endereco = '$cod_endereco'";
	
	$sql3 = "update usuarios set usu_login = '$login', usu_senha = '$senha', usu_setor = '$setor', usu_telefone = '$telefone', usu_celular = '$celular', usu_email = '$email', usu_ehadministrador = '$ehadministrador' where usu_usuario = '$cod'";
	
	if (!($conn -> Execute($sql1))) {
		print 'Erro:'.$conn -> ErrorMsg().'<BR>'.$sql1;
	}
	if (!($conn -> Execute($sql2))) {
		print 'Erro:'.$conn -> ErrorMsg().'<BR>'.$sql2;
	}
	if (!($conn -> Execute($sql3))) {
		print 'Erro:'.$conn -> ErrorMsg().'<BR>'.$sql3;
	}
	
	$sql5 = "delete from usuarios_permissoes where up_usuario = '$cod'";
	if (!($conn -> Execute($sql5))) {
		$erro .= 'Erro:'.$conn -> ErrorMsg().'<BR>'.$sql5.'<BR>';
	}
	for($i=0;$i<sizeof($permissoes);$i++)
	{
		$sql5 = "insert into usuarios_permissoes(up_usuario, up_permissao) values ('$cod', '$permissoes[$i]')";		
		if (!($conn -> Execute($sql5))) {
			$erro .= 'Erro:'.$conn -> ErrorMsg().'<BR>'.$sql5.'<BR>';
		}
	}
	
	if($erro != '')	{		
		include('../error/error.php?erro='.$erro);	
	}
	else{	
		echo "<script>
			 location.href='/decorcasa/_funcoes/controller.php?opcao=home-usuarios';
		  </script>";	
	}
}else
{	
	include('../error/error.php?erro='.$erroSenha);			
}
?>