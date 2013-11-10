<?
session_start();
$dirRoot = '../';
require_once("../_funcoes/funcoes.php");

include("../componentes/head.php");

require_once $dirRoot.'model/agenda.class.php';
require_once $dirRoot.'model/horarios.class.php';
require_once $dirRoot.'model/convenios.class.php';
require_once $dirRoot.'model/clientes.class.php';

$ModelClientes = new ModelClientes();
$ModelConvenios = new ModelConvenios();
$ModelAgenda = new ModelAgenda();
?>

</head>
<body>
<?
include("../componentes/cabecalho.php");
$id_usuario = $_SESSION['id'];
?>
<div id="menu-secao">
	<li>
		<a href="home.php" class="pauta">Agenda</a>
		Agenda > Hist&oacute;rico de Consultas
	</li>
</div>

<div id="sub-menu">	
	<li>
		<a href="home.php">Agenda</a>		
	</li>	
</div>
<? 
include_once "filtros/filtro.php";
?>
<form action='#' class='org_grid grid' method='post'>	
	<table>
		<thead>
			<tr>
				<td class='col-3'>Data</td>
				<td class='col-3'>Hor&aacute;rio</td>
				<td class='col-2'>Paciente</td>				
				<td class='col-2'>Observa&ccedil;&otilde;es</td>
				<td class='col-3'>Tipo</td>						
				<td class='col-3'>Conv&ecirc;nio</td>
				<td class='col-3'>Valor</td>
				<td class='col-3'>Atendido</td>				
			</tr>
		</thead>		
		<tbody>
		<? 
		$codpaciente = $_SESSION['paciente'];
		if($codpaciente != "" && $codpaciente != "null")
		{
			
			$arrayAgenda = $ModelAgenda->loadByPaciente($codpaciente);
			
			for($i=0; $i<sizeof($arrayAgenda); $i++) 
			{		 			
							 
				$y = 2;	 
				$resto = fmod($x, $y);	
				if($resto == 0)
				{
					$par = "par";
				}else{ 
					$par = "";
				}	
				$x = $x+1;	 
				
				
				$Agenda = new Agenda();
				$Agenda = $ModelAgenda->loadById($arrayAgenda[$i]);
				
				if($Agenda)
				{
					$Cliente = new Cliente();
					$Cliente = $ModelClientes->loadById($Agenda->get('cod_paciente'));
					if($Agenda->get('atendido') == 0)
					{
						$atendido = "N&atilde;o";
						$par = "amarelo";
					}else{
						$atendido = "Sim";
					}
					?>
					<tr class="<? echo $par; ?>">
					<td class='col-3'><? echo $Agenda->get('dataconsulta'); ?> </td>
					<td class='col-3'><? echo  $Agenda->get('horainicio'); ?> </td>
					<td class='col-2'><?=utf8_decode($Cliente->get('nomecliente'));?></td>
					<td class='col-2'><?=utf8_decode($Agenda->get('observacoes'))?></td>
					<td class='col-2'><?=$Agenda->get('tipoconsulta')?></td>
					<td class='col-3'><?=$ModelConvenios->loadById($Agenda->get('convenio'))->get('descricao')?></td>
					<td class='col-3'><?=$Agenda->get('valorconsulta')?></td>
					<td class='col-3'><?=$atendido?></td>
					</tr>
				<? 
				}
			}
		}
		?>
		</tbody>
		</table>
	</form>
	
		
		
		