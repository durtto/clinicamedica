<?
session_start();
$dirRoot = '../../';
require_once($dirRoot."_funcoes/funcoes.php");

include($dirRoot."componentes/head.php");
require_once $dirRoot.'model/procedimentos.class.php';

$ModelProcedimentos = new ModelProcedimentos();
?>

</head>
<body>
<?
include($dirRoot."/componentes/cabecalho.php");
$id_usuario = $_SESSION['id'];
?>
<div id="menu-secao">
	<li>
		<a href="home.php" class="basicos">Procedimentos</a>
		Procedimentos > Listagem
	</li>
</div>
<div id="sub-menu">	
	<li>
		<a href="form.php">Cadastrar</a>		
	</li>
</div>
<form action='#' class='org_grid grid' method='post'>
	<table>
		<thead><tr><td class='col-2'>Nome</td><td colspan='2' class='grid-action'>Ações</td></tr></thead>	
		
		<tbody>
		<? 
		$arrayProcedimentos = $ModelProcedimentos->loadProcedimentos();
		
		for($i=0; $i<sizeof($arrayProcedimentos); $i++) 
		{		 			
			  
			  $y = 2;	 
			  $resto = fmod($x, $y);	
			 if($resto == 0)
			 {
				$par = "par";
			 }
			 else
			 { 
				$par = "";
			 }		 
		 $x = $x+1;	 
		?>
		<tr class="<? echo $par; ?>"><td class='col-2'><? echo $arrayProcedimentos[$i]->get('nome'); ?> </td>	
			<td class="grid-action">
				<a href="form.php?cod=<? echo  $arrayProcedimentos[$i]->get('codprocedimento'); ?>" class="editar"></a> 
			</td>
			<td class="grid-action">
				<a href="processa.php?cod=<? echo  $arrayProcedimentos[$i]->get('codprocedimento'); ?>" class="excluir"></a>
			</td>
		</tr>		
		<?		
		}		
		?>
		</tbody>
	</table>
</form>
			

</body>
</html>	