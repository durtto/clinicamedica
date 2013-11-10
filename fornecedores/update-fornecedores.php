<?
session_start();
require_once("../_funcoes/funcoes.php");

$conn = conecta_banco();
$cod = $_POST['cod'];
$cod_endereco = $_POST['cod_endereco'];

$tipodefornecedor = $_POST['tipoDeFornecedor'];
if($tipodefornecedor == "fisica")
{
	$tipodefornecedor = "F";
	$pesNome = $_POST['pesNome'];
	$pesfCpf = $_POST['pesfCpf'];
	$pesfRg = $_POST['pesfRg'];
}
else
{	
	$tipodefornecedor = "J";
	$pesNome = $_POST['pesNomeFantasia'];
	$pesjRazaosocial = $_POST['pesjRazaosocial'];
	$pesjNomepessoacontato	= $_POST['pesjNomepessoacontato'];
	$pesjCnpj = $_POST['pesjCnpj'];
	$pesjInscricaoestadual = $_POST['pesjInscricaoestadual'];
}
$situacao = $_POST['situacao'];
if($situacao == "ativo")
{
	$situacao = 'S';
}else{
	$situacao = 'N';
}
$forObservacoes = $_POST['forObservacoes'];

$logradouro = $_POST['logradouro'];
$numero = $_POST['numero'];
$bairro = $_POST['bairro'];
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

$sql1 = "update pessoas set pes_nome = '$pesNome' where pes_pessoa = '$cod'";

$sql2 = "update enderecos set end_logradouro = '$logradouro', end_numero = '$numero', end_bairro = '$bairro', end_complemento = '$complemento', end_cep = '$cep' where end_endereco = '$cod_endereco'";
	
if($tipodefornecedor == "F")
{
	$sql3 = "update fornecedores set for_cpf = '$pesfCpf', for_inscricao_rg = '$pesfRg', for_con_comercial = '$conComercial', for_con_residencial = '$conResidencial', for_con_celular = '$conCelular', for_con_email = '$conEmail', for_observacoes = '$forObservacoes', for_estahativo = '$situacao', for_tipodepessoa = '$tipodefornecedor' where for_fornecedor = '$cod'";
}else{
	$sql3 = "update fornecedores set for_contato = '$pesjNomepessoacontato', for_cnpj = '$pesjCnpj', for_razaosocial = '$pesjRazaosocial', for_inscricao_rg = '$pesjInscricaoestadual', for_con_comercial = '$conComercial', for_con_residencial = '$conResidencial', for_con_celular = '$conCelular', for_con_email = '$conEmail', for_observacoes = '$forObservacoes', for_estahativo = '$situacao', for_tipodepessoa = '$tipodefornecedor' where for_fornecedor = '$cod'";		
}


if (!($conn -> Execute($sql1))) {
    $erro='Erro:'.$conn -> ErrorMsg().'<BR>'.$sql1;
}
if (!($conn -> Execute($sql2))) {
    $erro.='Erro:'.$conn -> ErrorMsg().'<BR>'.$sql2;
}
if (!($conn -> Execute($sql3))) {
    $erro.='Erro:'.$conn -> ErrorMsg().'<BR>'.$sql3;
}

if($erro != '')	{		
	include('../error/error.php?erro='.$erro);		
}
else{	
	echo "<script>
		 location.href='../_funcoes/controller.php?opcao=home-fornecedores';
	  </script>";	
}
?>