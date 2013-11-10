<?

session_start();
require_once("../_funcoes/funcoes.php");

include_once '../model/pits.class.php';

try{
	////CONECTA O BANCO E INICIA A TRANSAÇÃO///
	
	$conn = conecta_banco();	
		
	$Pit = new Pit();
	$Pit->set('titulo', $_POST['titulo']);
	$Pit->set('descricao', $_POST['descricao']);
	$Pit->set('codcliente', $_POST['cliente']);
	$Pit->set('codcategoria', $_POST['categoria']);
	$Pit->set('codstatus', '1');
	$Pit->set('valor', valorparaobanco($_POST['valor']));
	$Pit->set('dataprazo', dataparaobanco($_POST['dataprazo']));
	$Pit->set('codresponsavel', $_SESSION['id']);
	
	$PitsModel = new PitsModel();
	if($PitsModel->insertPit($Pit))
	{
		header("Location: ../_funcoes/controller.php?opcao=home-pauta");
	}else{
		throw new Exception("Erro ao inserir na pauta.", $e);
	}
	
}catch(Exception $e)
{
	include('../error/error.php?erro=Erro crítico na inserção.');	

	print '<p>Contate o suporte técnico.</p>';
	
	echo "	<strong>ERRO: ".$e->getMessage()."</strong>";
	
	echo "<br><a href='javascript:history.go(-1);'>Voltar</a>";
}



?>