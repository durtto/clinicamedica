<?
$dirRoot = "../../";
require_once $dirRoot."_funcoes/funcoes.php";

require_once $dirRoot.'model/agenda.class.php';
require_once $dirRoot.'model/horarios.class.php';
require_once $dirRoot.'model/convenios.class.php';
require_once $dirRoot.'model/clientes.class.php';
require_once $dirRoot.'model/procedimentos.class.php';

$codagenda = $_GET['cod'];

$ModelClientes = new ModelClientes();
$ModelConvenios = new ModelConvenios();
$ModelAgenda = new ModelAgenda();
$ModelProcedimentos = new ModelProcedimentos();

$Agenda = new Agenda();

$Agenda = $ModelAgenda->loadById( $codagenda );

$Cliente = new Cliente();
$Cliente = $ModelClientes->loadById($Agenda->get('cod_paciente'));

$corpo ="<?xml version=\"1.0\" encoding=\"iso-8859-1\"?>";
$corpo .="<agenda><cod>".$Agenda->get('cod_agenda')."</cod><paciente>".$Cliente->get('codcliente')."#".$Cliente->get('nomecliente')."</paciente><dataconsulta>".$Agenda->get('dataconsulta')."</dataconsulta><horaconsulta>".$Agenda->get('horainicio')."</horaconsulta><convenio>".$Agenda->get('convenio')."</convenio><observacoes>".$Agenda->get('observacoes')."</observacoes><tipo>".$Agenda->get('tipoconsulta')."</tipo><procedimento>".$Agenda->get('cod_procedimento')."</procedimento><valorconsulta>".valorparaousuario_new($Agenda->get('valorconsulta'))."</valorconsulta></agenda>";

header("Content-type: text/xml");
echo $corpo;
?>