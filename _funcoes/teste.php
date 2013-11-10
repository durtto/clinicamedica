<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
<?php
/////////// TESTE DE CONEXO COM BANCO POSTGRES GRISE //////////////////////


//header('Content-Type: text/html; charset=latin1');
/////CONEXO COM BANCO POSTGRESS - CHAMADA ATRAVS DE INCLUDE PELAS OUTRAS CLASSES///////
$conexao = pg_connect("dbname='grise' host='localhost' user='grise' password='gf53n9nl2kn3l'");
//echo "Atual encoding: ". pg_client_encoding($conexao);
//pg_set_client_encoding($conexao, "UTF8");
//echo "Novo encoding: ". pg_client_encoding($conexao);
//pg_set_client_encoding($db, "LATIN1");
if (!$conexao)
{
 echo "Erro na conexo com o bando de dados.";
 exit;
}


	$sql="SELECT tipt_tipodetrabalho,tipt_nome,tipt_descricao,tipt_valor FROM tiposdetrabalho";
	$resultado = pg_exec($conexao,$sql);
	$linhas = pg_numrows($resultado);
	
	echo "Foi obtido um total de $linhas registros.<br>";
	
	for ($i=0;$i<$linhas;$i++)
	{
	 $minhalinha = pg_fetch_row($resultado,$i);
	 $codigo =   	 $minhalinha[0];	 
     $nome = 			$minhalinha[1];
	 $descricao = 		 $minhalinha[2];
	 $valor = 			 $minhalinha[3];

	 echo "<a href='atualizar.php?codigo=$codigo'> -> $nome -> $descricao -> $valor</a><br>";
	}
	//echo "<a href='inclusao.htm'> Formulrio de Incluso</a><br>";
	pg_close($conexao);
?>
