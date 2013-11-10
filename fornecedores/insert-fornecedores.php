<?
session_start();
require_once("../_funcoes/funcoes.php");

$conn = conecta_banco();

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


$observacoes = $_POST['forObservacoes'];

$logradouro = $_POST['logradouro'];
$numero = $_POST['numero'];
$bairro = $_POST['bairro'];
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
	
if($tipodefornecedor == "F")
{
	$sql3 = "insert into fornecedores(for_fornecedor, for_cpf, for_inscricao_rg, for_endereco, for_con_comercial, for_con_residencial, for_con_celular, for_con_email, for_observacoes, for_estahativo, for_tipodepessoa) values ('$codpessoa','$pesfCpf','$pesfRg','$endereco','$conComercial','$conResidencial','$conCelular','$conEmail','$observacoes','$situacao','$tipodefornecedor')";
}else{
	$sql3 = "insert into fornecedores(for_fornecedor, for_razaosocial, for_contato, for_cnpj, for_inscricao_rg, for_endereco, for_con_comercial, for_con_residencial, for_con_celular, for_con_email, for_observacoes, for_estahativo, for_tipodepessoa) values ('$codpessoa','$pesjRazaosocial','$pesjNomepessoacontato','$pesjCnpj','$pesjInscricaoestadual','$endereco','$conComercial','$conResidencial','$conCelular','$conEmail','$cliObservacoes','$situacao','$tipodefornecedor')";
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
		 location.href='../_funcoes/controller.php?opcao=home-fornecedores';
	  </script>";	
}
?>