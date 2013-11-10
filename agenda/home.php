<?
session_start();
$dirRoot = '../';
require_once("../_funcoes/funcoes.php");

include("../componentes/head.php");
 
echo "<script src='../_javascript/agenda/home.js' type='text/javascript'></script>\n";

require_once $dirRoot.'model/agenda.class.php';
require_once $dirRoot.'model/horarios.class.php';
require_once $dirRoot.'model/convenios.class.php';
require_once $dirRoot.'model/clientes.class.php';
require_once $dirRoot.'model/medicos.class.php';

$ModelClientes = new ModelClientes();
$ModelMedicos = new ModelMedicos();
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
		Agenda > Listagem
	</li>
</div>

<div id="sub-menu">	
	<li>
		<a href="historico.php">Hist&oacute;rico de Consultas</a>		
	</li>
	<li>Médico: 
		<select name="medico" id="medico">
			<?
				$arrayMedicos = $ModelMedicos->loadMedicos();
				for($i=0; $i<sizeof($arrayMedicos); $i++)
				{
					?>
					<option value="<?=$arrayMedicos[$i]->get('codmedico')?>"><?=$arrayMedicos[$i]->get('nome')?></option>
					<? 
				}
			?>
		</select>	
	
</div>
<h4>Clique na data desejada no calend&aacute;rio para carregar a agenda do dia.</h4>
<div id="calendario"></div>

<div id="agenda">

</div>


<div id="dialog-modal" title="Agendar Hor&aacute;rio">

<form class="form-auto-validated" id="agendar-horario">
	<input type="hidden" name="medico-modal" id="medico-modal">
	<fieldset>
		<fieldset>
			<fieldset>
				<label>
					Paciente
				</label>
				<input type="text" name="paciente" id="paciente">
			</fieldset>
			<fieldset>
				<label>
					Fone (opcional)
				</label>
				<input type="text" name="fone" id="fone">
			</fieldset>
		</fieldset>
		<fieldset>
			<fieldset>
				<label>
					Data
				</label>
				<input type="text" name="data" id="data" readonly="readonly">
			</fieldset>
			<fieldset>
				<label>
					Hor&aacute;rio
				</label>
				<input type="text" name="horario" id="horario" class="time" readonly="readonly">
			</fieldset>
		</fieldset>
		<fieldset>
			<fieldset>
				<label>
					Conv&ecirc;nio
				</label>
				<select name="convenio">
					<? 
					$ModelConvenios = new ModelConvenios();
					$arrayConvenios = $ModelConvenios->loadConvenios();
					for($i=0; $i<sizeof($arrayConvenios); $i++)
					{
						?>
						<option value="<?=$arrayConvenios[$i]->get("codconvenio")?>"><?=$arrayConvenios[$i]->get("descricao")?></option>
						<? 
					}				
					?>
				</select>
			</fieldset>
			<fieldset>
				<label>
					Tipo 
				</label>
				<select name="tipo">
					<option value="C">Consulta</option>
					<option value="R">Reconsulta</option>					
				</select>
			</fieldset>
		</fieldset>
		<fieldset>
			<fieldset>
				<label>
					Observa&ccedil;&otilde;es
				</label>
				<textarea name="observacoes" id="observacoes"></textarea>
			</fieldset>
		</fieldset>
		<fieldset>
			<fieldset>
				<label>
					Valor 
				</label>
				<input type="text" name="valorconsulta" id="valorconsulta" class="decimal">
			</fieldset>
		</fieldset>
	</fieldset>
	<fieldset class="buttons">	
	<input type="button" id='submit-button' value="Salvar" class="bt">
	</fieldset>

</form>
<div id="response"></div>
</div>

</body>
</html>	