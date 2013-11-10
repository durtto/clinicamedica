<?
session_start();
require_once("../_funcoes/funcoes.php");

$conn = conecta_banco();
$cod = $_POST['cod'];
$cod_endereco = $_POST['cod_endereco'];

$tipodecliente = $_POST['tipoDeCliente'];
if($tipodecliente == "fisica")
{
	$tipodecliente = "F";
	$pesNome = strParaBD($_POST['pesNome']);
	$pesfCpf = $_POST['pesfCpf'];
	$pesfRg = $_POST['pesfRg'];
}else{	
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

if($pesNome == "")
{
	$pesNome = $pesNomeFantasia;
}




	




if($cod_endereco != "" && $cod_endereco != "null")
{
	$sql = "update enderecos set end_logradouro = '$logradouro', end_numero = '$numero', end_bairro = '$bairro', end_complemento = '$complemento', end_cep = '$cep' where end_endereco = '$cod_endereco'";
	if (!($conn -> Execute($sql))) {
    	$erro.='Erro:'.$conn -> ErrorMsg().'<BR>'.$sql;
	}
}else{
	$sql = "SELECT MAX(end_endereco) as codigo FROM enderecos";
	$resultado = $conn->query($sql);
	while ($linha = $resultado->fetchRow()) 
	{		 			
	$cod_endereco  = $linha[0]+1;
	}	
	$sql = "insert into enderecos (end_endereco, end_logradouro, end_numero, end_bairro, end_complemento, end_cep, end_pais) values ('$cod_endereco','$logradouro','$numero', '$bairro', '$complemento', '$cep', '1')";
	if (!($conn -> Execute($sql))) {
    	$erro='Erro:'.$conn -> ErrorMsg().'<BR>'.$sql;
	}

}
if($tipodecliente == "F")
{
	$sql3 = "update clientes set cli_cpf = '$pesfCpf', cli_endereco = '$cod_endereco', cli_inscricao_rg = '$pesfRg', cli_con_comercial = '$conComercial', cli_con_residencial = '$conResidencial', cli_con_celular = '$conCelular', cli_con_email = '$conEmail', cli_observacoes = '$cliObservacoes', cli_estahativo = '$situacao', cli_tipodepessoa = '$tipodecliente', cli_datanascimento = $datanascimento where cli_cliente = '$cod'";
}else{
	$sql3 = "update clientes set cli_contato = '$pesjNomepessoacontato', cli_endereco = '$cod_endereco', cli_cnpj = '$pesjCnpj', cli_razaosocial = '$pesjRazaosocial', cli_inscricao_rg = '$pesjInscricaoestadual', cli_con_comercial = '$conComercial', cli_con_residencial = '$conResidencial', cli_con_celular = '$conCelular', cli_con_email = '$conEmail', cli_observacoes = '$cliObservacoes', cli_estahativo = '$situacao', cli_tipodepessoa = '$tipodecliente' where cli_cliente = '$cod'";		
}

$sql1 = "update pessoas set pes_nome = '$pesNome' where pes_pessoa = '$cod'";
if (!($conn -> Execute($sql1))) {
    $erro='Erro:'.$conn -> ErrorMsg().'<BR>'.$sql1;
}

if (!($conn -> Execute($sql3))) {
    $erro.='Erro:'.$conn -> ErrorMsg().'<BR>'.$sql3;
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