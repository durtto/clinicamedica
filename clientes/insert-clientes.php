<?
session_start();
require_once("../_funcoes/funcoes.php");

$conn = conecta_banco();

$tipodecliente = $_POST['tipoDeCliente'];
if($tipodecliente == "fisica")
{
	$tipodecliente = "F";
	$pesNome = strParaBD($_POST['pesNome']);
	$pesfCpf = $_POST['pesfCpf'];
	$pesfRg = $_POST['pesfRg'];
}
else
{	
	$tipodecliente = "J";
	$pesNome = strParaBD($_POST['pesNome']);
	$pesjRazaosocial = $_POST['razaosocial'];
	//$pesjNomepessoacontato	= $_POST['pesjNomepessoacontato'];
	$pesjCnpj = $_POST['cnpj'];
	$pesjInscricaoestadual = $_POST['inscricao'];
}

$datanascimento = campotextoparaobanco(dataparaobanco($_POST['nascimento']));

$situacao = $_POST['situacao'];

$cliObservacoes = strParaBD($_POST['cliObservacoes']);

$logradouro = strParaBD($_POST['logradouro']);
$numero = $_POST['numero'];
$bairro = strParaBD($_POST['bairro']);
$complemento = $_POST['complemento'];
$cep = $_POST['cep'];

$conComercial = $_POST['conComercial'];
$conResidencial = $_POST['conResidencial'];
$conCelular = $_POST['conCelular'];
$conEmail = $_POST['conEmail'];

$sql = "SELECT MAX(pes_pessoa) as codigo FROM pessoas";
$resultado = $conn->query($sql);
while ($linha = $resultado->fetchRow()) 
{		 			
	$codpessoa  = $linha[0]+1;
}

$sql1 = "insert into pessoas (pes_pessoa, pes_nome) values ('$codpessoa','$pesNome')";

$sql = "SELECT MAX(end_endereco) as codigo FROM enderecos";
$resultado = $conn->query($sql);
while ($linha = $resultado->fetchRow()) 
{		 			
	$endereco  = $linha[0]+1;
}	
$sql2 = "insert into enderecos (end_endereco, end_logradouro, end_numero, end_bairro, end_complemento, end_cep, end_pais) values ('$endereco','$logradouro','$numero', '$bairro', '$complemento', '$cep', '1')";
	
if($tipodecliente == "F")
{
	$sql3 = "insert into clientes(cli_cliente, cli_cpf, cli_inscricao_rg, cli_endereco, cli_con_comercial, cli_con_residencial, cli_con_celular, cli_con_email, cli_observacoes, cli_estahativo, cli_tipodepessoa, cli_datanascimento) values ('$codpessoa','$pesfCpf','$pesfRg','$endereco','$conComercial','$conResidencial','$conCelular','$conEmail','$cliObservacoes','$situacao','$tipodecliente', $datanascimento)";
}else{
	$sql3 = "insert into clientes(cli_cliente, cli_razaosocial, cli_contato, cli_cnpj, cli_inscricao_rg, cli_endereco, cli_con_comercial, cli_con_residencial, cli_con_celular, cli_con_email, cli_observacoes, cli_estahativo, cli_tipodepessoa) values ('$codpessoa','$pesjRazaosocial','$pesjNomepessoacontato','$pesjCnpj','$pesjInscricaoestadual','$endereco','$conComercial','$conResidencial','$conCelular','$conEmail','$cliObservacoes','$situacao','$tipodecliente')";
}


if (!($conn -> Execute($sql1))) {
    $erro='Erro inserindo:'.$conn -> ErrorMsg().'<BR>'.$sql1;
}
if (!($conn -> Execute($sql2))) {
    $erro.='Erro inserindo:'.$conn -> ErrorMsg().'<BR>'.$sql2;
}
if (!($conn -> Execute($sql3))) {
    $erro.='Erro inserindo:'.$conn -> ErrorMsg().'<BR>'.$sql3;
}

if($erro != '')	{		
	include('../error/error.php?erro='.$erro);	
	
}
else{	
	echo "<script>
		 location.href='../_funcoes/controller.php?opcao=home-clientes';
	  </script>";	
}
?>