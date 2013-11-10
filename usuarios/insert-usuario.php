<?
session_start();
require_once("../_funcoes/funcoes.php");


$conn = conecta_banco();

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
if($erroSenha == "")
{	
	$sql = "SELECT MAX(pes_pessoa) as codigo FROM pessoas";
	$resultado = $conn->query($sql);
	while ($linha = $resultado->fetchRow()) 
	{		 			
		$usuario  = $linha[0]+1;
	}
	$sql1 = "insert into pessoas (pes_pessoa, pes_nome) values ('$usuario','$nome')";
	echo $sql1;
	if (!($conn -> Execute($sql1))) {
		$erro .= 'Erro inserindo:'.$conn -> ErrorMsg().'<BR>'.$sql1.'<BR>';
	}
	$sql = "SELECT MAX(end_endereco) as codigo FROM enderecos";
	$resultado = $conn->query($sql);
	while ($linha = $resultado->fetchRow()) 
	{		 			
		$endereco  = $linha[0]+1;
	}	
	$sql2 = "insert into enderecos (end_endereco, end_logradouro, end_numero, end_bairro, end_complemento, end_cep, end_cidade, end_estado, end_pais) values ('$endereco','$logradouro','$numero', '$bairro', '$complemento', '$cep', '$cidade', '$estado', '$pais')";
	echo $sql2;
	if (!($conn -> Execute($sql2))) {
		$erro .= 'Erro inserindo:'.$conn -> ErrorMsg().'<BR>'.$sql2.'<BR>';
	}
	$sql3 = "insert into usuarios (usu_usuario, usu_login, usu_senha, usu_endereco, usu_setor, usu_telefone, usu_celular, usu_email, usu_ehadministrador) values('$usuario','$login','$senha','$endereco','$setor', '$telefone', '$celular', '$email', '$ehadministrador')";	
	if (!($conn -> Execute($sql3))) {
		$erro .= 'Erro inserindo:'.$conn -> ErrorMsg().'<BR>'.$sql3.'<BR>';
	}
	echo $sql3;
	for($i=0;$i<sizeof($permissoes);$i++)
	{
		$sql4 = "insert into usuarios_permissoes(up_usuario, up_permissao) values ('$usuario', '$permissoes[$i]')";
		echo $sql4;
		if (!($conn -> Execute($sql4))) {
			$erro .= 'Erro inserindo:'.$conn -> ErrorMsg().'<BR>'.$sql4.'<BR>';
		}
	}
}
if($erro == "" && $erroSenha == "")
{
	echo "<script>
         location.href='../_funcoes/controller.php?opcao=home-usuarios';
      </script>";
	  
	$conn->disconnect();
}
else if($erroSenha != '' || $erro != '')
{
	include('../error/error.php');	
	if($erroSenha)
	{
		print '<br><b>'.$erroSenha.'<br></b>';
	}else{
	print 'Contate o suporte técnico.';
	}
	echo "<br><a href='javascript:history.go(-1);'>Voltar</a>";
}

?>