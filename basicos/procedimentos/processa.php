<?php
session_start();
$dirRoot = '../../';
require_once($dirRoot."_funcoes/funcoes.php");


require_once $dirRoot.'model/procedimentos.class.php';

$ModelProcedimentos = new ModelProcedimentos();
$Procedimento = new Procedimento();

if($_POST['cod'])
{	
	$Procedimento->set('codprocedimento', $_POST['cod']);
	$Procedimento->set('nome', strParaBD($_POST['nome']));
	$resultado = $ModelProcedimentos->update($Procedimento);
	
}else if($_GET['cod']){
	
	$Procedimento->set('codprocedimento', $_GET['cod']);	
	$resultado = $ModelProcedimentos->delete($Procedimento);
	
}else{
	
	$Procedimento->set('nome', strParaBD($_POST['nome']));
	$resultado = $ModelProcedimentos->insert($Procedimento);	
}

if($resultado)
{	
	header("Location: ".$dirRoot."_funcoes/controller.php?opcao=home-procedimentos");
	
}else{
	include($dirRoot."componentes/head.php");
	
	include($dirRoot.'error/error.php?erro=Erro ao processar a ação solicitada.');
	
	print '<p>Contate o suporte técnico.</p>';
	
	echo "	<strong>ERRO: ".$e->getMessage()."</strong>";
	
	echo "<br><a href='javascript:history.go(-1);'>Voltar</a>";
}