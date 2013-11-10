<?

session_start();
require_once("../_funcoes/funcoes.php");

include_once '../model/pits.class.php';
include_once '../model/fluxodecaixa.class.php';

try{
	////CONECTA O BANCO E INICIA A TRANSAÇÃO///
	
	$conn = conecta_banco();	
		
	$Pit = new Pit();
	$Pit->set('id', $_POST['cod']);
	$Pit->set('titulo', $_POST['titulo']);
	$Pit->set('descricao', $_POST['descricao']);
	$Pit->set('codcliente', $_POST['cliente']);
	$Pit->set('codcategoria', $_POST['categoria']);
	$Pit->set('codstatus', $_POST['status']);
	$Pit->set('valor', valorparaobanco($_POST['valor']));
	$Pit->set('dataprazo', dataparaobanco($_POST['dataprazo']));
	
	$PitsModel = new PitsModel();
	if($PitsModel->updatePit($Pit))
	{
		///INSERE NO FLUXO DE CAIXA SE PIT ESTÁ APROVADO E COM VALOR > 0
		if($Pit->get('codstatus') == 3 && $Pit->get('valor') > 0)
		{
			$FluxoDeCaixa = new FluxoDeCaixa();
			$FluxoDeCaixa->set('codpessoa', $Pit->get('codcliente'));
			$FluxoDeCaixa->set('qtdparcelas', $_POST['parcelas']);
			$FluxoDeCaixa->set('dataentrada', dataparaobanco($_POST['dataentrada']));
			$FluxoDeCaixa->set('valortotal', $Pit->get('valor'));
			$FluxoDeCaixa->set('codpit', $Pit->get('id'));
			$FluxoDeCaixa->set('descricao', "Pit cód.: ".$Pit->get('id')." - ".$Pit->get('titulo'));
			$FluxoDeCaixa->set('formapagamento', $_POST['formapagto']);
			$FluxoDeCaixa->set('tipopagamento', 1);
			$FluxoDeCaixa->set('categoriamovimentacao', $_POST['categoriademovimentacao']);
			$FluxoDeCaixa->set('codconta', 'null');
			
			$FluxoDeCaixaModel = new FluxoDeCaixaModel();
			$FluxoDeCaixaModel->insertFluxo($FluxoDeCaixa);
			
		}
		header("Location: ../_funcoes/controller.php?opcao=home-pauta");
	}else{
		throw new Exception("Erro ao atualizar na pauta.", $e);
	}
	
}catch(Exception $e)
{
	include('../error/error.php');	

	print '<p>Contate o suporte técnico.</p>';
	
	echo "	<strong>ERRO: ".$e->getMessage()."</strong>";
	
	echo "<br><a href='javascript:history.go(-1);'>Voltar</a>";
}



?>