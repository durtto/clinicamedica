<?php
session_start();
$dirRoot = '../../';
require_once $dirRoot."_funcoes/funcoes.php";

require_once $dirRoot.'model/agenda.class.php';
require_once $dirRoot.'model/horarios.class.php';
require_once $dirRoot.'model/convenios.class.php';
require_once $dirRoot.'model/clientes.class.php';

$ModelClientes = new ModelClientes();
$ModelAgenda = new ModelAgenda();

$codagenda = $_POST['cod-agenda'];
$medico = $_POST['medico-modal'];
$paciente = html_entity_decode($_POST["paciente"]);
$fone = $_POST['fone'];
$data = dataparaobanco($_POST['data']);
$horario = $_POST['horario'];
$convenio = $_POST['convenio'];
$tipoconsulta = $_POST['tipo'];
$valorconsulta = valorparaobanco($_POST['valorconsulta']);
$observacoes = html_entity_decode($_POST['observacoes']);
$procedimento = $_POST['procedimento'];


$pos = stripos($paciente, "#");

if($pos != false)
{
	list($codpaciente, $nomepaciente) = explode("#", $paciente);
	
}else{
	
	$Cliente = new Cliente();
	if(empty($paciente))
	{
		die("Informe o paciente!");
	}else{
		$Cliente->set('nomecliente', $paciente);
		$Cliente->set('fonecelular', $fone);
		$codpaciente = $ModelClientes->insert($Cliente);	
	}
}
//echo $paciente." - ".$codpaciente." - ".$nomepaciente;
if($codpaciente)
{
	if($tipoconsulta == "C" || $ModelAgenda->verificaPrazoReconsulta($data, $codpaciente, $medico, '30'))
	{
		$Agenda = new Agenda();
		$Agenda->set('cod_agenda', $codpaciente);
		$Agenda->set('cod_paciente', $codpaciente);
		$Agenda->set('cod_medico', $medico);
		$Agenda->set('dataconsulta', $data);
		$Agenda->set('horainicio', $horario);
		$Agenda->set('horafim', '00:00:00');
		$Agenda->set('tipoconsulta', $tipoconsulta);
		$Agenda->set('convenio', $convenio);
		$Agenda->set('valorconsulta', $valorconsulta);
		$Agenda->set('observacoes', $observacoes);
		$Agenda->set('cod_procedimento', $procedimento);
		
		if($ModelAgenda->update($Agenda))
		{
			echo "Hor&aacute;rio atualizado com sucesso!";
		}else{
			echo "Erro ao atualizar a agenda!";
		}
	}else{
		echo "Data do agendamento ultrapassa o prazo m&aacute;ximo de 30 dias para reconsultas!";
	}
}else{
	echo "Erro ao processar paciente!";
}
