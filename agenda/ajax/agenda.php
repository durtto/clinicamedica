<? 
$dirRoot = "../../";
require_once $dirRoot."_funcoes/funcoes.php";

require_once $dirRoot.'model/agenda.class.php';
require_once $dirRoot.'model/horarios.class.php';
require_once $dirRoot.'model/convenios.class.php';
require_once $dirRoot.'model/clientes.class.php';
require_once $dirRoot.'model/procedimentos.class.php';

$ModelClientes = new ModelClientes();
$ModelConvenios = new ModelConvenios();
$ModelAgenda = new ModelAgenda();
$ModelProcedimentos = new ModelProcedimentos();

$arrayClientes = $ModelClientes->loadClientes();

if($_GET['data-selecionada'])
{
	$dataSelecionada = $_GET['data-selecionada'];
	
}else{

	$dataSelecionada = date('d/m/Y');
}
$medicoSelecionado = $_GET['medico-selecionado'];
?>
<script>
function exibeAgenda2(dataSelecionada, medicoSelecionado)
{
	$.get("ajax/agenda.php?data-selecionada="+dataSelecionada+"&medico-selecionado="+medicoSelecionado, function(data) {

    	$('#agenda').html("");
    	
    	preLoadImg = new Image();
  		preLoadImg.src = "../../_images/estrutura/loader.gif";

  		$("#agenda").html("<table width='120px'><center><br><font size=1>Aguarde, consultando...</font><br><img src='../../_images/estrutura/loader.gif'></center></table>");
  		$('#agenda').html("");
    	
	  	$('#agenda').append(data);

	  	
      });
}

////////////////////////////////
///BOTÕES DE AÇÃO NA LISTAGEM///
////////////////////////////////

$(".adicionar").click(function(){	 
	$( "#horario").val($(this).attr("horario"));
	$( "#data").val($("#data-hidden").val());
	$( "#medico-modal").val($("#medico-hidden").val());

	$( "#action").val("insert");

	$("#paciente").prop('readonly',false);
	$("#fone").prop('readonly',false);
	$("#horario").prop('readonly',false);	
	
	$( "#dialog-modal" ).dialog( "open" );	
});
$(".editar").click(function(){	 

	 $( "#action").val("update");
	 $( "#cod-agenda").val($(this).attr('id'));
	 
	 $( "#dialog-modal" ).dialog( "open" );
	 $.ajax({
			type: "GET",
			url: "ajax/load.php",
			data: "cod="+$(this).attr('id'),
			success: function(xml) {
				$(xml).find('agenda').each(function(){
					var cod = $(this).find('cod').text();
					var valorconsulta = $(this).find('valorconsulta').text();
					var paciente = $(this).find('paciente').text();
					var dataconsulta = $(this).find('dataconsulta').text();
					var horaconsulta = $(this).find('horaconsulta').text();
					var observacoes = $(this).find('observacoes').text();
					var tipo = $(this).find('tipo').text();
					var procedimento = $(this).find('procedimento').text();

					$( "#paciente").val(paciente);						
					$( "#horario").val(horaconsulta);					
					$( "#data").val(dataconsulta);
					$( "#valorconsulta").val(valorconsulta);
					$( "#tipo").val(tipo);
					$( "#procedimento").val(procedimento);
					
					$( "#observacoes").val(observacoes);

					///DESABILITA OS CAMPOS///
					$("#paciente").prop('readonly',true);
					$("#fone").prop('readonly',true);
					$("#horario").prop('readonly',true);
					$("#dataconsulta").prop('readonly',true);
				 	
				});
			},
			error: function () {
		         alert("Erro");
		    }
		});
});
$(".atendido").click(function(){
	if(confirm("Voce confirma o atendimento deste horario?"))
	{	
		
		$.get("ajax/update-delete.php?atualizar=1&agenda="+$(this).attr('id'), function(data) {
			alert(data);
			new exibeAgenda2($("#data-hidden").val(), $("#medico-hidden").val());				
		});
	}
});
$(".excluir").click(function(){
	if(confirm("Voce confirma a exclusao deste horario?"))
	{	
		
		$.get("ajax/update-delete.php?excluir=1&agenda="+$(this).attr('id'), function(data) {
			alert(data);
			new exibeAgenda2($("#data-hidden").val(), $("#medico-hidden").val());				
		});
	}
});


var availableTags = [
             		<?
             		for($i=0; $i<sizeof($arrayClientes); $i++)
             		{ 
             		?>
             			{ label: "<?=$arrayClientes[$i]->get('nomecliente')?>", value: "<?=$arrayClientes[$i]->get('codcliente')?>#<?=$arrayClientes[$i]->get('nomecliente')?>" },		
             		<? 
             		}
             		?>
             		];
$( "#paciente" ).autocomplete({
	source: availableTags
 });

</script>
<form action='#' class='org_grid grid' method='post'>
<input type="hidden" name="data-hidden" id="data-hidden" value="<?=$dataSelecionada?>" readonly="readonly">
<input type="hidden" name="medico-hidden" id="medico-hidden" value="<?=$medicoSelecionado?>" readonly="readonly">
	
	<table>
		<thead>
			<tr>
				<td class='col-3'>Hor&aacute;rio</td>
				<td class='col-2'>Paciente - Observa&ccedil;&otilde;es</td>				
				<td class='col-3'>Tipo</td>						
				<td class='col-3'>Conv&ecirc;nio</td>
				<td class='col-3'>Procedimento</td>
				<td class='col-3'>Valor</td>
				<td colspan='3' class='grid-action'>A&ccedil;&otilde;es</td>
			</tr>
		</thead>		
		<tbody>
		<?
			
		$ModelHorarios = new ModelHorarios();
		$arrayHorarios = $ModelHorarios->loadAllHorariosFromDay( dataparaobanco($dataSelecionada), $medicoSelecionado );
		
		for($i=0; $i<sizeof($arrayHorarios); $i++) 
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
			$codagenda = $ModelAgenda->loadByDataHorario( dataparaobanco($dataSelecionada), $arrayHorarios[$i]->get('horario'), $medicoSelecionado );
			
			$Agenda = $ModelAgenda->loadById( $codagenda );	
		?>
		<tr class="<? echo $par; ?>">
			<td class='col-3'><? echo $arrayHorarios[$i]->get('horario'); ?> </td>
			<?
			if($Agenda)
			{
				$Cliente = new Cliente();
				$Cliente = $ModelClientes->loadById($Agenda->get('cod_paciente'));

				$Procedimento = new Procedimento();
				$Procedimento = $ModelProcedimentos->loadById($Agenda->get('cod_procedimento'));
				
				$descricao = $Agenda->get('observacoes');
				if(strlen($descricao) > 60)
				{
					$descricao = substr($descricao, 0, 58)."...";
				}
			?>
				<td class='col-2'><?=$Cliente->get('nomecliente');?> <?if($Agenda->get('observacoes')){echo " - ".$descricao;}?></td>
				<td class='col-2'><?=$Agenda->get('tipoconsultadescricao')?></td>				
				<td class='col-3'><?=$ModelConvenios->loadById($Agenda->get('convenio'))->get('descricao')?></td>
				<td class='col-2'><?if($Procedimento){ echo $Procedimento->get('nome');}?></td>
				<td class='col-3'><?=$Agenda->get('valorconsulta')?></td>
				<? 
				if($Agenda->get('atendido') == '0')
				{
				?>
				<td class="grid-action"><a href="#" id="<?=$Agenda->get('cod_agenda')?>" class="atendido" title="marcar como atendido"></a> </td>
				<td class="grid-action"><a href="#" id="<?=$Agenda->get('cod_agenda')?>" class="editar" title="editar"></a> </td>
				<td class="grid-action"><a href="#" id="<?=$Agenda->get('cod_agenda')?>" class="excluir" title="desmarcar"></a> </td>
				<? 
				}
				?>
			<? 
			}else{				
			?>			
				<td class='col-2'></td>
				<td class='col-2'></td>
				<td class='col-3'></td>
				<td class='col-3'></td>
				<td class='col-3'></td>
				<td class="grid-action"></td>
				<td class="grid-action"></td>
				<td class="grid-action"><a id="agendar" class="adicionar" horario="<? echo $arrayHorarios[$i]->get('horario'); ?>" title="agendar"></a> </td>
			<? 
			}
			?>
			
			
		</tr>		
		<?		
		}		
		?>
		</tbody>
		
	</table>
</form>

<script>

</script>
			
