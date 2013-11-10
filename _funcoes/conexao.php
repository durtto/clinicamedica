<?
function conecta_banco()
{
	require_once "_classes/adodb/adodb.inc.php";
	//Formato "$banco://$usuario:$senha@$host/$base";
	$dsn = "mysql://root:123456@localhost/clinica-medica";
	$conn = NewADOConnection($dsn);
	return $conn;
}




?>